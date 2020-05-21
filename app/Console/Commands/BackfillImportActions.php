<?php

namespace Jitterbug\Console\Commands;

use Illuminate\Console\Command;

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
        //
    }
}
