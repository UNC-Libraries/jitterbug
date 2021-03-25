<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\User;

class TransferTest extends TestCase
{
  use RefreshDatabase;

  public function testEngineerNameAttributeReturnsFullName() : void
  {
    $user = User::factory()->create(['first_name' => 'Jane', 'last_name' => 'Doe']);
    $transfer = Transfer::factory()->create(['engineer_id' => $user]);
    $this->assertEquals('Jane Doe', $transfer->engineer_name);
  }

  public function testEngineerNameAttributeReturnsNullForNullEngineer() : void
  {
    $transfer = Transfer::factory()->create(['engineer_id' => null]);
    $this->assertNull($transfer->engineer_name);
  }
}
