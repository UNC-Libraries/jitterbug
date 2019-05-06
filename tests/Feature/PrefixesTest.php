<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Jitterbug\Models\User;
use Jitterbug\Models\CollectionType;
use Jitterbug\Models\Prefix;

class PrefixesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
  use DatabaseTransactions;
  private $adminUser;
  private $user;
  private $collectionType;

  protected function setUp() {
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
        'collection_type_id' => $collectionType->id,
      ],
      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
    $queriedPrefix = Prefix::find($prefix->id);
    print($response->getContent());

    $this->assertEquals($newLabel, $queriedPrefix->label, 'Prefix@update did not update the label.');
    $this->assertEquals(200, $response->getStatusCode(), 'Did not get a successful response.');
  }

//  {
//    $collectionType = factory(CollectionType::class)->create();
//    factory(Collection::class)->create(['collection_type_id' => $collectionType->id]);
//    $adminUser = $this->adminUser;
//    $this->assertNotNull(CollectionType::find($collectionType->id));
//
//    $this->be($adminUser);
//    $response = $this->delete("/collection-types/{$collectionType->id}",
//      [],
//      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
//
//    $this->assertEquals(422, $response->getStatusCode(), 'Did not get a 422 response.');
//    $response->assertJson(['status' => array('Looks like that collection type is currently ' .
//      'in use. Change the collection type of the related collections ' .
//      'and/or prefixes before deleting.')]);
//
//  }
//
//  public function testDeleteRemovesUnusedCollectionType()
//  {
//    $this->disableExceptionHandling();
//    $collectionType = factory(CollectionType::class)->create(['deleted_at' => null]);
//    $adminUser = $this->adminUser;
//
//    $this->be($adminUser);
//    $response = $this->delete("/collection-types/{$collectionType->id}",
//      [],
//      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
//    $collectionType = $collectionType->fresh();
//
//    $this->assertNotNull($collectionType->deleted_at);
//    $response->assertJson(['status' => 'success']);
//  }
}
