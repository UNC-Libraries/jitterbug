<?php namespace Junebug\Http\Controllers;

use Illuminate\Http\Request;

use Log;

use Junebug\Http\Requests;
use Junebug\Http\Controllers\Controller;
use Junebug\Models\AudioVisualItem;
use Junebug\Models\Cut;
use Junebug\Models\PreservationMaster;
use Junebug\Models\PreservationMasterType;
use Junebug\Models\PreservationMasterCollection;
use Junebug\Models\PreservationMasterFormat;
use Junebug\Models\PreservationMasterDepartment;
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
    $this->middleware('guest');
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
    $item = AudioVisualItem::where('call_number', 
    	$master->callNumber)->get()->first();
    $cuts = Cut::where('preservation_master_id', $master->id)
               ->orderBy('cut_number', 'asc')
               ->get();
    return view('masters.show', compact('master', 'cuts', 'item'));
  }

  public function resolveRange(Request $request)
  {
  	return parent::rangeFor($request, $this->solrMasters);
  }

  public function destroy($id, Request $request)
  {
    

    return redirect()->route('masters.index');
  }


}
