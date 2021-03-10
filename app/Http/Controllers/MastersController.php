<?php namespace Jitterbug\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;
use Exception;
use Log;
use Session;
use Solarium;
use Uuid;

use Jitterbug\Export\MastersExport;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\MasterRequest;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\AudioMaster;
use Jitterbug\Models\BatchPreservationMaster;
use Jitterbug\Models\Cut;
use Jitterbug\Models\Department;
use Jitterbug\Models\FilmMaster;
use Jitterbug\Models\Mark;
use Jitterbug\Models\PmSpeed;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Models\PreservationMasterType;
use Jitterbug\Models\PreservationMasterCollection;
use Jitterbug\Models\PreservationMasterFormat;
use Jitterbug\Models\PreservationMasterDepartment;
use Jitterbug\Models\Project;
use Jitterbug\Models\ReproductionMachine;
use Jitterbug\Models\SamplingRate;
use Jitterbug\Models\TapeBrand;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\VideoMaster;
use Jitterbug\Support\SolariumProxy;
use Jitterbug\Support\SolariumPaginator;


class MastersController extends Controller {

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
   * Show the list of preservation masters and a search interface for
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

      $resultSet = $this->solrMasters->query($queryParams, $start, $perPage,$sortColumn, $sortDirection);
      $masters = new SolariumPaginator($resultSet,$page,$perPage);

      $masterIds = array();
      foreach ($masters as $master) {
        $masterIds[] = $master->id;
      }
      $marks = Mark::whereIn('markable_id', $masterIds)
            ->where('markable_type', 'PreservationMaster')
            ->where('user_id', Auth::user()->id)
            ->get()->pluck('markable_id');

      return view('masters._masters',
        compact('masters', 'marks', 'start', 'sortColumn', 'sortDirection'));
    }

    $types = PreservationMasterType::all();
    $collections = PreservationMasterCollection::all();
    $formats = PreservationMasterFormat::all();
    $departments = PreservationMasterDepartment::all();
    $maxEditLimit = PreservationMaster::BATCH_EDIT_MAX_LIMIT;

    return view('masters.index', 
        compact('types', 'collections', 'formats', 'departments', 'maxEditLimit'));
  }

  /**
   * Display the details of a master.
   */
  public function show($id)
  {
    $master = PreservationMaster::findOrFail($id);
    $transfers = $master->transfers()->get();
    $cuts = $master->cuts()->get();
    return view('masters.show', compact('master', 'transfers', 'cuts'));
  }

  /**
   * Display the form for creating a new audio, video, or film master.
   */
  public function create(Request $request)
  {
    $itemId = $request->itemId;
    $item = null;
    if ($itemId !== null) {
      $item = AudioVisualItem::findOrFail($itemId);
    }

    $master = new PreservationMaster;
    $linked = false;
    if($item !== null) {
      $master->call_number = $item->call_number;
      $master->subclass_type = $item->type . 'Master';
      $linked = true;
    }

    $reproductionMachines = ['' => 
             'Select a reproduction machine'] +
             ReproductionMachine::pluck('name', 'id')->all();
    $departments = ['' => 
             'Select a department'] + Department::pluck('name', 'id')->all();
    $projects = ['' => 
             'Select a project'] + Project::orderBy('name')
             ->pluck('name', 'id')->all();
    $samplingRates = ['' => 
             'Select a sampling rate'] +
             SamplingRate::pluck('name', 'id')->all();
    return view('masters.create', 
      compact('master', 'item', 'linked', 'reproductionMachines', 
        'departments', 'projects', 'samplingRates'));
  }

  /**
   * Save the details of a new master and its subclass, then update solr.
   */
  public function store(MasterRequest $request)
  {
    $input = $request->all();
    $batch = isset($input['batch']) ? true : false;
    $batchSize = $input['batch_size'];
    $mark = isset($input['mark']) ? true : false;

    $masterId = null;
    $masters = array();

    // Update MySQL
    DB::transaction(
      function () use ($request, $input, $batch, $batchSize, $mark,
                                                   &$masterId, &$masters) {
      // The transaction id will be used by the 'revisionable' package
      // when a model event is fired. We are passing it down via a connection
      // variable.
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      $batchIndex = 0;

      do {
        $subclass = new $request->subclass_type;
        $subclass->fill($input['subclass']);

        $master = new PreservationMaster;
        $master->subclass_type = $input['subclass_type'];
        $master->fill($input);

        $subclass->save();
        $master->subclass_id = $subclass->id;
        $master->save();
        if ($mark) $master->addMark();

        $masterId = $master->id;
        $masters[] = $master;

      } while ($batch && ++$batchIndex < $batchSize);

      DB::statement('set @transaction_id = null;');
    });

    // Update Solr
    $this->solrMasters->update($masters);

    if ($batch) {
      $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Woot!</strong> ' . 
        'Preservation masters were successfully created.'));

      return redirect()->route('masters.index');
    } else {
      $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Woot!</strong> ' . 
        'Preservation master was successfully created.'));

      return redirect()->route('masters.show', [$masterId]);
    }
  }

  /**
   * Display the form for editing a master.
   */
  public function edit($id)
  {
    $master = PreservationMaster::findOrFail($id);
    $transfers = $master->transfers()->get();
    $cuts = $master->cuts()->get();

    $departments = ['' => 'Select a department'] + 
             Department::pluck('name', 'id')->all();
    $projects = ['' => 'Select a project'] + 
             Project::orderBy('name')->pluck('name', 'id')->all();
    $reproductionMachines = ['' => 'Select a reproduction machine'] +
             ReproductionMachine::pluck('name', 'id')->all();
    $tapeBrands = ['' => 'Select a tape brand'] + 
             TapeBrand::pluck('name', 'id')->all();
    $samplingRates = ['' => 'Select a sampling rate'] +
             SamplingRate::pluck('name', 'id')->all();
    $pmSpeeds = ['' => 'Select a speed'] +
             PmSpeed::pluck('name', 'id')->all();
    return view('masters.edit', 
      compact('master', 'transfers', 'cuts', 'departments', 'projects',
        'reproductionMachines', 'tapeBrands', 'samplingRates', 'pmSpeeds'));
  }

  /**
   * Display the form for editing multiple masters at a time.
   */
  public function batchEdit(Request $request)
  {
    $max = PreservationMaster::BATCH_EDIT_MAX_LIMIT;

    $masterIds = explode(',', $request->input('ids'));
    // See similar in ItemsController.php for comments on the below
    if ($request->method()==='POST') {
      $request->session()->put('batchMasterIds', $masterIds);
    } else if ($request->method()==='GET') {
      $masterIds = $request->session()->get('batchMasterIds');
    }
    
    if ($masterIds === null) {
      $request->session()->put('alert', array('type' => 'warning', 'message' =>
        '<strong>Hmm, something\'s up.</strong> ' . 
        'That batch edit form is no longer valid. Please make a ' .
        'new selection and try batch editing again.'));
      return redirect()->route('masters.index');
    }

    $masterIdsCount = count($masterIds);

    if ($masterIdsCount > $max) {
      $request->session()->put('alert', array('type' => 'danger', 'message' =>
        '<strong>Hold on there.</strong> ' . 
        'Batch editing is limited to ' . $max . ' masters. Please narrow ' .
        'your selection.'));
      return redirect()->route('masters.index');
    }
    
    $first = PreservationMaster::find($masterIds[0]);
    $subclassType = $first->subclass_type;

    $masters = PreservationMaster::whereIn('id', $masterIds)
                            ->where('subclass_type', $subclassType)->get();
    if ($masterIdsCount!==$masters->count()) {
      $request->session()->put('alert', array('type' => 'danger', 'message' => 
        '<strong>Oops! There\'s a problem.</strong> ' . 
        'Batch editing can only be done with masters of the same type. ' .
        'Please change your selection.'));
      return redirect()->route('masters.index');
    }

    $subclassIds = array();
    foreach ($masters as $master) {
      $subclassIds[] = $master->subclass->id;
    }
    $subclasses = $subclassType::whereIn('id', $subclassIds)->get();

    $master = new BatchPreservationMaster($masters, $subclasses);

    // Build select lists
    $departments = array();
    if ($master->department_id === '<mixed>') {
      $departments = ['' => 'Select a department'] + 
                     ['<mixed>' => '<mixed>'] +
                     Department::pluck('name', 'id')->all();
    } else {
      $departments = ['' => 'Select a department'] + 
                     Department::pluck('name', 'id')->all();
    }

    $projects = array();
    if ($master->project_id === '<mixed>') {
      $projects = ['' => 'Select a project'] + 
                     ['<mixed>' => '<mixed>'] +
                     Project::orderBy('name')->pluck('name', 'id')->all();
    } else {
      $projects = ['' => 'Select a project'] + 
                     Project::orderBy('name')->pluck('name', 'id')->all();
    }

    $reproductionMachines = array();
    if ($master->reproduction_machine_id === '<mixed>') {
      $reproductionMachines = ['' => 'Select a reproduction machine'] + 
                     ['<mixed>' => '<mixed>'] +
                     ReproductionMachine::pluck('name', 'id')->all();
    } else {
      $reproductionMachines = ['' => 'Select a reproduction machine'] + 
                     ReproductionMachine::pluck('name', 'id')->all();
    }

    $tapeBrands = array();
    if ($master->tape_brand_id === '<mixed>') {
      $tapeBrands = ['' => 'Select a tape brand'] + 
                     ['<mixed>' => '<mixed>'] +
                     TapeBrand::pluck('name', 'id')->all();
    } else {
      $tapeBrands = ['' => 'Select a tape brand'] + 
                     TapeBrand::pluck('name', 'id')->all();
    }

    $samplingRates = array();
    if ($master->sampling_rate_id === '<mixed>') {
      $samplingRates = ['' => 'Select a sampling rate'] + 
                     ['<mixed>' => '<mixed>'] +
                     SamplingRate::pluck('name', 'id')->all();
    } else {
      $samplingRates = ['' => 'Select a sampling rate'] + 
                     SamplingRate::pluck('name', 'id')->all();
    }

    $pmSpeeds = array();
    if ($master->pm_speed_id === '<mixed>') {
      $pmSpeeds = ['' => 'Select a speed'] + 
                     ['<mixed>' => '<mixed>'] +
                     PmSpeed::pluck('name', 'id')->all();
    } else {
      $pmSpeeds = ['' => 'Select a speed'] + 
                     PmSpeed::pluck('name', 'id')->all();
    }

    return view('masters.edit', 
      compact('master', 'departments', 'projects', 'reproductionMachines',
        'tapeBrands', 'samplingRates', 'pmSpeeds'));

  }

  public function resolveRange(Request $request)
  {
  	return parent::rangeFor($request, $this->solrMasters);
  }

  public function update($id, MasterRequest $request)
  {
    $input = $request->all();
    $master = PreservationMaster::findOrFail($id);
    $subclass = $master->subclass;

    $originalCallNumber = $master->call_number;

    $master->fill($input);
    $subclass->fill($input['subclass']);

    // This will be uncommon
    $callNumberChanged = $master->isDirty('call_number');

    // Update MySQL
    DB::transaction(function () use ($master, $subclass, $callNumberChanged) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      if ($callNumberChanged) {
        $transfers = $master->transfers;
        foreach ($transfers as $transfer) {
          $transfer->call_number = $master->call_number;
          $transfer->save();
        }
        $cuts = $master->cuts;
        foreach ($cuts as $cut) {
          $cut->call_number = $master->call_number;
          $cut->save();
        }
      }

      $subclass->save();
      $master->touch(); // Touch in case not dirty and subclass is dirty
      $master->save();

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    if ($callNumberChanged) {
      // Need to update the original and new related items in Solr in case cuts 
      // were on the original.
      $originalItem = 
        AudioVisualItem::where('call_number', $originalCallNumber)->first();
      $newItem = 
        AudioVisualItem::where('call_number', $master->call_number)->first();
      $this->solrItems->update(array($originalItem, $newItem));
      // Need to update transfers since the call number has changed.
      $this->solrTransfers->update($master->transfers);
    }
    $this->solrMasters->update($master);

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Yep.</strong> ' . 
        'Preservation master was successfully updated.'));

    return redirect()->route('masters.show', [$id]);
  }

  /**
   * Update multiple masters at once.
   */
  public function batchUpdate(MasterRequest $request)
  {
    $input = $request->allWithoutMixed();
    $masterIds = explode(',', $input['ids']);
    unset($input['ids']);
    $masters = PreservationMaster::whereIn('id', $masterIds)->get();

    $callNumberChanged = false;
    // Determine if the call number has changed, which will be uncommon
    if (isset($input['callNumber'])) {
      foreach ($masters as $master) {
        if ($master->call_number !== $input['callNumber']) {
          $callNumberChanged = true;
          break;
        }
      }
    }

    $originalCallNumbers = array();
    $transfersToUpdateInSolr = array();
    // Update MySQL
    DB::transaction(function () use ($masters, $callNumberChanged, $input,
                              &$originalCallNumbers, &$transfersToUpdateInSolr) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      foreach ($masters as $master) {
        $originalCallNumbers[] = $master->call_number;

        $master->fill($input);
        $subclass = $master->subclass;
        $subclass->fill($input['subclass']);

        if ($callNumberChanged) {
          $transfers = $master->transfers;
          foreach ($transfers as $transfer) {
            $transfer->call_number = $master->call_number;
            $transfer->save();
            $transfersToUpdateInSolr[] = $transfer;
          }
          $cuts = $master->cuts;
          foreach ($cuts as $cut) {
            $cut->call_number = $master->call_number;
            $cut->save();
          }
        }

        $subclass->save();
        $master->touch(); // Touch in case not dirty and subclass is dirty
        $master->save();
      }

      DB::statement('set @transaction_id = null;');
    });

    // Update Solr
    if ($callNumberChanged) {
      // Need to update the items core because cuts may have moved from one call
      // number to another
      $items =
        AudioVisualItem::whereIn('call_number', $originalCallNumbers)->get();
      $newItem = 
        AudioVisualItem::where('call_number', $input['callNumber'])->first();
      $items->push($newItem);
      $this->solrItems->update($items);
      // Need to update transfers since the call number has changed.
      $this->solrTransfers->update($transfersToUpdateInSolr);
    }
    $this->solrMasters->update($masters);

    $request->session()->forget('batchMasterIds');

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Woohoo!</strong> ' . 
        'Preservation masters were successfully updated.'));

    return redirect()->route('masters.index');
  }

  public function destroy($id, Request $request)
  {
    $master = PreservationMaster::findOrFail($id);
    $subclass = $master->subclass;

    $command = $request->deleteCommand;

    $transfers = null;
    $cuts = null;

    // Update MySQL
    DB::transaction(function () use ($command, $master, $subclass, 
                                                   &$transfers, &$cuts) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      if ($command==='all') {
        $transfers = $master->transfers;
        foreach ($transfers as $transfer) {
          $transfer->subclass->delete();
          $transfer->removeAllMarks();
          $transfer->delete();
        }

        $cuts = $master->cuts;
        foreach ($cuts as $cut) {
          $cut->delete();
        }
      }

      $master->removeAllMarks();
      $master->delete();
      $subclass->delete();

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrMasters->delete($master);
    if ($command==='all') {
      if ($transfers !== null) {
        $this->solrTransfers->delete($transfers);
      }
      if ($cuts !== null) {
        // Since cuts were deleted, we need to get the audio visual item
        // and update it in Solr to remove the cuts from the index.
        $item = 
          AudioVisualItem::where('call_number', $master->call_number)->first();
        if ($item !== null) {
          $this->solrItems->update($item);
        }

      }
    }

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>It\'s done!</strong> ' . 
        "Preservation master was successfully deleted."));

    return redirect()->route('masters.index');
  }


  public function batchDestroy(Request $request)
  {
    $max = 100;

    $masterIds = explode(',', $request->ids);
    $masters = PreservationMaster::whereIn('id', $masterIds)->get();

    if ($masters->count() > $max) {
      $request->session()->put('alert', array('type' => 'danger', 'message' =>
        '<strong>Whoa there!</strong> ' . 
        'Batch deleting is limited to ' . $max . ' masters. Please narrow ' .
        'your selection.'));
      return redirect()->route('masters.index');
    }

    $command = $request->deleteCommand;
    $transfers = $cuts = null;

    // Update MySQL
    DB::transaction(function () use ($command, $masterIds, $masters,
                                                   &$transfers, &$cuts) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      if ($command==='all') {
        $transfers = 
          Transfer::whereIn('preservation_master_id', $masterIds)->get();
        foreach ($transfers as $transfer) {
          $transfer->subclass->delete();
          $transfer->removeAllMarks();
          $transfer->delete();
        }

        $cuts = Cut::whereIn('preservation_master_id', $masterIds)->get();
        foreach ($cuts as $cut) {
          $cut->delete();
        }
      }

      foreach ($masters as $master) {
        $master->subclass->delete();
        $master->removeAllMarks();
        $master->delete();
      }

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrMasters->delete($masters);
    if ($command==='all') {
      if ($transfers !== null) {
        $this->solrTransfers->delete($transfers);
      }
      if ($cuts !== null) {
        // Since cuts where deleted, we need to get the audio visual items
        // and update them in Solr to remove the cuts from the index.
        $cutCallNumbers = $cuts->pluck('call_number')->unique()->all();
        $items = 
          AudioVisualItem::whereIn('call_number', $cutCallNumbers)->get();
        if ($items !== null) {
          $this->solrItems->update($items);
        }
      }
    }

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>It\'s done!</strong> ' . 
        "Preservation masters were successfully deleted."));

    return redirect()->route('masters.index');
  }

  /**
   * Return the fields that are exportable for the given selection of masters.
   */
  public function batchExportFields(Request $request)
  {
    if ($request->ajax()) {
      $masterIds = explode(',', $request->ids);
      $export = new MastersExport($masterIds);
      $fields = $export->exportableFields();
      return view('shared._data-export-fields', compact('fields'));
    }
  }

  public function batchExportBuild(Request $request)
  {
    if ($request->ajax()) {
      $masterIds = explode(',', $request->ids);
      $fields = $request->fields;
      $export = new MastersExport($masterIds);
      $filePath = $export->build($fields);
      $request->session()->put('exportFilePath', $filePath);
      $response = array('status'=>'success', 'file'=>$filePath);
      return response()->json($response);
    }
  }

}
