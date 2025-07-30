<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\AudioVisualItem;
use TestCase;

class AudioVisualItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_type_id_attribute(): void
    {
        $av_audio_item = AudioVisualItem::factory()->make();
        $av_film_item = AudioVisualItem::factory()->make([
            'subclass_type' => 'FilmItem',
        ]);
        $av_video_item = AudioVisualItem::factory()->make([
            'subclass_type' => 'VideoItem',
        ]);

        $this->assertSame(1, $av_audio_item->getTypeIdAttribute(), 'TypeIdAttribute returned wrong ID for Audio Item');
        $this->assertSame(2, $av_film_item->getTypeIdAttribute(), 'TypeIdAttribute returned wrong ID for Film Item');
        $this->assertSame(3, $av_video_item->getTypeIdAttribute(), 'TypeIdAttribute returned wrong ID for Video Item');
    }

    public function test_blank_display_attribute_with_revisionable(): void
    {
        $av_item = AudioVisualItem::factory()->make();

        $this->assertSame('Yes', $av_item->getBlankDisplayAttribute(true),
            'BlankDisplayAttribute should return yes when revisionable passes true in');
    }

    public function test_blank_display_attribute(): void
    {
        $av_item = AudioVisualItem::factory()->make(['blank' => true]);

        $this->assertSame('Yes', $av_item->blank_display,
            'BlankDisplayAttribute should return yes as the display form attribute');
    }
}
