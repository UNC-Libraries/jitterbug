<?php
namespace Junebug\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

use DB;
use Log;
use Session;
use Solarium;
use Uuid;

use Junebug\Export\ItemsExport;
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
use Junebug\Models\Transfer;
use Junebug\Models\PreservationMaster;
use Junebug\Http\Requests\ItemRequest;
use Junebug\Support\SolariumProxy;
use Junebug\Support\SolariumPaginator;

class ItemsController extends Controller
{
  
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
    $this->solrItems = new SolariumProxy('junebug-items');
    $this->solrMasters = new SolariumProxy('junebug-masters');
    $this->solrTransfers = new SolariumProxy('junebug-transfers');
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
  public function show($id)
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
             'Select a collection'] + Collection::pluck('name', 'id')->all();
    $formats = ['' => 
             'Select a format'] + Format::withFutureUse()->
                                                  pluck('name', 'id')->all();
    return view('items.create', compact('item', 'collections', 'formats'));
  }

  /**
   * Save the details of a new item and its itemable, then update solr.
   */
  public function store(ItemRequest $request)
  {
    $input = $request->all();
    $batch = isset($input['batch']) ? true : false;
    $batchSize = $input['batchSize'];

    $itemId = null;
    $items = array();

    // Update MySQL
    DB::transaction(
      function () use ($request, $input, $batch, $batchSize, 
                                                   &$itemId, &$items) {
      // The transaction id will be used by the 'revisionable' package
      // when a model event is fired. We are passing it down via a connection
      // variable.
      $transactionId = Uuid::uuid4();
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
        $item->itemableType = $input['itemableType'];
        $item->fill($input);
        $item->callNumber = $sequence->callNumber();

        $itemable->save();
        $item->itemableId = $itemable->id;
        $item->save();
        $itemId = $item->id;
        array_push($items, $item);

        $sequence->increase();

      } while ($batch && ++$batchIndex < $batchSize);

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrItems->update($items);

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
              'Select a collection'] + Collection::pluck('name', 'id')->all();
    $formats = ['' => 
              'Select a format'] + Format::pluck('name', 'id')->all();
    return view('items.edit', 
      compact('item', 'cuts', 'collections', 'formats'));
  }

  /**
   * Display the form for editing multiple items at a time.
   */
  public function batchEdit(Request $request)
  {
    $max = 500;

    $itemIds = explode(',', $request->input('ids'));
    // The first time into the batch edit form, the request
    // is POSTed (using jQuery triggered from the Batch Edit
    // dropdown) with an array of item ids. We can't use
    // a GET request because the total size of the all the
    // item ids might possibly exceed what is allowed in
    // url parameters, as well as what is allowed in
    // cookies if we were to go that route. So, we must
    // break with convention (and best practice) by using a
    // POST. However, if the form input fails validation 
    // upon a PUT request to update the values, Laravel 
    // will redirect to the batch edit page using a GET 
    // request, not a POST. There doesn't seem to be a way
    // to force it to use a POST request, so we must be
    // prepared for a GET. We will do this by saving the
    // item ids into a session variable, and then upon post 
    // back get the ids from the session instead of from
    // the request.
    if ($request->method()==='POST') {
      $request->session()->put('batchItemIds',$itemIds);
    } else if ($request->method()==='GET') {
      $itemIds = $request->session()->get('batchItemIds');
    }
    
    // This might happen if the user saves the form successfully
    // and then uses the browser back button to go back to edit
    // the form and the new form submission has validation errors.
    if ($itemIds === null) {
      $request->session()->put('alert', array('type' => 'warning', 'message' =>
        '<strong>Hmm, something\'s up.</strong> ' . 
        'That batch edit form is no longer valid. Please make a ' .
        'new selection and try batch editing again.'));
      return redirect()->route('items.index');
    }

    $itemIdsCount = count($itemIds);

    if ($itemIdsCount > $max) {
      $request->session()->put('alert', array('type' => 'danger', 'message' =>
        '<strong>Whoa there!</strong> ' . 
        'Batch editing is limited to ' . $max . ' items. Please narrow ' .
        'your selection.'));
      return redirect()->route('items.index');
    }
    
    $first = AudioVisualItem::find($itemIds[0]);
    $itemableType = $first->itemableType;

    $items = AudioVisualItem::whereIn('id', $itemIds)
                            ->where('itemable_type', $itemableType)->get();
    if ($itemIdsCount!==$items->count()) {
      $request->session()->put('alert', array('type' => 'danger', 'message' => 
        '<strong>Oops! There\'s a problem.</strong> ' . 
        'Batch editing can only be done with items of the same type. ' .
        'Please change your selection.'));
      return redirect()->route('items.index');
    }

    $itemableIds = array();
    foreach ($items as $item) {
      array_push($itemableIds, $item->itemable->id);
    }
    $itemables = $itemableType::whereIn('id', $itemableIds)->get();

    $item = new BatchAudioVisualItem($items, $itemables);

    $collections = array();
    if ($item->collectionId === '<mixed>') {
      $collections = ['' => 'Select a collection'] + 
                     ['<mixed>' => '<mixed>'] +
                     Collection::pluck('name', 'id')->all();
    } else {
      $collections = ['' => 'Select a collection'] + 
                     Collection::pluck('name', 'id')->all();
    }

    $formats = array();
    if ($item->formatId === '<mixed>') {
      $formats = ['' => 'Select a format'] + 
                 ['<mixed>' => '<mixed>'] +
                 Format::pluck('name', 'id')->all();
    } else {
      $formats = ['' => 'Select a format'] + 
                 Format::pluck('name', 'id')->all();
    }

    return view('items.edit', 
      compact('item', 'collections', 'formats'));

  }

  /**
   * Resolve a range table selection to an array of
   * item ids.
   */
  public function resolveRange(Request $request)
  {
    return parent::rangeFor($request, $this->solrItems);
  }


  public function update($id, ItemRequest $request)
  {
    $input = $request->all();
    $item = AudioVisualItem::findOrFail($id);
    $itemable = $item->itemable;

    $item->fill($input);
    $itemable->fill($input['itemable']);

    $updateSolrMastersAndTransfers = false;
    if ($item->isDirty('call_number') || $item->isDirty('collection_id') ||
                                         $item->isDirty('format_id')) {
      $updateSolrMastersAndTransfers = true;
    }  

    // Update MySQL
    DB::transaction(function () use ($item, $itemable) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      // Update call number everywhere if it has changed
      if($item->isDirty('call_number')) {
        $itemable->callNumber = $item->callNumber;

        $origCall = $item->getOriginal()['callNumber'];
        $newCall = $item->callNumber;

        // Yes, it would be nice (and more performant) if we 
        // could use the batch update syntax for this, rather
        // than fetching and iterating over the results, then
        // calling save. Unfortunately, the batch update 
        // syntax doesn't fire model events, which we need for 
        // auditing.
        $masters = PreservationMaster::where('call_number', $origCall)->get();
        foreach ($masters as $master) {
          $master->callNumber = $newCall;
          $master->save();
        }

        $cuts = Cut::where('call_number', $origCall)->get();

        foreach ($cuts as $cut) {
          $cut->callNumber = $newCall;
          $cut->save();
        }

        $transfers = Transfer::where('call_number', $origCall)->get();

        foreach ($transfers as $transfer) {
          $transfer->callNumber = $newCall;
          $transfer->save();
        }

      }

      $itemable->save();
      $item->touch();
      $item->save();

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrItems->update($item);
    if ($updateSolrMastersAndTransfers) {
      $masters = PreservationMaster::where('call_number', 
                                                  $item->callNumber)->get();
      if ($masters->count() > 0) {
        $this->solrMasters->update($masters);
      }

      $transfers = Transfer::where('call_number', $item->callNumber)->get();
      if ($transfers->count() > 0) {
        $this->solrTransfers->update($transfers);
      }
    }

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Hooray!</strong> ' . 
        'Audio visual item was successfully updated.'));

    return redirect()->route('items.show', [$id]);
  }

  /**
   * Update multple items at once.
   */
  public function batchUpdate(ItemRequest $request)
  {
    $input = $request->allWithoutMixed();
    $itemIds = explode(',', $input['ids']);
    unset($input['ids']);
    $items = AudioVisualItem::whereIn('id',$itemIds)->get();

    // Here we will track items that have had their collection or format
    // updated. Their related preservation masters and transfers will also
    // need to be updated in Solr, since collection and format details are
    // in those cores as well.
    $collectionOrFormatUpdated = array();

    // Update MySQL
    DB::transaction(function () use ($items, $input,
                                              &$collectionOrFormatUpdated) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      foreach ($items as $item) {
        $item->fill($input);
        $item->touch(); // Touch in case not dirty and itemable is dirty
        $itemable=$item->itemable;
        $itemable->fill($input['itemable']);

        if ($item->isDirty('collection_id') ||
            $item->isDirty('format_id')) {
          array_push($collectionOrFormatUpdated, $item);
        }

        $itemable->save();
        $item->save();
      }

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrItems->update($items);
    foreach ($collectionOrFormatUpdated as $item) {
      $masters = 
        PreservationMaster::where('call_number', $item->callNumber)->get();
      if ($masters->count() > 0) {
        $this->solrMasters->update($masters);
      }
      $transfers = 
        Transfer::where('call_number', $item->callNumber)->get();
      if ($transfers->count() > 0) {
        $this->solrTransfers->update($transfers);
      }
    }

    $request->session()->forget('batchItemIds');

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>That was handy!</strong> ' . 
        'Audio visual items were successfully updated.'));

    return redirect()->route('items.index');

  }


  public function destroy($id, Request $request)
  {
    $item = AudioVisualItem::findOrFail($id);
    $itemable = $item->itemable;

    $command = $request->deleteCommand;

    $masters;
    $transfers;

    // Update MySQL
    DB::transaction(function () use ($command, $item, $itemable, 
                                                   &$masters, &$transfers) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      $callNumber = $item->callNumber;
      if ($command==='all') {
        $masters = 
          PreservationMaster::where('call_number', $callNumber)->get();
        foreach ($masters as $master) {
          $master->masterable->delete();
          $master->delete();
        }

        $cuts = Cut::where('call_number', $callNumber)->get();
        foreach ($cuts as $cut) {
          $cut->delete();
        }

        $transfers = Transfer::where('call_number', $callNumber)->get();
        foreach ($transfers as $transfer) {
          $transfer->transferable->delete();
          $transfer->delete();
        }
      }

      $item->delete();
      $itemable->delete();

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrItems->delete($item);
    if ($command==='all') {
      if ($masters !== null) {
        $this->solrMasters->delete($masters);
      }
      if ($transfers !== null) {
        $this->solrTransfers->delete($transfers);
      }
    }

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>It\'s done!</strong> ' . 
        "$item->type item was successfully deleted."));

    return redirect()->route('items.index');
  }


  public function batchDestroy(Request $request)
  {
    $max = 100;

    $itemIds = explode(',', $request->ids);
    $items = AudioVisualItem::whereIn('id',$itemIds)->get();

    if ($items->count() > $max) {
      $request->session()->put('alert', array('type' => 'danger', 'message' =>
        '<strong>Whoa there!</strong> ' . 
        'Batch deleting is limited to ' . $max . ' items. Please narrow ' .
        'your selection.'));
      return redirect()->route('items.index');
    }

    $command = $request->deleteCommand;
    $masters = $transfers = null;

    // Update MySQL
    DB::transaction(function () use ($command, $items,
                                                  &$masters, &$transfers) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
        
      $callNumbers = $items->pluck('call_number')->all();

      if ($command==='all') {
        $masters = 
          PreservationMaster::whereIn('call_number', $callNumbers)->get();
        foreach ($masters as $master) {
          $master->masterable->delete();
          $master->delete();
        }

        $transfers = Transfer::whereIn('call_number', $callNumbers)->get();
        foreach ($transfers as $transfer) {
          $transfer->transferable->delete();
          $transfer->delete();
        }

        $cuts = Cut::whereIn('call_number', $callNumbers)->get();
        foreach ($cuts as $cut) {
          $cut->delete();
        }
      }

      foreach ($items as $item) {
        $itemable = $item->itemable;
        $itemable->delete();
        $item->delete();
      }

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $this->solrItems->delete($items);
    if ($command==='all') {
      if ($masters !== null) {
        $this->solrMasters->delete($masters);
      }
      if ($transfers !== null) {
        $this->solrTransfers->delete($transfers);
      }
    }

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>It\'s done!</strong> ' . 
        "Audio visual items were successfully deleted."));

    return redirect()->route('items.index');
  }

  /**
   * Return the fields that are exportable for the given selection of items.
   */
  public function batchExportFields(Request $request)
  {
    if ($request->ajax()) {
      $itemIds = $request->ids;
      $export = new ItemsExport($itemIds);
      $fields = $export->exportableFields();
      return view('shared._export-fields', compact('fields'));
    }
  }

  public function batchExportExecute(Request $request)
  {
    $itemIds = $request->ids;
    $fields = $request->fields;
    $export = new ItemsExport($itemIds);
    $filePath = $export->build($fields);
    //return response()->download(base_path() . '/storage/app/downloads/ashirk-audio-import.csv');
  }

  private function newItemableInstance(Request $request)
  {
    $itemable = null;
    $itemableType = $request->itemableType;
    if ($itemableType==='AudioItem') {
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