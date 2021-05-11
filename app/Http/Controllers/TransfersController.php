<?php namespace Jitterbug\Http\Controllers;

use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
use Jitterbug\Models\AudioInstance;
use Jitterbug\Models\AudioTransfer;
use Jitterbug\Models\BatchTransfer;
use Jitterbug\Models\Cut;
use Jitterbug\Models\Mark;
use Jitterbug\Models\PlaybackMachine;
use Jitterbug\Models\PreservationInstance;
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
      $sortColumn = $request->query('sortColumn');
      $sortDirection = $request->query('sortDirection');

      $resultSet = $this->solrTransfers->query($queryParams, $start, $perPage, $sortColumn, $sortDirection);
      $transfers = new SolariumPaginator($resultSet, $page, $perPage);
      $totalRecordCount = $transfers->total() . ' ' . Str::plural('record', $transfers->total());

      $transferIds = array();
      foreach ($transfers as $transfer) {
        $transferIds[] = $transfer->id;
      }
      $marks = Mark::whereIn('markable_id', $transferIds)
            ->where('markable_type', 'Transfer')
            ->where('user_id', Auth::user()->id)
            ->get()->pluck('markable_id');

      return view('transfers._transfers',
        compact('transfers', 'marks', 'start', 'sortColumn', 'sortDirection', 'totalRecordCount'));
    }

    $types = TransferType::all();
    $collections = TransferCollection::all();
    $formats = TransferFormat::all();
    $maxEditLimit = Transfer::BATCH_EDIT_MAX_LIMIT;

    return view('transfers.index', compact('types', 'collections', 'formats', 'maxEditLimit'));
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
   * Display the form for creating a new audio, video, or film instance.
   */
  public function create(Request $request)
  {
    $instanceId = $request->instanceId;
    $instance = null;
    if ($instanceId !== null) {
      $instance = PreservationInstance::findOrFail($instanceId);
    }

    $transfer = new Transfer;
    $linked = false;
    if($instance !== null) {
      $transfer->preservation_instance_id = $instance->id;
      $transfer->call_number = $instance->call_number;
      $transfer->subclass_type = $instance->type . 'Transfer';
      $linked = true;
    }

    $playbackMachines = ['' => 'Select a playback machine'] +
             PlaybackMachine::orderBy('name')->pluck('name', 'id')->all();
    $engineers = ['' => 'Select an engineer'] + 
             User::engineerList();
    $vendors = ['' => 'Select a vendor'] + 
             Vendor::pluck('name', 'id')->all();
    return view('transfers.create', 
      compact('transfer', 'instance', 'linked', 'playbackMachines',
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

      $subclass = new $request->subclass_type;
      $subclass->fill($input['subclass']);

      $transfer = new Transfer;
      $transfer->subclass_type = $input['subclass_type'];
      $instance =
        PreservationInstance::where('id', $input['preservation_instance_id'])->first();
      $transfer->call_number = $instance->call_number;
      $transfer->fill($input);

      $subclass->save();
      $transfer->subclass_id = $subclass->id;
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
   * Display the form for editing a transfer.
   */
  public function edit($id)
  {
    $transfer = Transfer::findOrFail($id);

    $playbackMachines = ['' => 'Select a playback machine'] +
             PlaybackMachine::orderBy('name')->pluck('name', 'id')->all();
    $engineers = ['' => 'Select an engineer'] + 
             User::engineerList($transfer->engineer_id);
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
    $max = Transfer::BATCH_EDIT_MAX_LIMIT;

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
    $subclassType = $first->subclass_type;

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
      $subclassIds[] = $transfer->subclass->id;
    }
    $subclasses = $subclassType::whereIn('id', $subclassIds)->get();

    $transfer = new BatchTransfer($transfers, $subclasses);

    // Build select lists
    $playbackMachines = array();
    if ($transfer->playback_machine_id === '<mixed>') {
      $playbackMachines = ['' => 'Select a playback machine'] + 
              ['<mixed>' => '<mixed>'] +
              PlaybackMachine::orderBy('name')->pluck('name', 'id')->all();
    } else {
      $playbackMachines = ['' => 'Select a playback machine'] + 
              PlaybackMachine::orderBy('name')->pluck('name', 'id')->all();
    }

    $engineers = array();
    if ($transfer->engineer_id === '<mixed>') {
      $engineers = ['' => 'Select an engineer'] + 
              ['<mixed>' => '<mixed>'] + User::engineerList();
    } else {
      $engineers = ['' => 'Select an engineer'] + 
              User::engineerList($transfer->engineer_id);
    }

    $vendors = array();
    if ($transfer->vendor_id === '<mixed>') {
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
      $fileDir = env('STORAGE_PATH', base_path() . '/storage') . '/app/uploads';
      $fileName = Auth::user()->username . '-audio-import-' . fileTimestamp() 
        . '.' . $dataFile->getClientOriginalExtension();
      $dataFile->move($fileDir, $fileName);
      $filePath = $fileDir . '/' . $fileName;
      $request->session()->put('audio-import-file', $filePath);
 
      $import = new AudioImport($filePath);
      $data = $import->data();
      $possibleDataKeys = Transfer::AUDIO_IMPORT_KEYS;
      $tableType = 'audio';

      $html = view('shared._import-upload-data',
                                                compact('data', 'possibleDataKeys', 'tableType'))->render();
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
      $tableType = 'audio';
      if (Import::hasErrors($messages)) {
        $possibleDataKeys = Transfer::AUDIO_IMPORT_KEYS;
        $html = view('shared._import-errors',
                                compact('data', 'messages', 'possibleDataKeys', 'tableType'))->render();
        $response = array('status'=>'error', 'html'=>$html);
      } else {
        $result = $import->execute($data);
        $created = $result['created'];
        $updated = $result['updated'];
        $html = view('shared._import-success',
                              compact('created', 'updated', 'tableType'))->render();
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
      $fileDir = env('STORAGE_PATH', base_path() . '/storage') . '/app/uploads';
      $fileName = Auth::user()->username . '-video-import-' . fileTimestamp() 
        . '.' . $dataFile->getClientOriginalExtension();
      $dataFile->move($fileDir, $fileName);
      $filePath = $fileDir . '/' . $fileName;
      $request->session()->put('video-import-file', $filePath);
 
      $import = new VideoImport($filePath);
      $data = $import->data();
      $possibleDataKeys = Transfer::VIDEO_IMPORT_KEYS;
      $tableType = 'video';

      $html = view('shared._import-upload-data',
                                                compact('data', 'possibleDataKeys', 'tableType'))->render();
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
      $tableType = 'video';
      if (Import::hasErrors($messages)) {
        $possibleDataKeys = Transfer::VIDEO_IMPORT_KEYS;
        $html = view('shared._import-errors',
                                compact('data', 'messages', 'possibleDataKeys', 'tableType'))->render();
        $response = array('status'=>'error', 'html'=>$html);
      } else {
        $result = $import->execute($data);
        $created = $result['created'];
        $updated = $result['updated'];
        $html = view('shared._import-success',
                              compact('created', 'updated', 'tableType'))->render();
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

    $originalInstance = $transfer->preservationInstance;
    $originalCallNumber = $transfer->call_number;

    $transfer->fill($input);
    $subclass->fill($input['subclass']);

    $pmChanged = $transfer->isDirty('preservation_instance_id');

    // If the preservation instance id has been updated, the call number may
    // have changed also, so we need to update the call number and the 
    // associated cut call number.
    $cut = null;
    $newInstance = null;
    if ($pmChanged) {
      // Get the new preservation instance
      $newInstance = PreservationInstance::findOrFail($transfer->preservation_instance_id);
      $transfer->call_number = $newInstance->call_number;

      $cut = $transfer->cut;
      if ($cut !== null) {
        $cut->call_number = $newInstance->call_number;
        $cut->preservation_instance_id = $newInstance->id;
      }
    }

    // Update MySQL
    DB::transaction(function () use ($transfer, $subclass, $cut) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      // Preservation instance has changed
      if ($cut !== null) $cut->save();

      $subclass->save();
      $transfer->touch();
      $transfer->save();

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    if ($pmChanged) {
      // Since cut information is a part of both items and instances Solr
      // cores, we need to update the original item and instance to reflect
      // the fact that the cut is no longer on them. And we need to update
      // the new item and instance to add the cut.
      $originalItem = 
        AudioVisualItem::where('call_number', $originalCallNumber)->first();
      $newItem = 
        AudioVisualItem::where('call_number', $newInstance->call_number)->first();
      $this->solrItems->update(array($originalItem, $newItem));
      $this->solrMasters->update(array($originalInstance, $newInstance));
    }
    $this->solrTransfers->update($transfer);

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Success!</strong> Your transfer was updated.'));

    return redirect()->route('transfers.show', [$id]);
  }

  /**
   * Update multiple transfers at once.
   */
  public function batchUpdate(TransferRequest $request)
  {
    $input = $request->allWithoutMixed();
    $transferIds = explode(',', $input['ids']);
    unset($input['ids']);
    $transfers = Transfer::whereIn('id', $transferIds)->get();

    $pmChanged = false;
    // Determine if PM has been changed
    if (isset($input['preservation_instance_id'])) {
      foreach ($transfers as $transfer) {
        if ($transfer->preservation_instance_id !== (int) $input['preservation_instance_id']) {
          $pmChanged = true;
          break;
        }
      }
    }

    // If the PM has changed, we need to fetch the new PM and also the
    // related audio visual item, because it might have changed as a
    // result.
    $newItem = null;
    $newInstance = null;
    if ($pmChanged) {
      $newInstance =
        PreservationInstance::findOrFail($input['preservation_instance_id']);
      $newItem = 
        AudioVisualItem::where('call_number', $newInstance->call_number)->first();
    }

    $originalItems = array();
    $originalInstances = array();
    // Update MySQL
    DB::transaction(function () 
      use ($transfers, $pmChanged, $newInstance, $input, &$originalItems,
        &$originalInstances) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      foreach ($transfers as $transfer) {
        $originalInstance = $transfer->preservationInstance;
        $originalCallNumber = $transfer->call_number;

        $transfer->fill($input);
        $subclass=$transfer->subclass;
        $subclass->fill($input['subclass']);

        if ($pmChanged) {
          $transfer->call_number = $newInstance->call_number;
          $cut = $transfer->cut;
          if ($cut !== null) {
            $cut->preservation_instance_id = $newInstance->id;
            $cut->call_number = $newInstance->call_number;
            $cut->save();
          }

          $originalItem = 
            AudioVisualItem::where('call_number', $originalCallNumber)->first();
          $originalInstances[] = $originalInstance;
          $originalItems[] = $originalItem;
        }

        $subclass->save();
        $transfer->touch(); // Touch in case not dirty and subclass is dirty
        $transfer->save();
      }

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    if ($pmChanged) {
      $this->solrItems->update($originalItems);
      $this->solrItems->update($newItem);
      $this->solrMasters->update($originalInstances);
      $this->solrMasters->update($newInstance);
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
      // Since a cut was deleted, we need to get the related instance and audio
      // visual item and update them in Solr to remove the cut from the index.
      $item = 
        AudioVisualItem::where('call_number', $transfer->call_number)->first();
      if ($item !== null) {
        $this->solrItems->update($item);
      }
      $instance = $transfer->preservationInstance;
      if ($instance !== null) {
        $this->solrMasters->update($instance);
      }
    }

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Gone!</strong> Transfer was successfully deleted.'));

    return redirect()->route('transfers.index');
  }

  public function batchDestroy(Request $request)
  {
    $max = Transfer::BATCH_EDIT_MAX_LIMIT;

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

      $cuts = Cut::whereIn('transfer_id', $transferIds)->get();
      foreach ($cuts as $cut) {
        $cut->delete();
      }
      
      foreach ($transfers as $transfer) {
        $transfer->subclass->delete();
        $transfer->removeAllMarks();
        $transfer->delete();
      }

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrTransfers->delete($transfers);

    if ($cuts !== null) {
      // Since cuts where deleted, we need to get the audio visual items
      // and instances and update them in Solr to remove the cuts from the index.
      $cutCallNumbers = $cuts->pluck('call_number')->unique()->all();
      $items = 
        AudioVisualItem::whereIn('call_number', $cutCallNumbers)->get();
      if ($items !== null) {
        $this->solrItems->update($items);
      }
      $instances =
        PreservationInstance::whereIn('call_number', $cutCallNumbers)->get();
      if ($instances !== null) {
        $this->solrMasters->update($instances);
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
