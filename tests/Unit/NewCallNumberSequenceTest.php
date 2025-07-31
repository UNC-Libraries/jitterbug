<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\NewCallNumberSequence;
use Jitterbug\Models\Prefix;
use TestCase;

class NewCallNumberSequenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_call_number_uses_archival_identifier_instead_of_collection_id(): void
    {
        $prefix = Prefix::factory()->create(['label' => 'TR']);
        $sequence = NewCallNumberSequence::factory()->create([
            'prefix' => $prefix->label,
            'collection_id' => 1,
            'archival_identifier' => '20013B',
            'next' => 2,
        ]);

        $this->assertSame('TR-20013B/2', $sequence->callNumber());
    }
}
