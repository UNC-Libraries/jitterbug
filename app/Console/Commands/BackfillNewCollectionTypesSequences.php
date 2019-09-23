<?php

namespace Jitterbug\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Jitterbug\Models\NewCallNumberSequence;

class BackfillNewCollectionTypesSequences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backfill:sequences {collection_type_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates missing sequences for existing collection/prefix combos';

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
      $collectionTypeId = $this->argument('collection_type_id');
      $prefixes = DB::table('prefixes')->select('label')
        ->where('collection_type_id', '=', $collectionTypeId)
        ->distinct()
        ->get();

      $collections = DB::table('collections')->where('collection_type_id', '=', $collectionTypeId)->get();
      $bar = $this->output->createProgressBar($collections->count());

      foreach ($collections as $collection)  {
        $bar->advance();
        foreach ($prefixes as $prefix) {
          $sequenceExists = DB::table('new_call_number_sequences')
            ->where('prefix', '=', $prefix->label)
            ->where('collection_id', '=', $collection->id)
            ->exists();

          if (!$sequenceExists) {
            $sequence = new NewCallNumberSequence();
            $sequence->prefix = $prefix->label;
            $sequence->collection_id = $collection->id;
            $sequence->archival_identifier = $collection->archival_identifier;
            $sequence->next = 1;
            $sequence->save();
          }
        }

      }
      $bar->finish();
    }
}
