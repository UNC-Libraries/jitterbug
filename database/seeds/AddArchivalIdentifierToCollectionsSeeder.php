<?php

use Illuminate\Database\Seeder;

class AddArchivalIdentifierToCollectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // to backfill the collection IDs as strings in the archival_identifier column
      // TODO APPDEV-8779 delete seeder when collection ID is auto incrementing
      DB::table('collections')->whereNull('archival_identifier')
                              ->whereNull('deleted_at')
                              ->update([
                                'archival_identifier' => DB::raw('`id`')
                              ]);
    }
}
