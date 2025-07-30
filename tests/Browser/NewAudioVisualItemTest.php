<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Jitterbug\Models\Collection;
use Jitterbug\Models\Format;
use Jitterbug\Models\NewCallNumberSequence;
use Jitterbug\Models\Prefix;
use Jitterbug\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NewAudioVisualItemTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_new_form_creates_new_audio_visual_item(): void
    {
        User::factory()->create();
        $collection = Collection::factory()->create();
        $format = Format::factory()->create();
        $collectionTypeId = $collection->collection_type_id;
        $prefix = Prefix::factory()->create(['deleted_at' => null, 'collection_type_id' => $collectionTypeId]);
        NewCallNumberSequence::factory()->create([
            'prefix' => $prefix->label,
            'collection_id' => $collection->id,
            'archival_identifier' => $collection->archival_identifier,
            'next' => 1,
        ]);
        $format->prefixes()->attach($prefix->id);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/items')
                ->clickLink('New')
                ->assertSee('Create Audio Visual Item')
                ->type('title', 'Example Title')
                ->select('collection_id', 1)
                ->select('format_id', 1)
                ->press('Save')
                ->assertPathIs('/items/1')
                ->assertSee('Audio Item Details');
        });
    }
}
