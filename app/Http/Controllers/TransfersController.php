<?php namespace Jitterbug\Http\Controllers;

use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Auth;
use DB;
use Log;
use Uuid;

use Jitterbug\Export\TransfersExport;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\TransferRequest;
use Jitterbug\Import\AudioImport;
use Jitterbug\Import\Import;
use Jitterbug\Import\VideoImport;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\AudioMaster;
use Jitterbug\Models\AudioTransfer;
use Jitterbug\Models\BatchTransfer;
use Jitterbug\Models\Cut;
use Jitterbug\Models\Mark;
use Jitterbug\Models\PlaybackMachine;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\TransferType;
use Jitterbug\Models\TransferCollection;
use Jitterbug\Models\TransferFormat;
use Jitterbug\Models\User;
use Jitterbug\Models\Vendor;
use Jitterbug\Support\SolariumProxy;
use Jitterbug\Support\SolariumPaginator;
use Jitterbug\Util\CsvReader;
use Jitterbug\Util\DurationFormat;

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

    $this->solrItems = new SolariumProxy('jitterbug-items');
    $this->solrMasters = new SolariumProxy('jitterbug-masters');
    $this->solrTransfers = new SolariumProxy('jitterbug-transfers');
  }

  /**
   * Show the list of transfers and a search interface for
   * filtering and searching.
   */
  public function index(Request $request)
  {
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

      $transferIds = array();
      foreach ($transfers as $transfer) {
        array_push($transferIds, $transfer->id);
      }
      $marks = Mark::whereIn('markable_id', $transferIds)
            ->where('markable_type', 'Transfer')
            ->where('user_id', Auth::user()->id)
            ->get()->pluck('markable_id');

      return view('transfers._transfers', compact('transfers', 'marks', 'start'));
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

      $mark = isset($input['mark']) ? true : false;
      if ($mark) $transfer->addMark();

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
 
      $import = new AudioImport($filePath);
      $data = $import->data();

      $html = view('transfers._audio-import-upload-data', 
                                                compact('data'))->render();
      $response = array('count'=>$import->count(), 'html'=>$html);
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

      $import = new AudioImport($filePath);
      $data = $import->data();
      $messages = $import->validate($data);
      
      $response = array();
      if (Import::hasErrors($messages)) {
        $html = view('transfers._audio-import-errors', 
                                compact('data', 'messages'))->render();
        $response = array('status'=>'error', 'html'=>$html);
      } else {
        $result = $import->execute($data);
        $created = $result['created'];
        $updated = $result['updated'];
        $html = view('transfers._audio-import-success', 
                              compact('created', 'updated'))->render();
        $response = array('status'=>'success', 'html'=>$html);
      }

      return response()->json($response);
    }
  }

  /**
   * Process an uploaded video import file and display its contents.
   */
  public function videoImportUpload(Request $request)
  {
    if ($request->ajax()) {
      $dataFile = $request->file('video-import-file');
      $fileDir = base_path() . '/storage/app/uploads';
      $fileName = Auth::user()->username . '-video-import-' . fileTimestamp() 
        . '.' . $dataFile->getClientOriginalExtension();
      $dataFile->move($fileDir, $fileName);
      $filePath = $fileDir . '/' . $fileName;
      $request->session()->put('video-import-file', $filePath);
 
      $import = new VideoImport($filePath);
      $data = $import->data();

      $html = view('transfers._video-import-upload-data', 
                                                compact('data'))->render();
      $response = array('count'=>$import->count(), 'html'=>$html);
      return response()->json($response);
    }
  }

  /**
   * Validate the contents of an uploaded video import file, then,
   * if it passes validation, carry out the actual import.
   */
  public function videoImportExecute(Request $request)
  {
    if ($request->ajax()) {
      $filePath = $request->session()->get('video-import-file');
      if ($filePath === null) {
        abort(400, 'Import file not found.');
      }

      $import = new VideoImport($filePath);
      $data = $import->data();
      $messages = $import->validate($data);
      
      $response = array();
      if (Import::hasErrors($messages)) {
        $html = view('transfers._video-import-errors', 
                                compact('data', 'messages'))->render();
        $response = array('status'=>'error', 'html'=>$html);
      } else {
        $result = $import->execute($data);
        $created = $result['created'];
        $updated = $result['updated'];
        $html = view('transfers._video-import-success', 
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

  public function update($id, TransferRequest $request)
  {
    $input = $request->all();
    $transfer = Transfer::findOrFail($id);
    $subclass = $transfer->subclass;

    $originalMaster = $transfer->preservationMaster;
    $originalCallNumber = $transfer->callNumber;

    $transfer->fill($input);
    $subclass->fill($input['subclass']);

    $pmChanged = $transfer->isDirty('preservation_master_id');

    // If the preservation master id has been updated, the call number may
    // have changed also, so we need to update the call number and the 
    // associated cut call number.
    $cut = null;
    $newMaster = null;
    if ($pmChanged) {
      // Get the new preservation master
      $newMaster = PreservationMaster::findOrFail($transfer->preservationMasterId);
      $transfer->callNumber = $newMaster->callNumber;

      $cut = $transfer->cut;
      if ($cut !== null) {
        $cut->callNumber = $newMaster->callNumber;
        $cut->preservationMasterId = $newMaster->id;
      }
    }

    // Update MySQL
    DB::transaction(function () use ($transfer, $subclass, $cut) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      // Preservation master has changed
      if ($cut !== null) $cut->save();

      $subclass->save();
      $transfer->touch();
      $transfer->save();

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    if ($pmChanged) {
      // Since cut information is a part of both items and masters Solr
      // cores, we need to update the original item and master to reflect
      // the fact that the cut is no longer on them. And we need to update
      // the new item and master to add the cut.
      $originalItem = 
        AudioVisualItem::where('call_number', $originalCallNumber)->first();
      $newItem = 
        AudioVisualItem::where('call_number', $newMaster->callNumber)->first();
      $this->solrItems->update(array($originalItem, $newItem));
      $this->solrMasters->update(array($originalMaster, $newMaster));
    }
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
    $transfers = Transfer::whereIn('id', $transferIds)->get();

    $pmChanged = false;
    // Determine if PM has been changed
    if (isset($input['preservationMasterId'])) {
      foreach ($transfers as $transfer) {
        if ($transfer->preservationMasterId !== 
             intval($input['preservationMasterId'])) {
          $pmChanged = true;
          break;
        }
      }
    }

    // If the PM has changed, we need to fetch the new PM and also the
    // related audio visual item, because it might have changed as a
    // result.
    $newItem = null;
    $newMaster = null;
    if ($pmChanged) {
      $newMaster = 
        PreservationMaster::findOrFail($input['preservationMasterId']);
      $newItem = 
        AudioVisualItem::where('call_number', $newMaster->callNumber)->first();
    }

    $originaItems = array();
    $originalMasters = array();
    // Update MySQL
    DB::transaction(function () 
      use ($transfers, $pmChanged, $newMaster, $input, &$originaItems, 
        &$originalMasters) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      foreach ($transfers as $transfer) {
        $originalMaster = $transfer->preservationMaster;
        $originalCallNumber = $transfer->callNumber;

        $transfer->fill($input);
        $subclass=$transfer->subclass;
        $subclass->fill($input['subclass']);

        if ($pmChanged) {
          $transfer->callNumber = $newMaster->callNumber;
          $cut = $transfer->cut;
          if ($cut !== null) {
            $cut->preservationMasterId = $newMaster->id;
            $cut->callNumber = $newMaster->callNumber;
            $cut->save();
          }

          $originalItem = 
            AudioVisualItem::where('call_number', $originalCallNumber)->first();
          array_push($originalMasters, $originalMaster);
          array_push($originaItems, $originalItem);
        }

        $subclass->save();
        $transfer->touch(); // Touch in case not dirty and subclass is dirty
        $transfer->save();
      }

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    if ($pmChanged) {
      $this->solrItems->update($originaItems);
      $this->solrItems->update($newItem);
      $this->solrMasters->update($originalMasters);
      $this->solrMasters->update($newMaster);
    }
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

      $transfer->removeAllMarks();
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
        $transfer->removeAllMarks();
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

    return redirect()->route('transfers.index');
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

}
