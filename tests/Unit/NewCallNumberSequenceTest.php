<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Jitterbug\Models\Prefix;
use Jitterbug\Models\NewCallNumberSequence;

class NewCallNumberSequenceTest extends TestCase
{
  use DatabaseTransactions;

  public function testCallNumberUsesArchivalIdentifierInsteadOfCollectionId()
  {
    $prefix = factory(Prefix::class)->create(['label' => 'TR']);
    $sequence = factory(NewCallNumberSequence::class)->create([
      'prefix' => $prefix->label,
      'collectionId' => 1,
      'archivalIdentifier' => '20013B',
      'next' => 2
    ]);

    $this->assertSame('TR-20013B/2', $sequence->callNumber());
  }
}
