<?php

namespace Jitterbug\Http\Controllers;

use Auth;
use DB;
use Log;
use Uuid;

use Illuminate\Http\Request;

use Jitterbug\Http\Requests\CutRequest;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Cut;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Models\Transfer;
use Jitterbug\Support\SolariumProxy;

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

    $this->solrItems = new SolariumProxy('jitterbug-items');
    $this->solrMasters = new SolariumProxy('jitterbug-masters');
    $this->solrTransfers = new SolariumProxy('jitterbug-transfers');
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
    $transfer = Transfer::findOrFail($request->transfer_id);
    $master = $transfer->preservation_master;
    $cut = new Cut;
    $cut->call_number = $transfer->call_number;
    $cut->preservation_master_id = $transfer->preservation_master_id;
    $cut->transfer_id = $transfer->id;

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
    $item = AudioVisualItem::where('call_number', $cut->call_number)->first();
    $this->solrItems->update($item);
    $this->solrMasters->update($cut->preservation_master);
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

  /**
   * Delete a cut and potentially a transfer.
   */
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
    $item = AudioVisualItem::where('call_number', $cut->call_number)->first();
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

  /**
   * Display the details of a cut, coming from the dashboard. This
   * is somewhat of a hack to get around the fact that on the dashboard
   * we don't have the associated preservation master id, so we have
   * this special direct route.
   */
  public function get($cutId)
  {
    $cut = Cut::findOrFail($cutId);
    return redirect()->route('masters.cuts.show', 
        [$cut->preservation_master_id, $cut->id]);
  }

}
