<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\User;
use Illuminate\Support\Facades\Log;

class AdminTest extends TestCase
{
  use RefreshDatabase;
  private $adminUser;

  protected function setUp(): void
  {
    parent::setUp();
    $this->adminUser = User::factory()->create(['admin' => 1]);
  }

  public function testUserIsMadeAdminAppropriately() : void
  {
    $regularUser = User::factory()->create(['inactive' => 0, 'admin' => 0]);
    $adminUser = $this->adminUser;
    $this->be($adminUser);

    $response = $this->post('/admin/make-admin',
      [
        'username' => $regularUser->username,
      ],
      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $this->assertEquals(1, User::find($regularUser->id)->admin);
    $response->assertSuccessful();
  }

  public function testInactiveUserIsNotMadeAdmin() : void
  {
    $inactiveUser = User::factory()->create(['inactive' => 1]);
    $adminUser = $this->adminUser;
    $this->be($adminUser);

    $response = $this->post('/admin/make-admin',
      [
        'username' => $inactiveUser->username,
      ],
      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $this->assertEquals(0, User::find($inactiveUser->id)->admin);
    $response->assertStatus(422);
  }

  public function testAdminUserHasAdminStatusRemovedAppropriately() : void
  {
    $adminUser1 = User::factory()->create(['admin' => 1]);
    $adminUser = $this->adminUser;
    $this->be($adminUser);

    $response = $this->post('/admin/remove-admin',
      [
        'username' => $adminUser1->username,
      ],
      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $this->assertEquals(0, User::find($adminUser1->id)->admin);
    $response->assertSuccessful();
  }
}
