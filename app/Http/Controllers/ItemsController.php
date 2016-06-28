<?php
namespace Junebug\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Log;
use Session;
use Solarium;
use Uuid;

use Junebug\Models\AudioVisualItem;
use Junebug\Models\AudioVisualItemType;
use Junebug\Models\AudioVisualItemCollection;
use Junebug\Models\AudioVisualItemFormat;
use Junebug\Models\AudioItem;
use Junebug\Models\FilmItem;
use Junebug\Models\VideoItem;
use Junebug\Models\Collection;
use Junebug\Models\Cut;
use Junebug\Models\Format;
use Junebug\Models\Transfer;
use Junebug\Models\PreservationMaster;
use Junebug\Http\Requests\ItemRequest;
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
    DB::enableQueryLog();
    $this->middleware('guest');
  }
  
  public function index(Request $request)
  {
    
    $perPage = 20;
    $items = array();

    if ($request->ajax()) {
      $userQueryString = urldecode($request->query('q'));
      $userQuery = json_decode($userQueryString);

      $client = new Solarium\Client($this->solariumConfigFor('junebug-items'));
      $solariumQuery = $client->createSelect();

      $searchTerms = $userQuery->{'search'};
      $solariumQuery->setQuery($searchTerms);

      $dismax = $solariumQuery->getDisMax();
      if(strlen($searchTerms)==0) {
        $dismax->setQueryAlternative('*:*');
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
      $solariumQuery->addSort('callNumber', $solariumQuery::SORT_ASC);

      $resultSet = $client->execute($solariumQuery);
      
      $items = new SolariumPaginator($resultSet,$perPage,$currentPage);

      return view('items._items', compact('items', 'start'));
    }

    $types = AudioVisualItemType::all();
    $collections = AudioVisualItemCollection::all();
    $formats = AudioVisualItemFormat::all();

    return view('items.index', 
        compact('types', 'collections', 'formats'));
  }
  
  public function show($id)
  {
    $item = AudioVisualItem::findOrFail($id);
    $cuts = Cut::where('call_number', $item->callNumber)
               ->orderBy('preservation_master_id', 'asc')
               ->orderBy('cut_number', 'asc')
               ->get();
    $queries = DB::getQueryLog();
    $lastQuery = end($queries);
    return view('items.show', compact('item', 'cuts'));
  }
  
  public function create() {
    $item = new AudioVisualItem;
    $collections = ['' => 
              'Select a collection'] + Collection::lists('name', 'id');
    $formats = ['' => 'Select a format'] + Format::lists('name', 'id');
    return view('items.create', compact('item', 'collections', 'formats'));
  }

  public function store(ItemRequest $request) {
    $input = $request->all();
    $itemable = $this->newItemableInstance($request);
    $itemable->callNumber = $input['callNumber'];
    $itemable->fill($input['itemable']);

    $item = new AudioVisualItem;
    $item->fill($input);
    $item->itemableType = $input['itemableType'];

    // Update MySQL
    DB::transaction(function () use ($item, $itemable) {
      $transactionId = Uuid::uuid1();
      DB::statement("set @transaction_id = '$transactionId';");
      $itemable->save();

      $item->itemableId = $itemable->id;
      $item->save();

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrUpdate($item);

    Session::flash('alert', array('type' => 'success', 'message' => 
        '<strong>Yesss!</strong> ' . 
        'Audio visual item was successfully created.'));

    return redirect()->route('items.show', [$item->id]);
  }

  public function edit($id)
  {
    $item = AudioVisualItem::findOrFail($id);
    $cuts = Cut::where('call_number', $item->callNumber)
               ->orderBy('preservation_master_id', 'asc')
               ->orderBy('cut_number', 'asc')
               ->get();
    $collections = ['' => 
              'Select a collection'] + Collection::lists('name', 'id');
    $formats = ['' => 'Select a format'] + Format::lists('name', 'id');
    return view('items.edit', 
      compact('item', 'cuts', 'collections', 'formats'));
  }

  public function editBatch()
  {
    // run solarium query to get result set
    // get user selection from query string
    // merge values
    // display
    dd("Batch edit");
  }

  public function update($id, ItemRequest $request)
  {
    $input = $request->all();
    $item = AudioVisualItem::findOrFail($id);
    $itemable = $item->itemable;

    $item->fill($input);
    $itemable->fill($input['itemable']);

    // Update MySQL
    DB::transaction(function () use ($item, $itemable) {
      $transactionId = Uuid::uuid1();
      DB::statement("set @transaction_id = '$transactionId';");

      // Update call number everywhere if it has changed
      if($item->isDirty('call_number')) {
        $itemable->callNumber = $item->callNumber;

        $origCall = $item->getOriginal()['call_number'];
        $newCall = $item->callNumber;

        // Yes, it would be nice if we could use the batch
        // update syntax for this, rather than fetching and
        // iterating over the results, then calling save.
        // Unfortunately, the batch update syntax doesn't
        // fire model events, which we need for auditing.
        $masters = PreservationMaster::where('call_number', '=', 
                                              $origCall)->get();
        foreach ($masters as $master) {
          $master->callNumber = $newCall;
          $master->save();
        }

        $cuts = Cut::where('call_number', '=', $origCall)->get();

        foreach ($cuts as $cut) {
          $cut->callNumber = $newCall;
          $cut->save();
        }

        $transfers = Transfer::where('call_number', '=', $origCall)->get();

        foreach ($transfers as $transfer) {
          $transfer->callNumber = $newCall;
          $transfer->save();
        }

      }

      $itemable->save();
      $item->save();

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrUpdate($item);

    Session::flash('alert', array('type' => 'success', 'message' => 
        '<strong>Hooray!</strong> ' . 
        'Audio visual item was successfully updated.'));

    return redirect()->route('items.show', [$id]);
  }

  public function destroy($id, Request $request)
  {
    $item = AudioVisualItem::findOrFail($id);
    $itemable = $item->itemable;

    $command = $request['deleteCommand'];

    // Update MySQL
    DB::transaction(function () use ($command, $item, $itemable) {
      $transactionId = Uuid::uuid1();
      DB::statement("set @transaction_id = '$transactionId';");
      
      $call = $item->callNumber;
      if($command=='all') {
        $masters = PreservationMaster::where('call_number', '=', 
                                              $call)->get();
        foreach ($masters as $master) {
          $master->masterable->delete();
          $master->delete();
        }

        $cuts = Cut::where('call_number', '=', $call)->get();

        foreach ($cuts as $cut) {
          $cut->delete();
        }

        $transfers = Transfer::where('call_number', '=', $call)->get();

        foreach ($transfers as $transfer) {
          $transfer->transferable->delete();
          $transfer->delete();
        }
      }

      $item->delete();
      $itemable->delete();

      DB::statement('set @transaction_id = null;');      
    });

    $this->solrDelete($item);

    Session::flash('alert', array('type' => 'success', 'message' => 
        '<strong>It\'s done!</strong> ' . 
        "$item->type item was successfully deleted."));

    return redirect()->route('items.index');
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
    return substr($filterKey,0,strlen($filterKey) - strlen('-filters'));
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

  private function newItemableInstance(Request $request)
  {
    $itemable = null;
    $itemableType = $request->itemableType;
    if($itemableType=='AudioItem') {
      $itemable = new AudioItem;
    } else if ($itemableType=='FilmItem') {
      $itemable = new FilmItem;
    } else if ($itemableType=='VideoItem') {
      $itemable = new VideoItem;
    } else {
      throw new Exception('Unknown item type: ' . $itemableType);
    }
    return $itemable;
  }

  // TODO: Use Str::endsWith instead
  private function endsWith($haystack, $needle)
  {
    $needleLen = strlen($needle);
    $needleTest = substr($haystack, strlen($haystack) - 
        $needleLen, strlen($haystack));
    return $needleTest == $needle;
  }

  private function solariumConfigFor($core)
  {
    $config = Config::get('solarium');
    $endpointKeys = array_keys($config);
    $endpointConfig = $config[$endpointKeys[0]];
    $hostKeys = array_keys($endpointConfig);
    $hostConfig = $config[$endpointKeys[0]][$hostKeys[0]];
    $path = $hostConfig['path'];
    $config[$endpointKeys[0]][$hostKeys[0]]['path'] = $path . $core;
    return $config;
  }

  private function solrUpdate($item)
  {
    $client = new Solarium\Client($this->solariumConfigFor('junebug-items'));
    $update = $client->createUpdate();
    $doc = $update->createDocument();

    $doc->setKey('id', $item->id);
    $doc->setField('title', $item->title, null, 'set');
    $doc->setField('containerNote', $item->containerNote, null, 'set');
    $doc->setField('callNumber', $item->callNumber, null, 'set');
    $doc->setField('collectionId', $item->collection->id, null, 'set');
    $doc->setField('collectionName', $item->collection->name, null, 'set');
    $doc->setField('formatId', $item->format->id, null, 'set');
    $doc->setField('formatName', $item->format->name, null, 'set');
    $doc->setField('typeName', $item->type, null, 'set');

    $update->addDocument($doc);
    $update->addCommit();

    return $client->update($update);
  }

  private function solrDelete($item)
  {
    $client = new Solarium\Client($this->solariumConfigFor('junebug-items'));
    $update = $client->createUpdate();
    $update->addDeleteById($item->id);
    $update->addCommit();

    $result = $client->update($update);
  }

}