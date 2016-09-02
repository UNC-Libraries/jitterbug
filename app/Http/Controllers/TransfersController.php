<?php namespace Junebug\Http\Controllers;

use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Auth;
use Log;

use Junebug\Http\Controllers\Controller;
use Junebug\Models\AudioVisualItem;
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

  protected $solrTransfers;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
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

      $messages = array();
      foreach($data as $row) {
        $bag = new MessageBag();
        array_push($messages, $bag);
        foreach($keys as $key) {
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
            $bag->add($key, $key . ' does not exist in the database.');
          }
        }
      }

      $response = array();
      if($this->hasErrors($messages)) {
        $html = view('transfers._audio-import-errors', 
                                compact('data', 'messages'))->render();
        $response = array('status'=>'error', 'html'=>$html);
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

  private function isDuration($duration)
  {
    // HH:MM:SS.mmm
    $pattern = '/^(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9](.?[0-9]{1,3}?)?$/';
    if (preg_match($pattern, $duration) === 1) {
      return true;
    }
    return false;
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
