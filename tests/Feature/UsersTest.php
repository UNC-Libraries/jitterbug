<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\User;
use Jitterbug\Models\Mark;

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

  public function testInactivateDeletesUserMarks() : void
  {
    $user = factory(User::class)->create(['inactive' => 0]);
    $adminUser = factory(User::class)->create(['admin' => 1]);
    factory(Mark::class)->create(['user_id' => $user->id]);
    factory(Mark::class)->create(['user_id' => $user->id]);
    $this->assertCount(2, $user->marks);

    $this->be($adminUser);
    $response = $this->post('/users/inactivate',
      ['id' => $user->id],
      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
    $user = $user->fresh();

    $this->assertCount(0, $user->marks, "User's marks should have been deleted.");
    $response->assertJson(['marksDeleted' => 2]);
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testReactivateSetsInactiveToFalse() : void
  {
    $user = factory(User::class)->create(['inactive' => 1]);
    $adminUser = factory(User::class)->create(['admin' => 1]);

    $this->be($adminUser);
    $response = $this->post('/users/reactivate',
      ['id' => $user->id],
      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
    $user = $user->fresh();

    $this->assertSame(0, $user->inactive, "User's inactive status should be 0");
    $this->assertEquals(200, $response->getStatusCode());
  }
}
