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
use Junebug\Support\SolariumProxy;
use Junebug\Support\SolariumPaginator;

class ItemsController extends Controller
{
  
  protected $solrItems;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->solrItems = new SolariumProxy('junebug-items');
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
      // The query string consists of search terms and an array of
      // selected filters for each filter list
      $queryString = urldecode($request->query('q'));
      $queryParams = json_decode($queryString);

      $page = $request->query('page');
      $perPage = $request->query('perPage');
      $start = $perPage * ($page - 1);

      $resultSet = $this->solrItems->query($queryParams,$start,$perPage);
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
  public function show(Request $request, $id)
  {
    $item = AudioVisualItem::findOrFail($id);
    $cuts = Cut::where('call_number', $item->callNumber)
               ->orderBy('preservation_master_id', 'asc')
               ->orderBy('cut_number', 'asc')
               ->get();
    return view('items.show', compact('item', 'cuts'));
  }
  
  /**
   * Display the form for creating a new audio, video, or film item.
   */
  public function create()
  {
    $item = new AudioVisualItem;
    $collections = ['' => 
             'Select a collection'] + Collection::lists('name', 'id')->all();
    $formats = ['' => 
             'Select a format'] + Format::withFutureUse()->
                                                  lists('name', 'id')->all();
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
      
      $batchIndex = 0;

      do {
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
        $this->solrItems->update($item);

      } while ($batch && ++$batchIndex < $batchSize);

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
              'Select a collection'] + Collection::lists('name', 'id')->all();
    $formats = ['' => 
              'Select a format'] + Format::lists('name', 'id')->all();
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

    $queryParams = json_decode(urldecode($request->query('q')));
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
    $resultSet = $this->solrItems->query($queryParams,$start,$rows);
    
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
                     Collection::lists('name', 'id')->all();
    } else {
      $collections = ['' => 'Select a collection'] + 
                     Collection::lists('name', 'id')->all();
    }

    $formats = array();
    if($item->formatId === '<mixed>') {
      $formats = ['' => 'Select a format'] + 
                 ['<mixed>' => '<mixed>'] +
                 Format::lists('name', 'id')->all();
    } else {
      $formats = ['' => 'Select a format'] + 
                 Format::lists('name', 'id')->all();
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
    // TODO Update masters and transfers if call number has changed
    $this->solrItems->update($item);

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
      $this->solrItems->update($item);
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
      if($command==='all') {
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

    $this->solrItems->delete($item);

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>It\'s done!</strong> ' . 
        "$item->type item was successfully deleted."));

    return redirect()->route('items.index');
  }

  private function newItemableInstance(Request $request)
  {
    $itemable = null;
    $itemableType = $request->itemableType;
    if($itemableType==='AudioItem') {
      $itemable = new AudioItem;
    } else if ($itemableType==='FilmItem') {
      $itemable = new FilmItem;
    } else if ($itemableType==='VideoItem') {
      $itemable = new VideoItem;
    } else {
      throw new Exception('Unknown item type: ' . $itemableType);
    }
    return $itemable;
  }

}