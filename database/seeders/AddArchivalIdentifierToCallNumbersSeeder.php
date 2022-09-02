<?php

namespace Database\Seeders;

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
        // fill it in with the corresponding archival identifier from the associated collection
        DB::table('new_call_number_sequences as sequence')
        ->whereNull('sequence.archival_identifier')
        ->join('collections as collection', 'sequence.collection_id', '=', 'collection.id')
        ->update([
            'sequence.archival_identifier' => DB::raw('`collection`.`archival_identifier`'),
        ]);
    }
}
