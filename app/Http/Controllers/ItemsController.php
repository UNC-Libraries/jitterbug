<?php
namespace Junebug\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Solarium;

use Junebug\Models\AudioVisualItem;
use Junebug\Models\AudioVisualItemType;
use Junebug\Models\AudioVisualItemCollection;
use Junebug\Models\AudioVisualItemFormat;
use Junebug\Support\SolariumPaginator;

class ItemsController extends Controller
{
  
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }
  
  public function index(Request $request)
  {
    
    $perPage = 20;
    $items = array();

    if ($request->ajax()) {
      $userQueryString = urldecode($request->query('q'));
      $userQuery = json_decode($userQueryString);

      $client = new Solarium\Client(Config::get('solarium'));
      $solariumQuery = $client->createSelect();
      $searchTerms = $userQuery->{'search'};
      $solariumQuery->setQuery($searchTerms);

      $dismax = $solariumQuery->getDisMax();
      if(strlen($searchTerms)==0) {
        $dismax->setQueryAlternative("*:*");
      }
      // Query fields with boost values
      $dismax->setQueryFields('callNumber^5 title^4 collectionName^3 ' .
        'containerNote^2 cutTitles cutPerformerComposers formatName');

      $this->createFilterQueries($solariumQuery,$userQuery);

      $solariumQuery->setRows($perPage);
      $currentPage = $request->query('page');
      if($currentPage == null) {
        $currentPage = 1;
      }
      $start = $perPage * ($currentPage - 1);
      $solariumQuery->setStart($start);

      $resultSet = $client->execute($solariumQuery);

      $items = new SolariumPaginator($resultSet,$perPage,$currentPage);

      return view('items._items', compact('items'));
    }

    $types = AudioVisualItemType::all();
    $collections = AudioVisualItemCollection::all();
    $formats = AudioVisualItemFormat::all();

    return view('items.index', 
        compact('types', 'collections', 'formats'));
  }
  
  public function show($id)
  {
    $item = AudioVisualItem::findOrFail(58661);
    return view('items.show');
  }
  
  public function template()
  {
    return view('items.template');
  }
  
  private function createFilterQueries($solariumQuery, $userQuery)
  {
    $keys = array_keys((array)($userQuery));
    foreach ($keys as $key) {
      if($this->endsWith($key, 'filters')) {
        $filters = $userQuery->{$key};
        if($this->hasFilters($filters)) {
          $filterType = $this->filterType($key);
          $filterQuery = $this->filterQueryFor($filterType . 'Id', $filters);
          $solariumQuery->
            createFilterQuery($filterType . 's')->setQuery($filterQuery);
        }
      }
    }
  }

  private function hasFilters($filterArray)
  {
    return $filterArray[0] != 0;
  }
  
  private function filterType($filterKey)
  {
    return substr($filterKey,0,strlen($filterKey) - strlen("-filters"));
  }

  private function filterQueryFor($field, $filters)
  {
    $filterQuery = $field . ':(';
    $numFilters = count($filters);
    for ($i = 0; $i < $numFilters; $i++) {
      $filter = $filters[$i];
      if ($i != $numFilters - 1) {
        $filterQuery = $filterQuery . $filter . ' OR ';
      } else {
        $filterQuery = $filterQuery . $filter . ')';
      }
    }
    return $filterQuery;
  }

  private function endsWith($haystack, $needle)
  {
    $needleLen = strlen($needle);
    $needleTest = substr($haystack, strlen($haystack) - 
        $needleLen, strlen($haystack));
    return $needleTest == $needle;
  }
}