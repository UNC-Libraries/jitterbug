<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\User;
use TestCase;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_engineer_name_attribute_returns_full_name(): void
    {
        $user = User::factory()->create(['first_name' => 'Jane', 'last_name' => 'Doe']);
        $transfer = Transfer::factory()->create(['engineer_id' => $user]);
        $this->assertEquals('Jane Doe', $transfer->engineer_name);
    }

    public function test_engineer_name_attribute_returns_null_for_null_engineer(): void
    {
        $transfer = Transfer::factory()->create(['engineer_id' => null]);
        $this->assertNull($transfer->engineer_name);
    }
}
