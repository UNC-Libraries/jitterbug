<?php

use Illuminate\Database\Seeder;
use Jitterbug\Models\NewCallNumberSequence;

class AddArchivalIdentifierToCallNumbersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $callNumberSequences = NewCallNumberSequence::all();

      foreach ($callNumberSequences as $callNumberSequence) {
        $callNumberSequence->archivalIdentifier = (string) $callNumberSequence->collectionId;
        $callNumberSequence->save();
      }
    }
}
