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
      $collections = DB::table('collections')->whereNull('archival_identifier')->get();

      foreach ($collections as $collection) {
        $collection->archivalIdentifier = (string) $collection->id;
        $collection->save();
      }
    }
}
