<?php namespace Jitterbug\Presenters;

use DB;
use Log;

use Jitterbug\Models\Activity;

/**
 * Models a stream of recent activity, culled from the revisions table.
 */
class ActivityStream
{

  protected $transactions = array();

  /**
   * Generate the activities in the stream and store them in the database.
   * This method is called by the Laravel scheduler in 
   * Jitterbug\Console\Kernel and may take a while to run as there can be
   * many db queries involved depending on the number of records
   * in the recent transactions.
   */
  public function generate()
  {
    $numTransactionsToDigest = 20;

    if ($this->hasNewTransactions()) {

      DB::transaction(function() use ($numTransactionsToDigest) {

        // Fetch recent transaction ids
        $results = DB::table('revisions')->select('transaction_id')
                                         ->distinct()
                                         ->orderBy('id', 'desc')
                                         ->limit($numTransactionsToDigest)
                                         ->get();

        // Digest the transactions
        $digests = array();
        foreach ($results as $result) {
          $digest = new TransactionDigest($result->transaction_id);
          array_push($digests, $digest);
        }

        // Collect the activities from the digests
        $activities = array();
        foreach($digests as $digest) {
          $activities = array_merge($activities, $digest->activities());
        }
        
        // Delete all activities
        Activity::truncate();
        
        // Insert activities into the database
        foreach($activities as $activity) {
          $activity->save();
        }

      });
    }
  }

  /**
   * Fetch all activities generated by the transaction digests.
   *
   * @return array
   */
  public function activities()
  {
    return Activity::all();
  }

  private function hasNewTransactions()
  {
    // Fetch last transaction in the revisions table. This is not
    // pretty, but it's the fastest way to get the last transaction.
    $results = DB::select("select transaction_id 
                          from revisions 
                          where id = (
                            select auto_increment 
                            from information_schema.tables 
                            where table_schema = 'jitterbug'
                            and table_name = 'revisions') - 1");
    $lastRevisionTransactionId = $results[0]->transaction_id;

    // Fetch last transaction in the activities table
    $results = DB::table('activities')->select('transaction_id')
                                      ->orderBy('id')
                                      ->limit(1)
                                      ->get()->all();
    if (count($results)===0) return true;

    $lastActivityTransactionId = $results[0]->transaction_id;

    return $lastRevisionTransactionId !== $lastActivityTransactionId;  
  }

}