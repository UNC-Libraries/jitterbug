<?php

use Illuminate\Database\Seeder;

class AddArchivalIdentifierToCallNumbersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // find all the new call number sequences that need their archival_identifier field populated
      // TODO APPDEV-8779 rework seeder to grab archival identifier from collection record
      DB::table('new_call_number_sequences')->whereNull('archival_identifier')
                                            ->update([
                                              'archival_identifier' => DB::raw('`collection_id`')
                                            ]);
    }
}
