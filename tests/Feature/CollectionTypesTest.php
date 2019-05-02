<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Jitterbug\Models\User;

class CollectionTypesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
  use DatabaseTransactions;
  private $adminUser;
  private $user;

  protected function setUp() {
    parent::setUp();
    $this->adminUser = factory(Jitterbug\Models\User::class)->create(['admin' => 1]);
    $this->user = factory(Jitterbug\Models\User::class)->create(['admin' => 0]);
  }

  public function testIndexRedirectsNonAdminUser()
  {
    $user = $this->user;
    $this->be($user);
    $response = $this->get('/collection-types', array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $this->assertEquals(302, $response->getStatusCode());
    $response->assertRedirect('/dashboard');
  }

  public function testIndexRespondsSuccessfully()
  {
    $adminUser = $this->adminUser;
    $this->be($adminUser);
    $response = $this->get('/collection-types', array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testStoreCreatesNewCollectionType()
  {

  }
}
