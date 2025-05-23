<?php

namespace Jitterbug\Presenters;

use DB;
use Jitterbug\Models\Activity;

/**
 * Models a stream of recent activity, culled from the revisions table.
 */
class ActivityStream
{
    protected $transactions = [];

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
            DB::transaction(function () use ($numTransactionsToDigest) {

                // Fetch recent transaction ids
                $results = DB::table('revisions')->select('transaction_id')
                                         ->distinct()
                                         ->orderBy('id', 'desc')
                                         ->limit($numTransactionsToDigest)
                                         ->get();

                // Digest the transactions
                $digests = [];
                foreach ($results as $result) {
                    $digest = new TransactionDigest($result->transaction_id);
                    $digests[] = $digest;
                }

                // Collect the activities from the digests
                $activities = [];
                foreach ($digests as $digest) {
                    $activities = array_merge($activities, $digest->activities());
                }

                // Delete all activities
                Activity::query()->delete();

                // Insert activities into the database
                foreach ($activities as $activity) {
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

    private function hasNewTransactions(): bool
    {
        // Fetch last transaction made in the revisions table
        // Each batch of revisions will have the same transaction ID
        $results = DB::table('revisions')->select('transaction_id')
                                     ->orderBy('id', 'desc')
                                     ->limit(1)
                                     ->get()->all();

        $lastRevisionTransactionId = $results[0]->transaction_id;

        // Fetch most recent transaction in the activities table
        // The smallest ID is the most recently done activity
        $results = DB::table('activities')->select('transaction_id')
                                      ->orderBy('id', 'asc')
                                      ->limit(1)
                                      ->get()->all();

        if (count($results) === 0) {
            return true;
        }

        $lastActivityTransactionId = $results[0]->transaction_id;

        return $lastRevisionTransactionId !== $lastActivityTransactionId;
    }
}
