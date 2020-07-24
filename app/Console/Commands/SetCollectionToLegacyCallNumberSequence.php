<?php

namespace Jitterbug\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Jitterbug\Models\NewCallNumberSequence;

class SetCollectionToLegacyCallNumberSequence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset_sequence:legacy {archival_identifier}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This script deletes all new_call_number_sequences of the specified archival identifier.';

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
      $archivalIdentifier = $this->argument('archival_identifier');

      $invalidSequencePrefixes = DB::table('new_call_number_sequences')
        ->where('archival_identifier', $archivalIdentifier)
        ->where('next', '>', 1)
        ->get()
        ->pluck('prefix');

      DB::table('new_call_number_sequences')
        ->where('archival_identifier', $archivalIdentifier)
        ->where('next', '=', 1)
        ->delete();

      if ($invalidSequencePrefixes->count() > 0) {
        return 'The sequences with the following prefixes were not deleted: ' . $invalidSequencePrefixes;
      }
      return 'All sequences for archival identifier ' . $archivalIdentifier . ' were successfully deleted.';
    }
}
