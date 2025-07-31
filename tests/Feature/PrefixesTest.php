<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\CollectionType;
use Jitterbug\Models\Format;
use Jitterbug\Models\Prefix;
use Jitterbug\Models\User;
use TestCase;

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

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['admin' => 1]);
        $this->user = User::factory()->create(['admin' => 0]);
        $this->collectionType = CollectionType::factory()->create(['name' => 'SFC Collection']);
    }

    public function test_index_redirects_non_admin_user(): void
    {
        $user = $this->user;
        $this->be($user);
        $response = $this->get('/prefixes', ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/dashboard');
    }

    public function test_index_responds_successfully(): void
    {
        $adminUser = $this->adminUser;
        $this->be($adminUser);
        $response = $this->get('/prefixes', ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_store_creates_new_prefix(): void
    {
        $adminUser = $this->adminUser;
        $collectionType = $this->collectionType;
        $this->be($adminUser);
        $response = $this->post('/prefixes',
            [
                'label' => 'FS',
                'collection_type_id' => $collectionType->id,
            ],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $this->assertDatabaseHas('prefixes', ['label' => 'FS']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_update_edits_prefix(): void
    {
        $collectionType = $this->collectionType;
        $prefix = Prefix::factory()->create(['label' => 'SFC', 'collection_type_id' => $collectionType->id]);
        $newLabel = 'FFS';
        $adminUser = $this->adminUser;

        $this->be($adminUser);
        $response = $this->put("/prefixes/{$prefix->id}",
            [
                'label' => $newLabel,
            ],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $queriedPrefix = Prefix::find($prefix->id);

        $this->assertEquals($newLabel, $queriedPrefix->label, 'Prefix@update did not update the label.');
        $this->assertEquals(200, $response->getStatusCode(), 'Did not get a successful response.');
    }

    public function test_delete_removes_prefix_and_connections_to_formats(): void
    {
        $prefix = Prefix::factory()->create(['deleted_at' => null]);
        $format1 = Format::factory()->create();
        $format2 = Format::factory()->create();
        $adminUser = $this->adminUser;
        // attach the formats to the prefix
        $prefix->formats()->attach([$format1->id, $format2->id]);

        $this->be($adminUser);
        $response = $this->delete("/prefixes/{$prefix->id}",
            [],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $prefix = $prefix->fresh();

        $this->assertEmpty($prefix->formats->all());
        $this->assertNotNull($prefix->deleted_at);
        $response->assertJson(['status' => 'success']);
    }
}
