<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Collection;
use Jitterbug\Models\Cut;
use Jitterbug\Models\Format;
use Jitterbug\Models\NewCallNumberSequence;
use Jitterbug\Models\User;
use PHPUnit\Framework\TestCase;
use Tests\Helpers\TestHelper;

class AudioVisualItemsTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private $avItem;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $cut = Cut::factory()->create();
        $this->avItem = AudioVisualItem::factory()->create(['call_number' => $cut->call_number]);
        TestHelper::addUserIdToRevision('AudioVisualItem', $this->avItem->id, $this->user->id);
    }

    /**
     * A basic feature test example.
     */
    public function test_show_accurately_returns(): void
    {
        $response = $this->actingAs($this->user)
            ->get('/items/'.$this->avItem->id);

        $response->assertStatus(200);
        $response->assertViewIs('items.show');
    }

    public function test_create_displays_form(): void
    {
        Collection::factory()->count(3)->create();
        Format::factory()->count(3)->create();
        $response = $this->actingAs($this->user)
            ->get('/items/create');

        $response->assertStatus(200);
        $response->assertViewIs('items.create');
    }

    public function test_store_saves_new_item(): void
    {
        $collection = Collection::factory()->create();
        $format = Format::factory()->create();
        $prefix = TestHelper::createAndAttachPrefix($collection, $format);
        NewCallNumberSequence::factory()->create([
            'prefix' => $prefix->label,
            'collection_id' => $collection->id,
            'next' => 1,
        ]);
        $response = $this->actingAs($this->user)
            ->post('/items',
                [
                    'batch_size' => 2,
                    'title' => 'The Newest Title',
                    'collection_id' => $collection->id,
                    'format_id' => $format->id,
                    'entry_date' => '2021-10-18',
                    'subclass_type' => 'AudioItem',
                    'subclass' => ['size' => 12],
                ]);
        $newItem = AudioVisualItem::all()->last();
        $response->assertRedirect('/items/'.$newItem->id);
        $this->assertEquals('The Newest Title', $newItem->title, 'Test did not create AV Item with the right title');
    }

    public function test_edit_displays_form(): void
    {
        Collection::factory()->count(3)->create();
        Format::factory()->count(3)->create();
        $response = $this->actingAs($this->user)
            ->get('/items/'.$this->avItem->id.'/edit');

        $response->assertStatus(200);
        $response->assertViewIs('items.edit');
    }

    public function test_update_edits_item(): void
    {
        $item = $this->avItem;
        $id = $item->id;
        $title = $item->title;
        $parameters = [
            'id' => $item->id,
            'call_number' => $item->call_number,
            'title' => 'A New Title',
            'collection_id' => $item->collection_id,
            'format_id' => $item->format_id,
            'entry_date' => $item->entry_date,
            'subclass_type' => $item->subclass_type,
            'subclass_id' => $item->subclass_id,
            'subclass' => [
                'size' => 12,
            ],
        ];

        $response = $this->actingAs($this->user)
            ->put('/items/'.$id, $parameters);

        $response->assertRedirect('/items/'.$id);
        $this->assertNotEquals($title, AudioVisualItem::find($id)->title, 'AV Item title should have updated.');
    }

    public function test_destroy_deletes_item(): void
    {
        $id = $this->avItem->id;
        $response = $this->actingAs($this->user)
            ->delete('/items/'.$id);

        $response->assertRedirect('/items');
        $this->assertNull(AudioVisualItem::find($id));
    }
}
