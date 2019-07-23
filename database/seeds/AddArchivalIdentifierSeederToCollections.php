<?php

use Illuminate\Database\Seeder;
use Jitterbug\Models\Collection;

class AddArchivalIdentifierSeederToCollections extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // to backfill the collection IDs as strings in the archival_identifier column
      $collections = Collection::all();

      foreach ($collections as $collection) {
        $collection->archivalIdentifier = (string) $collection->id;
        $collection->save();
      }
    }
}
