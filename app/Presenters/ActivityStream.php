<?php namespace Jitterbug\Presenters;

use DB;
use Log;

use Jitterbug\Models\Revision;

/**
 * Models a stream of recent activity, culled from the revisions table.
 */
class ActivityStream
{

  protected $transactions = array();

  /**
   * Create a new instance.
   *
   * @return void
   */
  public function __construct($limit=20, $offset=0)
  {
    // Fetch recent transaction ids
    $results = DB::table('revisions')->select('transaction_id')
                                     ->distinct()
                                     ->orderBy('id', 'desc')
                                     ->limit($limit)
                                     ->offset($offset)
                                     ->get();

    foreach ($results as $result) {
      $transaction = new TransactionDigest($result->transaction_id);
      array_push($this->transactions, $transaction);
    }

    return $this;
  }

  /**
   * Collect the activities from the transaction digests.
   *
   * @return array
   */
  public function activities()
  {
    $activities = array();
    foreach($this->transactions as $transaction) {
      $activities = array_merge($activities, $transaction->activities());
    }
    return $activities;
  }

}