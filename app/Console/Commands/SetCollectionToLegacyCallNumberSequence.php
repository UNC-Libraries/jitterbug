<?php

namespace Jitterbug\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
    public function handle(): void
    {
        $archivalIdentifier = $this->argument('archival_identifier');

        // Find all new call number sequences that have been used and get their associated prefix
        $usedSequencePrefixes = DB::table('new_call_number_sequences')
            ->where('archival_identifier', $archivalIdentifier)
            ->where('next', '>', 1)
            ->pluck('prefix');

        // Only delete the new call number sequences that have never been used
        DB::table('new_call_number_sequences')
            ->where('archival_identifier', $archivalIdentifier)
            ->where('next', '=', 1)
            ->delete();

        if ($usedSequencePrefixes->count() > 0) {
            $this->info('Done! The sequences with the following prefixes were not deleted because they have been used: '.$usedSequencePrefixes);
        } else {
            $this->info('All sequences for archival identifier '.$archivalIdentifier.' were successfully deleted.');
        }
    }
}
