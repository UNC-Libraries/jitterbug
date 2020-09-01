<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\User;

class UsersTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

  public function testInactivateSetsInactiveToTrue() : void
  {
    $user = factory(User::class)->create(['inactive' => 0]);
    $adminUser = factory(User::class)->create(['admin' => 1]);

    $this->be($adminUser);
    $response = $this->post('/users/inactivate',
      ['id' => $user->id],
      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
    $user = $user->fresh();

    $this->assertSame(1, $user->inactive, "User's inactive status should be 1");
    $this->assertEquals(200, $response->getStatusCode());
  }
}
