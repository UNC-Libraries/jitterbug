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
use Junebug\Models\BatchAudioVisualItem;
use Junebug\Models\CallNumberSequence;
use Junebug\Models\FilmItem;
use Junebug\Models\VideoItem;
use Junebug\Models\Collection;
use Junebug\Models\Cut;
use Junebug\Models\Format;
use Junebug\Models\TableSelection;
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
  
  /**
   * Show the list of items and a search interface for
   * filtering and searching.
   */
  public function index(Request $request)
  {
    $items = array();

    if ($request->ajax()) {
      $userQueryString = urldecode($request->query('q'));
      $userQuery = json_decode($userQueryString);

      $page = $request->query('page');
      $perPage = $request->query('perPage');
      $start = $perPage * ($page - 1);

      $resultSet = $this->solrQuery($userQuery,$start,$perPage);     
      $items = new SolariumPaginator($resultSet,$page,$perPage);
      return view('items._items', compact('items', 'start'));
    }

    $types = AudioVisualItemType::all();
    $collections = AudioVisualItemCollection::all();
    $formats = AudioVisualItemFormat::all();

    return view('items.index', 
        compact('types', 'collections', 'formats'));
  }
  
  /**
   * Display the details of an item.
   */
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
  
  /**
   * Display the form for creating a new audio, video, or film item.
   */
  public function create()
  {
    $item = new AudioVisualItem;
    $collections = ['' => 
             'Select a collection'] + Collection::lists('name', 'id');
    $formats = ['' => 
             'Select a format'] + Format::withFutureUse()->lists('name', 'id');
    return view('items.create', compact('item', 'collections', 'formats'));
  }

  /**
   * Save the details of an item and its itemable, then update solr.
   */
  public function store(ItemRequest $request)
  {
    $input = $request->all();
    $batch = isset($input['batch']) ? true : false;
    $batchSize = $input['batchSize'];

    $itemId = null;

    // Update MySQL
    DB::transaction(
               function () use ($request, $input, $batch, $batchSize, &$itemId) {
      $transactionId = Uuid::uuid1();
      DB::statement("set @transaction_id = '$transactionId';");
      
      // Get a fresh sequence just to be sure the one we used isn't now stale
      $sequence = 
        CallNumberSequence::next($input['collectionId'], $input['formatId']);

      $itemable = $this->newItemableInstance($request);
      $itemable->callNumber = $sequence->callNumber();
      $itemable->fill($input['itemable']);

      $item = new AudioVisualItem;
      $item->fill($input);
      $item->callNumber = $sequence->callNumber();
      $item->itemableType = $input['itemableType'];

      $itemable->save();
      $item->itemableId = $itemable->id;
      $item->save();
      $itemId = $item->id;

      $sequence->increase();

      // Update Solr
      $this->solrUpdate($item);

      DB::statement('set @transaction_id = null;');      
    });

    if ($batch) {
      $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Yesss!</strong> ' . 
        'Audio visual items were successfully created.'));

      return redirect()->route('items.index');
    } else {
      $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Yesss!</strong> ' . 
        'Audio visual item was successfully created.'));

      return redirect()->route('items.show', [$itemId]);
    }
  }

  /**
   * Display the form for editing an item.
   */
  public function edit($id)
  {
    $item = AudioVisualItem::findOrFail($id);
    $cuts = Cut::where('call_number', $item->callNumber)
               ->orderBy('preservation_master_id', 'asc')
               ->orderBy('cut_number', 'asc')
               ->get();
    $collections = ['' => 
              'Select a collection'] + Collection::lists('name', 'id');
    $formats = ['' => 
              'Select a format'] + Format::lists('name', 'id');
    return view('items.edit', 
      compact('item', 'cuts', 'collections', 'formats'));
  }

  /**
   * Display the form for editing multiple items at a time. The ids
   * of the items to edit are unknown when this method is called. The
   * solr query parameters are passed in the query string which is used
   * to reconstruct the solr result set, from which the ids can be fetched.
   * And a table selection is passed which denotes the items that are selected
   * for editing.
   */
  public function editBatch(Request $request)
  {
    $max = 500;

    $userQuery = json_decode(urldecode($request->query('q')));
    $selection = json_decode($request->query('s'));
    $tableSelection = new TableSelection($selection->begin,$selection->end,
                                  $selection->excludes, $selection->includes);
    if($tableSelection->selectionCount() > $max) {
      $request->session()->put('alert', array('type' => 'danger', 'message' => 
        '<strong>Whoa there!</strong> ' . 
        'Batch editing is limited to ' . $max . ' items. Please narrow your selection.'));
      return redirect()->route('items.index');
    }

    $start = $tableSelection->indexMin();
    $rows = $tableSelection->indexCount();
    $resultSet = $this->solrQuery($userQuery,$start,$rows);
    
    // Iterate through Solr resultSet, getting item ids, while validating
    // that all records are of the same type.
    $itemIds = array();
    $itemTypes = array();
    $queryIndex = $start;
    foreach ($resultSet as $item) {
      if($tableSelection->selected($queryIndex)) {
        array_push($itemIds,$item->id);
        $type = $item->typeName;
        $itemTypes[$type] = $type;
        if(count($itemTypes) > 1) {
          $request->session()->put('alert', 
            array('type' => 'danger', 'message' => 
            '<strong>Oops! There\'s a problem.</strong> ' . 
            'Batch editing can only be done with items of the same type. Please change your selection.'));
          return redirect()->route('items.index');
        }
      }
      $queryIndex++;
    }
    
    $items = AudioVisualItem::whereIn('id',$itemIds)->get();
    $itemableType = $items->first()->itemableType;
    $itemableIds = array();
    foreach($items as $item) {
      array_push($itemableIds, $item->itemable->id);
    }
    $itemables = $itemableType::whereIn('id', $itemableIds)->get();

    $item = new BatchAudioVisualItem($items,$itemables);

    $collections = array();
    if($item->collectionId === '<mixed>') {
      $collections = ['' => 'Select a collection'] + 
                     ['<mixed>' => '<mixed>'] +
                     Collection::lists('name', 'id');
    } else {
      $collections = ['' => 'Select a collection'] + 
                     Collection::lists('name', 'id');
    }

    $formats = array();
    if($item->formatId === '<mixed>') {
      $formats = ['' => 'Select a format'] + 
                 ['<mixed>' => '<mixed>'] +
                 Format::lists('name', 'id');
    } else {
      $formats = ['' => 'Select a format'] + 
                 Format::lists('name', 'id');
    }

    return view('items.edit', 
      compact('item', 'collections', 'formats'));

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

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Hooray!</strong> ' . 
        'Audio visual item was successfully updated.'));

    return redirect()->route('items.show', [$id]);
  }


  public function updateBatch(ItemRequest $request)
  {
    $input = $request->allWithoutMixed();
    $itemIds = explode(',', $input['ids']);
    unset($input['ids']);
    $items = AudioVisualItem::whereIn('id',$itemIds)->get();

    // Update MySQL
    DB::transaction(function () use ($items, $input) {
      $transactionId = Uuid::uuid1();
      DB::statement("set @transaction_id = '$transactionId';");
      
      foreach ($items as $item) {
        $item->fill($input);
        $itemable=$item->itemable;
        $itemable->fill($input['itemable']);

        $itemable->save();
        $item->save();
      }

      DB::statement('set @transaction_id = null;');      
    });    
    
    // Update Solr
    foreach ($items as $item) {
      $this->solrUpdate($item);
    }

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>That was handy!</strong> ' . 
        'Audio visual items were successfully updated.'));

    return redirect()->route('items.index');

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

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>It\'s done!</strong> ' . 
        "$item->type item was successfully deleted."));

    return redirect()->route('items.index');
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

  private function solrQuery($userQuery,$start,$rows)
  {
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

    $solariumQuery->setStart($start);
    $solariumQuery->setRows($rows);
    $solariumQuery->addSort('callNumber', $solariumQuery::SORT_ASC);

    $resultSet = $client->execute($solariumQuery);

    return $resultSet;
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
    $doc->setField('typeId', $item->typeId, null, 'set');

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