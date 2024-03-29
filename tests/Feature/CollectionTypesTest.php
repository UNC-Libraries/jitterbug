<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\Collection;
use Jitterbug\Models\CollectionType;
use Jitterbug\Models\User;

class CollectionTypesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use RefreshDatabase;

    private $adminUser;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['admin' => 1]);
        $this->user = User::factory()->create(['admin' => 0]);
    }

    public function testIndexRedirectsNonAdminUser()
    {
        $user = $this->user;
        $this->be($user);
        $response = $this->get('/collection-types', ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/dashboard');
    }

    public function testIndexRespondsSuccessfully()
    {
        $adminUser = $this->adminUser;
        $this->be($adminUser);
        $response = $this->get('/collection-types', ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreCreatesNewCollectionType()
    {
        $adminUser = $this->adminUser;
        $this->be($adminUser);
        $response = $this->post('/collection-types',
            ['name' => 'SFC collection'],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $collectionType = CollectionType::where('name', 'SFC collection');
        $this->assertNotNull($collectionType);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateEditsCollectionType()
    {
        $collectionType = CollectionType::factory()->create(['name' => 'SFC Collection']);
        $newName = 'Amazing SFC Collection';
        $adminUser = $this->adminUser;

        $this->be($adminUser);
        $response = $this->put("/collection-types/{$collectionType->id}",
            ['name' => $newName],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $queriedCollectionType = CollectionType::find($collectionType->id);

        $this->assertEquals($newName, $queriedCollectionType->name, 'CollectionType@update did not update the name.');
        $this->assertEquals(200, $response->getStatusCode(), 'Did not get a successful response.');
    }

    public function testDeleteDoesNotWorkOnCollectionTypeInUse()
    {
        $collectionType = CollectionType::factory()->create();
        Collection::factory()->create(['collection_type_id' => $collectionType->id]);
        $adminUser = $this->adminUser;
        $this->assertNotNull(CollectionType::find($collectionType->id));

        $this->be($adminUser);
        $response = $this->delete("/collection-types/{$collectionType->id}",
            [],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $this->assertEquals(422, $response->getStatusCode(), 'Did not get a 422 response.');
        $response->assertJson(['status' => ['Looks like that collection type is currently '.
                                            'in use. Change the collection type of the related collections '.
                                            'and/or prefixes before deleting.', ]]);
    }

    public function testDeleteRemovesUnusedCollectionType()
    {
        $collectionType = CollectionType::factory()->create(['deleted_at' => null]);
        $adminUser = $this->adminUser;

        $this->be($adminUser);
        $response = $this->delete("/collection-types/{$collectionType->id}",
            [],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $collectionType = $collectionType->fresh();

        $this->assertNotNull($collectionType->deleted_at);
        $response->assertJson(['status' => 'success']);
    }
}
