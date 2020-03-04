<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\User;
use Jitterbug\Models\CollectionType;
use Jitterbug\Models\Prefix;
use Jitterbug\Models\Format;

class PrefixesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
  use RefreshDatabase;
  private $adminUser;
  private $user;
  private $collectionType;

  protected function setUp() : void
  {
    parent::setUp();
    $this->adminUser = factory(User::class)->create(['admin' => 1]);
    $this->user = factory(User::class)->create(['admin' => 0]);
    $this->collectionType = factory(CollectionType::class)->create(['name' => 'SFC Collection']);
  }

  public function testIndexRedirectsNonAdminUser()
  {
    $user = $this->user;
    $this->be($user);
    $response = $this->get('/prefixes', array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $this->assertEquals(302, $response->getStatusCode());
    $response->assertRedirect('/dashboard');
  }

  public function testIndexRespondsSuccessfully()
  {
    $adminUser = $this->adminUser;
    $this->be($adminUser);
    $response = $this->get('/prefixes', array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testStoreCreatesNewPrefix()
  {
    $adminUser = $this->adminUser;
    $collectionType = $this->collectionType;
    $this->be($adminUser);
    $response = $this->post('/prefixes',
                            [
                              'label' => 'FS',
                              'collection_type_id' => $collectionType->id,
                            ],
                            array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $this->assertDatabaseHas('prefixes', ['label' => 'FS']);
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testUpdateEditsPrefix()
  {
    $collectionType = $this->collectionType;
    $prefix = factory(Prefix::class)->create(['label' => 'SFC', 'collection_type_id' => $collectionType->id]);
    $newLabel = 'FFS';
    $adminUser = $this->adminUser;

    $this->be($adminUser);
    $response = $this->put("/prefixes/{$prefix->id}",
      [
        'label' => $newLabel,
      ],
      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
    $queriedPrefix = Prefix::find($prefix->id);

    $this->assertEquals($newLabel, $queriedPrefix->label, 'Prefix@update did not update the label.');
    $this->assertEquals(200, $response->getStatusCode(), 'Did not get a successful response.');
  }

  public function testDeleteRemovesPrefixAndConnectionsToFormats()
  {
    $prefix = factory(Prefix::class)->create(['deleted_at' => null]);
    $format1 = factory(Format::class)->create();
    $format2 = factory(Format::class)->create();
    $adminUser = $this->adminUser;
    // attach the formats to the prefix
    $prefix->formats()->attach([$format1->id, $format2->id]);

    $this->be($adminUser);
    $response = $this->delete("/prefixes/{$prefix->id}",
      [],
      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
    $prefix = $prefix->fresh();

    $this->assertEmpty($prefix->formats->all());
    $this->assertNotNull($prefix->deleted_at);
    $response->assertJson(['status' => 'success']);
  }
}
