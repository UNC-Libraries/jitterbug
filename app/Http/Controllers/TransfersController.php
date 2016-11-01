<?php namespace Junebug\Http\Controllers;

use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Auth;
use DB;
use Log;
use Uuid;

use Junebug\Export\TransfersExport;
use Junebug\Http\Controllers\Controller;
use Junebug\Http\Requests\TransferRequest;
use Junebug\Models\AudioVisualItem;
use Junebug\Models\AudioMaster;
use Junebug\Models\AudioTransfer;
use Junebug\Models\BatchTransfer;
use Junebug\Models\Cut;
use Junebug\Models\PlaybackMachine;
use Junebug\Models\PreservationMaster;
use Junebug\Models\Transfer;
use Junebug\Models\TransferType;
use Junebug\Models\TransferCollection;
use Junebug\Models\TransferFormat;
use Junebug\Models\User;
use Junebug\Models\Vendor;
use Junebug\Support\SolariumProxy;
use Junebug\Support\SolariumPaginator;
use Junebug\Util\CsvReader;
use Junebug\Util\DurationFormat;

class TransfersController extends Controller {

  protected $requiredAudioImportKeys = array(); 
  protected $audioImportKeys = array();

  protected $solrItems;
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

    $this->requiredAudioImportKeys = array('CallNumber', 
      'OriginatorReference', 'Side', 'PlaybackMachine', 'FileSize', 'Duration');
    $this->audioImportKeys = array_merge($this->requiredAudioImportKeys, 
      array('OriginalPm'));

    $this->solrItems = new SolariumProxy('junebug-items');
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

      $resultSet = $this->solrTransfers->query($queryParams, $start, $perPage);
      $transfers = new SolariumPaginator($resultSet, $page, $perPage);
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
   * Display the form for creating a new audio, video, or film master.
   */
  public function create(Request $request)
  {
    $masterId = $request->masterId;
    $master = null;
    if ($masterId !== null) {
      $master = PreservationMaster::findOrFail($masterId);
    }

    $transfer = new Transfer;
    $linked = false;
    if($master !== null) {
      $transfer->preservationMasterId = $master->id;
      $transfer->callNumber = $master->callNumber;
      $transfer->subclassType = $master->type . 'Transfer';
      $linked = true;
    }

    $playbackMachines = ['' => 'Select a playback machine'] +
             PlaybackMachine::orderBy('name')->pluck('name', 'id')->all();
    $engineers = ['' => 'Select an engineer'] + 
             User::engineerList();
    $vendors = ['' => 'Select a vendor'] + 
             Vendor::pluck('name', 'id')->all();
    return view('transfers.create', 
      compact('transfer', 'master', 'linked', 'playbackMachines', 
        'engineers', 'vendors'));
  }

  /**
   * Save the details of a new transfer and its subclass, then update solr.
   */
  public function store(TransferRequest $request)
  {
    $input = $request->all();

    $transfer = null;

    // Update MySQL
    DB::transaction(
      function () use ($request, $input, &$transfer) {

      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      $subclass = new $request->subclassType;
      $subclass->fill($input['subclass']);

      $transfer = new Transfer;
      $transfer->subclassType = $input['subclassType'];
      $master = 
        PreservationMaster::where('id', $input['preservationMasterId'])->first();
      $transfer->callNumber = $master->callNumber;
      $transfer->fill($input);

      $subclass->save();
      $transfer->subclassId = $subclass->id;
      $transfer->save();

      DB::statement('set @transaction_id = null;');
    });

    // Update Solr
    $this->solrTransfers->update($transfer);

    $request->session()->put('alert', array('type' => 'success', 'message' => 
      '<strong>Super!</strong> Transfer was successfully created.'));

    return redirect()->route('transfers.show', [$transfer->id]);
  }

  /**
   * Display the form for editing a master.
   */
  public function edit($id)
  {
    $transfer = Transfer::findOrFail($id);

    $playbackMachines = ['' => 'Select a playback machine'] +
             PlaybackMachine::orderBy('name')->pluck('name', 'id')->all();
    $engineers = ['' => 'Select an engineer'] + 
             User::engineerList();
    if ($transfer->engineerId !== null) {
      $engineer = User::findOrFail($transfer->engineerId);
      if ($engineer->legacy()) {
        $engineers = 
          $engineers + [$engineer->id => $engineer->legacyInitials];
      }
    }
    $vendors = ['' => 'Select a vendor'] + 
             Vendor::pluck('name', 'id')->all();

    return view('transfers.edit', 
      compact('transfer', 'playbackMachines', 'engineers', 'vendors'));
  }

  /**
   * Display the form for editing multiple transfers at a time.
   */
  public function batchEdit(Request $request)
  {
    $max = 500;

    $transferIds = explode(',', $request->input('ids'));
    // See similar in ItemsController.php for comments on the below
    if ($request->method()==='POST') {
      $request->session()->put('batchTransferIds', $transferIds);
    } else if ($request->method()==='GET') {
      $transferIds = $request->session()->get('batchTransferIds');
    }
    
    if ($transferIds === null) {
      $request->session()->put('alert', array('type' => 'warning', 'message' =>
        '<strong>Hmm, something\'s up.</strong> ' . 
        'That batch edit form is no longer valid. Please make a ' .
        'new selection and try batch editing again.'));
      return redirect()->route('transfers.index');
    }

    $transferIdsCount = count($transferIds);

    if ($transferIdsCount > $max) {
      $request->session()->put('alert', array('type' => 'danger', 'message' =>
        '<strong>Hold on there.</strong> ' . 
        'Batch editing is limited to ' . $max . ' transfers. Please narrow ' .
        'your selection.'));
      return redirect()->route('transfers.index');
    }
    
    $first = Transfer::find($transferIds[0]);
    $subclassType = $first->subclassType;

    $transfers = Transfer::whereIn('id', $transferIds)
                            ->where('subclass_type', $subclassType)->get();
    if ($transferIdsCount!==$transfers->count()) {
      $request->session()->put('alert', array('type' => 'danger', 'message' => 
        '<strong>Oops! There\'s a problem.</strong> ' . 
        'Batch editing can only be done with transfers of the same type. ' .
        'Please change your selection.'));
      return redirect()->route('transfers.index');
    }

    $subclassIds = array();
    foreach ($transfers as $transfer) {
      array_push($subclassIds, $transfer->subclass->id);
    }
    $subclasses = $subclassType::whereIn('id', $subclassIds)->get();

    $transfer = new BatchTransfer($transfers, $subclasses);

    // Build select lists
    $playbackMachines = array();
    if ($transfer->playbackMachineId === '<mixed>') {
      $playbackMachines = ['' => 'Select a playback machine'] + 
              ['<mixed>' => '<mixed>'] +
              PlaybackMachine::orderBy('name')->pluck('name', 'id')->all();
    } else {
      $playbackMachines = ['' => 'Select a playback machine'] + 
              PlaybackMachine::orderBy('name')->pluck('name', 'id')->all();
    }

    $engineers = array();
    if ($transfer->engineerId === '<mixed>') {
      $engineers = ['' => 'Select an engineer'] + 
              ['<mixed>' => '<mixed>'] + User::engineerList();
    } else {
      $engineers = ['' => 'Select an engineer'] + 
              User::engineerList();
    }
    if ($transfer->engineerId !== null && $transfer->engineerId !== '<mixed>') {
      $engineer = User::findOrFail($transfer->engineerId);
      if ($engineer->legacy()) {
        $engineers = 
          $engineers + [$engineer->id => $engineer->legacyInitials];
      }
    }

    $vendors = array();
    if ($transfer->vendorId === '<mixed>') {
      $vendors = ['' => 'Select a vendor'] + 
              ['<mixed>' => '<mixed>'] +
              Vendor::pluck('name', 'id')->all();
    } else {
      $vendors = ['' => 'Select a vendor'] + 
              Vendor::pluck('name', 'id')->all();
    }

    return view('transfers.edit', 
      compact('transfer', 'playbackMachines', 'engineers', 'vendors'));

  }

  /**
   * Process an uploaded audio import file and display its contents.
   */
  public function audioImportUpload(Request $request)
  {
    if ($request->ajax()) {
      $dataFile = $request->file('audio-import-file');
      $fileDir = base_path() . '/storage/app/uploads';
      $fileName = Auth::user()->username . '-audio-import-' . fileTimestamp() 
        . '.' . $dataFile->getClientOriginalExtension();
      $dataFile->move($fileDir, $fileName);
      $filePath = $fileDir . '/' . $fileName;
      $request->session()->put('audio-import-file', $filePath);

      $reader = new CsvReader($filePath);
      $data = $reader->fetchKeys($this->audioImportKeys);

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

      $reader = new CsvReader($filePath);
      $data = $reader->fetchKeys($this->audioImportKeys);

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

  public function update(TransferRequest $request, $id)
  {
    $input = $request->all();
    $transfer = Transfer::findOrFail($id);
    $subclass = $transfer->subclass;

    $master = PreservationMaster::findOrFail($input['preservationMasterId']);
    $transfer->callNumber = $master->callNumber;
    $transfer->fill($input);
    $subclass->fill($input['subclass']); 

    // Update MySQL
    DB::transaction(function () use ($transfer, $subclass) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      $subclass->save();
      $transfer->touch();
      $transfer->save();

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrTransfers->update($transfer);

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Success!</strong> Your transfer was updated.'));

    return redirect()->route('transfers.show', [$id]);
  }

  /**
   * Update multple transfers at once.
   */
  public function batchUpdate(TransferRequest $request)
  {
    $input = $request->allWithoutMixed();
    $transferIds = explode(',', $input['ids']);
    unset($input['ids']);
    $transfers = Transfer::whereIn('id',$transferIds)->get();

    // Update MySQL
    DB::transaction(function () use ($transfers, $input) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      foreach ($transfers as $transfer) {
        $transfer->fill($input);
        $transfer->touch(); // Touch in case not dirty and subclass is dirty
        $subclass=$transfer->subclass;
        $subclass->fill($input['subclass']);

        $subclass->save();
        $transfer->save();
      }

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrTransfers->update($transfers);

    $request->session()->forget('batchTransferIds');

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Nice!</strong> ' . 
        'Transfers were successfully updated.'));

    return redirect()->route('transfers.index');
  }

  public function destroy($id, Request $request)
  {
    $transfer = Transfer::findOrFail($id);
    $subclass = $transfer->subclass;

    $cut = null;

    // Update MySQL
    DB::transaction(function () use ($transfer, $subclass, &$cut) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      $cut = $transfer->cut;
      if ($cut !== null) {
        $cut->delete();
      }

      $transfer->delete();
      $subclass->delete();

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrTransfers->delete($transfer);
    if ($cut !== null) {
      // Since a cut was deleted, we need to get the related master and audio
      // visual item and update them in Solr to remove the cut from the index.
      $item = 
        AudioVisualItem::where('call_number', $transfer->callNumber)->first();
      if ($item !== null) {
        $this->solrItems->update($item);
      }
      $master = $transfer->preservationMaster;
      if ($master !== null) {
        $this->solrMasters->update($master);
      }
    }

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Gone!</strong> Transfer was successfully deleted.'));

    return redirect()->route('transfers.index');
  }

  public function batchDestroy(Request $request)
  {
    $max = 100;

    $transferIds = explode(',', $request->ids);
    $transfers = Transfer::whereIn('id', $transferIds)->get();

    if ($transfers->count() > $max) {
      $request->session()->put('alert', array('type' => 'danger', 'message' =>
        '<strong>Whoa there!</strong> ' . 
        'Batch deleting is limited to ' . $max . ' transfers. Please narrow ' .
        'your selection.'));
      return redirect()->route('transfers.index');
    }

    $command = $request->deleteCommand;
    $cuts = null;

    // Update MySQL
    DB::transaction(function () use ($command, $transferIds, 
                                                  $transfers, &$cuts) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      foreach ($transfers as $transfer) {
        $transfer->subclass->delete();
        $transfer->delete();
      }

      $cuts = Cut::whereIn('transfer_id', $transferIds)->get();
      foreach ($cuts as $cut) {
        $cut->delete();
      }

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrTransfers->delete($transfers);

    if ($cuts !== null) {
      // Since cuts where deleted, we need to get the audio visual items
      // and masters and update them in Solr to remove the cuts from the index.
      $cutCallNumbers = $cuts->pluck('call_number')->unique()->all();
      $items = 
        AudioVisualItem::whereIn('call_number', $cutCallNumbers)->get();
      if ($items !== null) {
        $this->solrItems->update($items);
      }
      $masters =
        PreservationMaster::whereIn('call_number', $cutCallNumbers)->get();
      if ($masters !== null) {
        $this->solrMasters->update($masters);
      }
    }

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Voila!</strong> Transfers were successfully deleted.'));

    return redirect()->route('masters.index');
  }

  /**
   * Return the fields that are exportable for the given selection of transfers.
   */
  public function batchExportFields(Request $request)
  {
    if ($request->ajax()) {
      $transferIds = explode(',', $request->ids);
      $export = new TransfersExport($transferIds);
      $fields = $export->exportableFields();
      return view('shared._data-export-fields', compact('fields'));
    }
  }

  public function batchExportBuild(Request $request)
  {
    if ($request->ajax()) {
      $transferIds = explode(',', $request->ids);
      $fields = $request->fields;
      $export = new TransfersExport($transferIds);
      $filePath = $export->build($fields);
      $request->session()->put('exportFilePath', $filePath);
      $response = array('status'=>'success', 'file'=>$filePath);
      return response()->json($response);
    }
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
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      $playbackMachineCache = array();

      foreach($data as $row) {
        $callNumber = $row['CallNumber'];

        // We need to lookup the playback machine record to get the 
        // id. In order to avoid hitting the database, we will utilize
        // a simple cache.
        $playbackMachineName = $row['PlaybackMachine'];
        // Check the cache first for this playback machine record
        $playbackMachine = 
          isset($playbackMachineCache[$playbackMachineName]) ? 
                        $playbackMachineCache[$playbackMachineName] : null;
        // Not in cache, so get from database and add to cache
        if ($playbackMachine === null) {
          $playbackMachine =
            PlaybackMachine::where('name', $playbackMachineName)->first();
          if ($playbackMachine) {
            $playbackMachineCache[$playbackMachineName] = $playbackMachine;
          }
        }
        // Not in cache and not in the database, so create a new record
        if ($playbackMachine === null) {
          $playbackMachine = new PlaybackMachine;
          $playbackMachine->name = $playbackMachineName;
          $playbackMachine->save();
          $created++;
        }

        $originalPm = $row['OriginalPm'];
        
        if (!empty($originalPm)) { 
          // Original PM not empty so this is an update
          $master = PreservationMaster::find($originalPm);
          $master->fileName = $row['OriginatorReference'];
          $master->fileSizeInBytes = $row['FileSize'];
          $master->durationInSeconds = 
            DurationFormat::toSeconds($row['Duration']);
          $master->save();
          array_push($masters, $master);
          $updated++;

          // Update related transfers, which should exist
          $relatedTransfers = $master->transfers()->get();
          if ($relatedTransfers->count() > 0) {
            foreach ($relatedTransfers as $transfer) {
              $transfer->playbackMachineId = $playbackMachine->id;
              // Right now we will assume the person importing is the
              // engineer, but that might change in the future.
              $transfer->engineerId = Auth::user()->id;
              $transfer->save();
              array_push($transfers, $transfer);
              $updated++;
            }
          }

          // Update related cuts, which should exist
          $relatedCuts = $master->cuts()->get();
          if ($relatedCuts->count() > 0) {
            foreach ($relatedCuts as $cut) {
              $cut->side = $row['Side'];
              $cut->save();
              $updated++;
            }
          }
        } else {
          // Original PM is empty, so all new records will be created.
          // For the audio PM, there is nothing to save, we just need the
          // ID for the new PM record.
          $audioMaster = new AudioMaster;
          $audioMaster->save();
          $created++;

          // Create the PM using data from the import.
          $master = new PreservationMaster;
          $master->callNumber = $callNumber;
          $master->fileName = $row['OriginatorReference'];
          $master->fileSizeInBytes = $row['FileSize'];
          $master->durationInSeconds = 
              DurationFormat::toSeconds($row['Duration']);
          $master->subclassType = 'AudioMaster';
          $master->subclassId = $audioMaster->id;
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
          $transfer->callNumber = $callNumber;
          $transfer->playbackMachineId = $playbackMachine->id;
          // Right now we will assume the person importing is the
          // engineer, but that might change in the future.
          $transfer->engineerId = Auth::user()->id;
          $transfer->subclassType = 'AudioTransfer';
          $transfer->subclassId = $audioTransfer->id;
          $transfer->save();
          array_push($transfers, $transfer);
          $created++;

          // Create the Cut
          $cut = new Cut;
          $cut->callNumber = $callNumber;
          $cut->preservationMasterId = $master->id;
          $cut->transferId = $transfer->id;
          $cut->side = $row['Side'];
          $cut->save();
          $created++;

        }

      } // end foreach row

      DB::statement('set @transaction_id = null;');      
    });

    $this->solrMasters->update($masters);
    $this->solrTransfers->update($transfers);

    return array('created' => $created, 'updated' => $updated);
  }

  private function audioImportValidate($data)
  {
    $originatorReferences = array();
    $messages = array();
    foreach($data as $row) {
      $bag = new MessageBag();
      array_push($messages, $bag);
      foreach($this->audioImportKeys as $key) {
        // Validate that all required fields have values
        if (in_array($key, $this->requiredAudioImportKeys) 
          && empty($row[$key])) {
          $bag->add($key, 'A value for ' . $key . ' is required.');
        }
        // Validate file size is an integer
        if ($key==='FileSize' 
          && !empty($row[$key]) && !ctype_digit($row[$key])) {
          $bag->add($key, $key . ' must be an integer.');
        }
        // Validate duration format
        if ($key==='Duration' 
          && !empty($row[$key]) && !DurationFormat::isDuration($row[$key])) {
          $bag->add($key, 
            $key . ' must adhere to the following format: HH:MM:SS.mmm.');
        }
        // Validate call number exists
        if ($key==='CallNumber' 
          && !empty($row[$key]) && !$this->callNumberExists($row[$key])) {
          $bag->add($key, $key . ' must already exist in the database.');
        }
        // Validate originator reference (preservation_master.file_name) 
        // doesn't exist
        if ($key==='OriginatorReference' 
          && !empty($row[$key]) && $this->fileNameExists($row[$key])) {
          $bag->add($key, $key . ' already exists in the database.');
        }
        // Validate originator reference (preservation_master.file_name) 
        // is unqiue amongst values in the rest of the file
        if ($key==='OriginatorReference' 
          && !empty($row[$key]) && in_array($row[$key], $originatorReferences)) {
          $bag->add($key, $key . ' has already been used in this file.');
        } else if ($key==='OriginatorReference' && !empty($row[$key])) {
          array_push($originatorReferences, $row[$key]);
        }
        // Validate pm is an integer
        if ($key==='OriginalPm' 
          && !empty($row[$key]) && !ctype_digit($row[$key])) {
          $bag->add($key, $key . ' must be an integer.');
        }
        // Validate pm belongs to the audio visual item identified by
        // call number
        if ($key==='OriginalPm' 
          && !empty($row[$key]) && !empty($row['CallNumber'])
          && !$this->belongsToItem($row[$key], $row['CallNumber'])) {
          $bag->add($key, $key . ' does not belong to the given call number.');
        }
      }
    }
    return $messages;
  }

  private function callNumberExists($callNumber)
  {
    return AudioVisualItem::where('call_number', 
      $callNumber)->first() !== null;
  }

  private function belongsToItem($pmId, $callNumber)
  {
    $item = AudioVisualItem::where('call_number', $callNumber)->first();
    if ($item != null) {
      $masters = $item->preservationMasters;
      foreach ($masters as $master) {
        if ($master->id == $pmId) {
          return true;
        }
      }
    }
    return false;
  }

  private function fileNameExists($fileName)
  {
    return PreservationMaster::where('file_name', 
      $fileName)->first() !== null;
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
