<?php

namespace Jitterbug\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Jitterbug\Models\ImportTransaction;

class BackfillImportActions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backfill:import_actions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets update import action for previous appropriate ImportTransactions';

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
        $importTransactions = ImportTransaction::all();
        $bar = $this->output->createProgressBar($importTransactions->count());
        foreach ($importTransactions as $importTransaction) {
          $bar->advance();
          // grab revisions related to the import
          $relatedRevisions = DB::table('revisions')
            ->where('transaction_id', $importTransaction->transaction_id)->get();
          // determine unique field values
          $fields = $relatedRevisions->pluck('field')->unique();
          if ($fields->contains('created_at')) {
            continue;
          }
          // if none of the fields are 'created_at' it's an update
          if ($fields->diff('created_at')->count() === 0) {
            $importTransaction->import_action = 'update';
            $importTransaction->save();
          }
        }
        $bar->finish();
    }
}
