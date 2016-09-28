<?php namespace Junebug\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Exception;
use Log;
use Session;
use Solarium;
use Uuid;

use Junebug\Http\Controllers\Controller;
use Junebug\Models\AudioVisualItem;
use Junebug\Models\AudioMaster;
use Junebug\Models\BatchPreservationMaster;
use Junebug\Models\Cut;
use Junebug\Models\Department;
use Junebug\Models\FilmMaster;
use Junebug\Models\PmSpeed;
use Junebug\Models\PreservationMaster;
use Junebug\Models\PreservationMasterType;
use Junebug\Models\PreservationMasterCollection;
use Junebug\Models\PreservationMasterFormat;
use Junebug\Models\PreservationMasterDepartment;
use Junebug\Models\Project;
use Junebug\Models\ReproductionMachine;
use Junebug\Models\SamplingRate;
use Junebug\Models\TapeBrand;
use Junebug\Models\Transfer;
use Junebug\Models\VideoMaster;
use Junebug\Http\Requests\MasterRequest;
use Junebug\Support\SolariumProxy;
use Junebug\Support\SolariumPaginator;


class MastersController extends Controller {

  protected $solrMasters;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->solrMasters = new SolariumProxy('junebug-masters');
  }

  /**
   * Show the list of preservation masters and a search interface for
   * filtering and searching.
   */
  public function index(Request $request)
  {
    $masters = array();

    if ($request->ajax()) {
      // The query string consists of search terms and an array of
      // selected filters for each filter list
      $queryString = urldecode($request->query('q'));
      $queryParams = json_decode($queryString);

      $page = $request->query('page');
      $perPage = $request->query('perPage');
      $start = $perPage * ($page - 1);

      $resultSet = $this->solrMasters->query($queryParams,$start,$perPage);
      $masters = new SolariumPaginator($resultSet,$page,$perPage);
      return view('masters._masters', compact('masters', 'start'));
    }

    $types = PreservationMasterType::all();
    $collections = PreservationMasterCollection::all();
    $formats = PreservationMasterFormat::all();
    $departments = PreservationMasterDepartment::all();

    return view('masters.index', 
        compact('types', 'collections', 'formats', 'departments'));
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
      $master->callNumber = $item->callNumber;
      $master->masterableType = $item->type . 'Master';
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
   * Save the details of a new master and its masterable, then update solr.
   */
  public function store(MasterRequest $request)
  {
    $input = $request->all();
    $batch = isset($input['batch']) ? true : false;
    $batchSize = $input['batchSize'];

    $masterId = null;
    $masters = array();

    // Update MySQL
    DB::transaction(
      function () use ($request, $input, $batch, $batchSize, 
                                                   &$masterId, &$masters) {
      // The transaction id will be used by the 'revisionable' package
      // when a model event is fired. We are passing it down via a connection
      // variable.
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      $batchIndex = 0;

      do {
        $masterable = $this->newMasterableInstance($request);
        $masterable->fill($input['masterable']);

        $master = new PreservationMaster;
        $master->masterableType = $input['masterableType'];
        $master->fill($input);

        $masterable->save();
        $master->masterableId = $masterable->id;
        $master->save();
        $masterId = $master->id;
        array_push($masters, $master);

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
    $max = 500;

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
    $masterableType = $first->masterableType;

    $masters = PreservationMaster::whereIn('id', $masterIds)
                            ->where('masterable_type', $masterableType)->get();
    if ($masterIdsCount!==$masters->count()) {
      $request->session()->put('alert', array('type' => 'danger', 'message' => 
        '<strong>Oops! There\'s a problem.</strong> ' . 
        'Batch editing can only be done with masters of the same type. ' .
        'Please change your selection.'));
      return redirect()->route('masters.index');
    }

    $masterableIds = array();
    foreach ($masters as $master) {
      array_push($masterableIds, $master->masterable->id);
    }
    $masterables = $masterableType::whereIn('id', $masterableIds)->get();

    $master = new BatchPreservationMaster($masters, $masterables);

    // Build select lists
    $departments = array();
    if ($master->departmentId === '<mixed>') {
      $departments = ['' => 'Select a department'] + 
                     ['<mixed>' => '<mixed>'] +
                     Department::pluck('name', 'id')->all();
    } else {
      $departments = ['' => 'Select a department'] + 
                     Department::pluck('name', 'id')->all();
    }

    $projects = array();
    if ($master->projectId === '<mixed>') {
      $projects = ['' => 'Select a project'] + 
                     ['<mixed>' => '<mixed>'] +
                     Project::orderBy('name')->pluck('name', 'id')->all();
    } else {
      $projects = ['' => 'Select a project'] + 
                     Project::orderBy('name')->pluck('name', 'id')->all();
    }

    $reproductionMachines = array();
    if ($master->reproductionMachineId === '<mixed>') {
      $reproductionMachines = ['' => 'Select a reproduction machine'] + 
                     ['<mixed>' => '<mixed>'] +
                     ReproductionMachine::pluck('name', 'id')->all();
    } else {
      $reproductionMachines = ['' => 'Select a reproduction machine'] + 
                     ReproductionMachine::pluck('name', 'id')->all();
    }

    $tapeBrands = array();
    if ($master->tapeBrandId === '<mixed>') {
      $tapeBrands = ['' => 'Select a tape brand'] + 
                     ['<mixed>' => '<mixed>'] +
                     TapeBrand::pluck('name', 'id')->all();
    } else {
      $tapeBrands = ['' => 'Select a tape brand'] + 
                     TapeBrand::pluck('name', 'id')->all();
    }

    $samplingRates = array();
    if ($master->samplingRateId === '<mixed>') {
      $samplingRates = ['' => 'Select a sampling rate'] + 
                     ['<mixed>' => '<mixed>'] +
                     SamplingRate::pluck('name', 'id')->all();
    } else {
      $samplingRates = ['' => 'Select a sampling rate'] + 
                     SamplingRate::pluck('name', 'id')->all();
    }

    $pmSpeeds = array();
    if ($master->pmSpeedId === '<mixed>') {
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
    $masterable = $master->masterable;

    $master->fill($input);
    $masterable->fill($input['masterable']); 

    // Update MySQL
    DB::transaction(function () use ($master, $masterable) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      $masterable->save();
      $master->touch();
      $master->save();

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrMasters->update($master);

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Yep.</strong> ' . 
        'Preservation master was successfully updated.'));

    return redirect()->route('masters.show', [$id]);
  }

  /**
   * Update multple masters at once.
   */
  public function batchUpdate(MasterRequest $request)
  {
    $input = $request->allWithoutMixed();
    $masterIds = explode(',', $input['ids']);
    unset($input['ids']);
    $masters = PreservationMaster::whereIn('id',$masterIds)->get();

    // Update MySQL
    DB::transaction(function () use ($masters, $input) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      foreach ($masters as $master) {
        $master->fill($input);
        $master->touch(); // Touch in case not dirty and masterable is dirty
        $masterable=$master->masterable;
        $masterable->fill($input['masterable']);

        $masterable->save();
        $master->save();
      }

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrMasters->update($masters);

    $request->session()->forget('batchMasterIds');

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Woohoo!</strong> ' . 
        'Preservation masters were successfully updated.'));

    return redirect()->route('masters.index');
  }

  public function destroy($id, Request $request)
  {
    

    return redirect()->route('masters.index');
  }

  private function newMasterableInstance(Request $request)
  {
    $masterable = null;
    $masterableType = $request->masterableType;
    if ($masterableType==='AudioMaster') {
      $masterable = new AudioMaster;
    } else if ($masterableType==='FilmMaster') {
      $masterable = new FilmMaster;
    } else if ($masterableType==='VideoMaster') {
      $masterable = new VideoMaster;
    } else {
      throw new Exception('Unknown master type: ' . $masterableType);
    }
    return $masterable;
  }


}
