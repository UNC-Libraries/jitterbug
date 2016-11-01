<?php

namespace Junebug\Http\Controllers;

use Auth;
use DB;
use Log;
use Uuid;

use Illuminate\Http\Request;

use Junebug\Http\Requests\CutRequest;
use Junebug\Models\AudioVisualItem;
use Junebug\Models\Cut;
use Junebug\Models\PreservationMaster;
use Junebug\Models\Transfer;
use Junebug\Support\SolariumProxy;

class CutsController extends Controller
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
   * Display the details of a cut.
   */
  public function show(Request $request, $masterId, $cutId)
  {
    $master = PreservationMaster::findOrFail($masterId);
    $cut = Cut::findOrFail($cutId);
    $transfer = $cut->transfer;
    return view('masters.cuts.show', compact('master', 'cut', 'transfer'));
  }

  /**
   * Display the form for creating a new cut.
   */
  public function create(Request $request)
  {
    $transfer = Transfer::findOrFail($request->transferId);
    $master = $transfer->preservationMaster;
    $cut = new Cut;
    $cut->callNumber = $transfer->callNumber;
    $cut->preservationMasterId = $transfer->preservationMasterId;
    $cut->transferId = $transfer->id;

    return view('masters.cuts.create', compact('cut', 'master', 'transfer'));
  }

  /**
   * Save the details of a new cut.
   */
  public function store(CutRequest $request)
  {
    $cut = null;

    // Update MySQL
    DB::transaction(
      function () use ($request, &$cut) {

      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      $cut = new Cut;
      $cut->fill($request->all());
      $cut->save();

      DB::statement('set @transaction_id = null;');
    });

    // Update Solr
    $item = AudioVisualItem::where('call_number', $cut->callNumber)->first();
    $this->solrItems->update($item);
    $this->solrMasters->update($cut->preservationMaster);
    $this->solrTransfers->update($cut->transfer);

    $request->session()->put('alert', array('type' => 'success', 'message' => 
      '<strong>Done!</strong> Cut was successfully created.'));

    return redirect()->route('transfers.show', $cut->transfer);
  }

  /**
   * Display the form for editing a cut.
   */
  public function edit(Request $request, $masterId, $cutId)
  {
    $master = PreservationMaster::findOrFail($masterId);
    $cut = Cut::findOrFail($cutId);
    $transfer = $cut->transfer;
    return view('masters.cuts.edit', compact('master', 'cut', 'transfer'));
  }

  /**
   * Update the details of a cut.
   */
  public function update(CutRequest $request, $masterId, $cutId)
  {
    $input = $request->all();
    $cut = Cut::findOrFail($cutId);
    $cut->fill($input);

    $updateSolr = false;
    if ($cut->isDirty('title') || $cut->isDirty('performer_composer')) {
      $updateSolr = true;
    }

    // Update MySQL
    DB::transaction(function () use ($cut) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      $cut->save();

      DB::statement('set @transaction_id = null;');
    });

    // Update Solr
    if ($updateSolr) {
      $item = AudioVisualItem::where('call_number', $cut->callNumber)->first();
      $this->solrItems->update($item);
      $this->solrMasters->update($cut->preservationMaster);
      $this->solrTransfers->update($cut->transfer);
    }

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Got it!</strong> Your cut was successfully updated.'));

    return redirect()->route('masters.cuts.show', [$masterId, $cutId]);

  }

  public function destroy(Request $request, $masterid, $cutId)
  {
    $cut = Cut::findOrFail($cutId);

    $command = $request->deleteCommand;

    // Update MySQL
    DB::transaction(function () use ($cut, $command) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      if ($command === 'all') {
        $cut->transfer->delete();
      }
      $cut->delete();

      DB::statement('set @transaction_id = null;');      
    });

    // Update Solr
    $item = AudioVisualItem::where('call_number', $cut->callNumber)->first();
    $this->solrItems->update($item);
    $this->solrMasters->update($cut->preservationMaster);
    if ($command !== 'all') {
      $this->solrTransfers->update($cut->transfer);
    } else {
      $this->solrTransfers->delete($cut->transfer);
    }

    $request->session()->put('alert', array('type' => 'success', 'message' => 
        '<strong>Gone!</strong> Cut was successfully deleted.'));

    if ($command === 'all') {
      return redirect()->route('masters.show', $cut->preservationMaster);
    } else {
      return redirect()->route('transfers.show', $cut->transfer);
    }
  }

}
