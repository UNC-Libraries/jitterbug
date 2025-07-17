<?php

namespace Jitterbug\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Jitterbug\Models\Collection;

class AutoIncrementCollectionIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'increment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increment collection IDs and update references';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $bar = $this->output->createProgressBar(100);
        $collections = Collection::withTrashed()->get();
        $idTracker = 1;
        $collectionIdMapping = [];
        $bar->start();
        foreach ($collections as $collection) {
            $oldId = $collection->id;
            $collection->id = $idTracker;
            $collection->save();

            $collectionIdMapping[$oldId] = $idTracker;

            $idTracker++;
        }
        $bar->advance();
        $brokenIds = [];
        DB::table('new_call_number_sequences')
            ->whereNotNull('collection_id')
            ->chunkById(1000, function ($results) use (&$brokenIds, &$collectionIdMapping, &$bar) {
                foreach ($results as $result) {
                    if (isset($collectionIdMapping[$result->collection_id])) {
                        $newCollectionId = $collectionIdMapping[$result->collection_id];
                    } else {
                        $brokenIds['sequence_id'] = $result->id;

                        continue;
                    }

                    DB::table('new_call_number_sequences')
                        ->where('id', $result->id)
                        ->update(['collection_id' => $newCollectionId]);
                }
                $bar->advance();
            });

        DB::table('audio_visual_items')
            ->whereNotNull('collection_id')
            ->chunkById(1000, function ($results) use (&$brokenIds, &$collectionIdMapping, &$bar) {
                foreach ($results as $result) {
                    if (isset($collectionIdMapping[$result->collection_id])) {
                        $newCollectionId = $collectionIdMapping[$result->collection_id];
                    } else {
                        $brokenIds['av_item_id'] = $result->id;

                        continue;
                    }

                    DB::table('audio_visual_items')
                        ->where('id', $result->id)
                        ->update(['collection_id' => $newCollectionId]);
                }
                $bar->advance();
            });

        $headers = ['table => id'];
        $this->table($headers, $brokenIds);
        $bar->finish();
    }
}
