<?php namespace Junebug\Http\Controllers;

use Illuminate\Http\Request;

use Log;

use Junebug\Http\Controllers\Controller;
use Junebug\Models\Transfer;
use Junebug\Models\TransferType;
use Junebug\Models\TransferCollection;
use Junebug\Models\TransferFormat;
use Junebug\Support\SolariumProxy;
use Junebug\Support\SolariumPaginator;

class TransfersController extends Controller {

  protected $solrTransfers;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
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


  public function resolveRange(Request $request)
  {
  	return parent::rangeFor($request, $this->solrTransfers);
  }

  public function destroy($id, Request $request)
  {
    

    return redirect()->route('transfers.index');
  }


}
