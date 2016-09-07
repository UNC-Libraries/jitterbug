<?php namespace Junebug\Http\Controllers;

use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Auth;
use Log;
use DB;
use Uuid;

use Junebug\Http\Controllers\Controller;
use Junebug\Models\AudioVisualItem;
use Junebug\Models\AudioMaster;
use Junebug\Models\AudioTransfer;
use Junebug\Models\Cut;
use Junebug\Models\PlaybackMachine;
use Junebug\Models\PreservationMaster;
use Junebug\Models\Transfer;
use Junebug\Models\TransferType;
use Junebug\Models\TransferCollection;
use Junebug\Models\TransferFormat;
use Junebug\Support\SolariumProxy;
use Junebug\Support\SolariumPaginator;
use Junebug\Util\CsvReader;

class TransfersController extends Controller {

  const AUDIO_IMPORT_KEYS = array('CallNumber', 'OriginatorReference', 'Side',
        'PlaybackMachine', 'FileSize', 'Duration');

  protected $solrMasters;
  protected $solrTransfers;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->solrMasters = new SolariumProxy('junebug-masters');
    $this->solrTransfers = new SolariumProxy('junebug-transfers');
  }

  /**
   * Show the list of transfers and a search interface for
   * filtering and searching.
   */
  public function index(Request $request)
  {
    $transfers = array();

    if ($request->ajax()) {
      // The query string consists of search terms and an array of
      // selected filters for each filter list
      $queryString = urldecode($request->query('q'));
      $queryParams = json_decode($queryString);

      $page = $request->query('page');
      $perPage = $request->query('perPage');
      $start = $perPage * ($page - 1);

      $resultSet = $this->solrTransfers->query($queryParams,$start,$perPage);
      $transfers = new SolariumPaginator($resultSet,$page,$perPage);
      return view('transfers._transfers', compact('transfers', 'start'));
    }

    $types = TransferType::all();
    $collections = TransferCollection::all();
    $formats = TransferFormat::all();

    return view('transfers.index', compact('types', 'collections', 'formats'));
  }

  /**
   * Display the details of a transfer.
   */
  public function show($id)
  {
    $transfer = Transfer::findOrFail($id);
    return view('transfers.show', compact('transfer'));
  }

  /**
   * Process an uploaded audio import file and display its contents.
   */
  public function audioImportUpload(Request $request)
  {
    if ($request->ajax()) {
      $dataFile = $request->file('audio-import-file');
      $fileDir = base_path() . '/uploads';
      $fileName = Auth::user()->username . '-audio-import.' 
        . $dataFile->getClientOriginalExtension();
      $dataFile->move($fileDir, $fileName);
      $filePath = $fileDir . '/' . $fileName;
      $request->session()->put('audio-import-file', $filePath);

      $reader = new CsvReader($filePath);
      $data = $reader->fetchKeys(self::AUDIO_IMPORT_KEYS);

      $count = count($data);
      $html = view('transfers._audio-import-upload-data', 
                                                compact('data'))->render();
      $response = array('count'=>$count, 'html'=>$html);
      return response()->json($response);
    }
  }

  /**
   * Validate the contents of an uploaded audio import file, then,
   * if it passes validation, carry out the actual import.
   */
  public function audioImportExecute(Request $request)
  {
    if ($request->ajax()) {
      $filePath = $request->session()->get('audio-import-file');
      if ($filePath === null) {
        abort(400, 'Import file not found.');
      }

      $keys = self::AUDIO_IMPORT_KEYS;

      $reader = new CsvReader($filePath);
      $data = $reader->fetchKeys($keys);

      $messages = $this->audioImportValidate($data);
      
      $response = array();
      if($this->hasErrors($messages)) {
        $html = view('transfers._audio-import-errors', 
                                compact('data', 'messages'))->render();
        $response = array('status'=>'error', 'html'=>$html);
      } else {
        $result = $this->audioImportDo($data);
        $created = $result['created'];
        $updated = $result['updated'];
        $html = view('transfers._audio-import-success', 
                              compact('created', 'updated'))->render();
        $response = array('status'=>'success', 'html'=>$html);
      }

      return response()->json($response);
    }
  }

  public function resolveRange(Request $request)
  {
    return parent::rangeFor($request, $this->solrTransfers);
  }

  public function destroy($id, Request $request)
  {
    return redirect()->route('transfers.index');
  }

  private function audioImportDo($data)
  {
    // Keep track of which masters and transfers to update in Solr
    $masters = array();
    $transfers = array();
    $created = $updated = 0;

    // Update MySQL
    DB::transaction( function () 
      use ($data, &$masters, &$transfers, &$created, &$updated) {
      $transactionId = Uuid::uuid1();
      DB::statement("set @transaction_id = '$transactionId';");

      foreach($data as $row) {
        $callNumber = $row['CallNumber'];

        // Look up the playback machine using the name. If it 
        // doesn't exist create a new record.
        $playbackMachine =
          PlaybackMachine::where('name', 
            $row['PlaybackMachine'])->get()->first();
        if ($playbackMachine === null) {
          $playbackMachine = new PlaybackMachine;
          $playbackMachine->name = $row['PlaybackMachine'];
          $playbackMachine->save();
          $created++;
        }

        $preservationMasters = PreservationMaster::where('call_number', 
                                           $callNumber)->get();
        if ($preservationMasters->count() > 0) {
          // If there are multiple preservation masters with this
          // call number, update them all with the import data
          foreach($preservationMasters as $master) {
            $master->fileName = $row['OriginatorReference'];
            $master->fileSizeInBytes = $row['FileSize'];
            $master->durationInSeconds = 
              $this->toDurationInSeconds($row['Duration']);
            $master->save();
            array_push($masters, $master);
            $updated++;

            $transfers = 
              Transfer::where('preservation_master_id', $master->id)->get();
            foreach($transfers as $transfer) {
              $transfer->playbackMachineId = $playbackMachine->id;
              $transfer->save();
              array_push($transfers, $transfer);
              $updated++;
            }

            $cuts = Cut::where('preservation_master_id', $master->id)->get();
            foreach($cuts as $cut) {
              $cut->side = $row['Side'];
              $cut->save();
              $updated++;
            }

          }

        } else {
          // There are no preservation masters for the given call number,
          // and so there are no transfers or cuts. Create them.

          // For the audio PM, Nothing to save, we just need the
          // ID for the new PM record.
          $audioMaster = new AudioMaster;
          $audioMaster->save();
          $created++;

          // Create the PM using data from the import.
          $master = new PreservationMaster;
          $master->callNumber = $row['CallNumber'];
          $master->fileName = $row['OriginatorReference'];
          $master->fileSizeInBytes = $row['FileSize'];
          $master->durationInSeconds = 
              $this->toDurationInSeconds($row['Duration']);
          $master->masterableType = 'AudioMaster';
          $master->masterableId = $audioMaster->id;
          $master->save();
          array_push($masters, $master);
          $created++;

          // Again, there's really no information to import
          // here, we just need a new id for the Transfer.
          $audioTransfer = new AudioTransfer;
          $audioTransfer->save();
          $created++;

          // Create the Transfer
          $transfer = new Transfer;
          $transfer->preservationMasterId = $master->id;
          $transfer->callNumber = $row['CallNumber'];
          $transfer->playbackMachineId = $playbackMachine->id;
          // Right now we will assume the person importing is the
          // engineer, but that might change in the future.
          $transfer->engineerId = Auth::user()->id;
          $transfer->transferableType = 'AudioTransfer';
          $transfer->transferableId = $audioTransfer->id;
          $transfer->save();
          array_push($transfers, $transfer);
          $created++;

          // Create the Cut
          $cut = new Cut;
          $cut->callNumber = $row['CallNumber'];
          $cut->preservationMasterId = $master->id;
          $cut->transferId = $transfer->id;
          $cut->side = $row['Side'];
          $cut->save();
          $created++;
        }
      }

      DB::statement('set @transaction_id = null;');      
    });

    $this->solrMasters->update($masters);
    $this->solrTransfers->update($transfers);

    return array('created' => $created, 'updated' => $updated);
  }

  private function audioImportValidate($data)
  {
    $messages = array();
    foreach($data as $row) {
      $bag = new MessageBag();
      array_push($messages, $bag);
      foreach(self::AUDIO_IMPORT_KEYS as $key) {
        // Validate that all fields have values
        if (!isset($row[$key]) || $row[$key] === '') {
          $bag->add($key, 'A value for ' . $key . ' is required.');
        }
        // Validate file size is an integer
        if ($key==='FileSize' 
          && isset($row[$key]) && !ctype_digit($row[$key])) {
          $bag->add($key, $key . ' must be an integer.');
        }
        // Validate duration format
        if ($key==='Duration' 
          && isset($row[$key]) && !$this->isDuration($row[$key])) {
          $bag->add($key, 
            $key . ' must adhere to the following format: HH:MM:SS.mmm.');
        }
        // Validate call number exists
        if ($key==='CallNumber' 
          && isset($row[$key]) && !$this->callNumberExists($row[$key])) {
          $bag->add($key, $key . ' must already exist in the database.');
        }
        // Validate originator reference (preservation_master.file_name) 
        // doesn't exist
        if ($key==='OriginatorReference' 
          && isset($row[$key]) && $this->fileNameExists($row[$key])) {
          $bag->add($key, $key . ' already exists in the database.');
        }
      }
    }
    return $messages;
  }

  private function isDuration($duration)
  {
    // HH:MM:SS.mmm
    $pattern = '/^(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9](.?[0-9]{1,3}?)?$/';
    if (preg_match($pattern, $duration) === 1) {
      return true;
    }
    return false;
  }

  /**
   * Get duration in seconds from a duration in HH:MM:SS.mmm format. 
   */
  private function toDurationInSeconds($duration)
  {
    $hasMilliseconds = strpos($duration, '.') != false;
    $milliseconds = '';
    if ($hasMilliseconds) {
      $milliseconds = substr($duration, strpos($duration, '.'));
    }
    $durationWithoutMilliseconds = substr($duration, 0, strlen($duration) - strlen($milliseconds));
    $durationParts = explode(':', $durationWithoutMilliseconds);
    $hours = $minutes = $seconds = $totalSeconds = 0;
    if (count($durationParts) === 3) {
      $hours = $durationParts[0];
      $minutes = $durationParts[1];
      $seconds = $durationParts[2];
    } else if (count($durationParts) === 2) {
      $minutes = $durationParts[0];
      $seconds = $durationParts[1];
    } else {
      $seconds = $durationParts[0];
    }
    $totalSeconds = $hours * 60 * 60;
    $totalSeconds = $totalSeconds + ($minutes * 60);
    $totalSeconds = $totalSeconds + $seconds;
    return $totalSeconds;
  }

  private function callNumberExists($callNumber)
  {
    return AudioVisualItem::where('call_number', 
      $callNumber)->get()->first() !== null;
  }

  private function fileNameExists($fileName)
  {
    return PreservationMaster::where('file_name', 
      $fileName)->get()->first() !== null;
  }

  private function hasErrors($messageBags)
  {
    foreach($messageBags as $bag) {
      if ($bag->any()) {
        return true;
      }
    }
    return false;
  }

}
