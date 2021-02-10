<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\Prefix;
use Jitterbug\Models\NewCallNumberSequence;

class NewCallNumberSequenceTest extends TestCase
{
  use RefreshDatabase;

  public function testCallNumberUsesArchivalIdentifierInsteadOfCollectionId()
  {
    $prefix = Prefix::factory()->create(['label' => 'TR']);
    $sequence = NewCallNumberSequence::factory()->create([
      'prefix' => $prefix->label,
      'collection_id' => 1,
      'archival_identifier' => '20013B',
      'next' => 2
    ]);

    $this->assertSame('TR-20013B/2', $sequence->callNumber());
  }
}
