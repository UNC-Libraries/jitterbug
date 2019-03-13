<?php

class AudioVisualItemTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTypeIdAttribute()
    {
      $av_audio_item = factory(Jitterbug\Models\AudioVisualItem::class)->make();
      $av_film_item = factory(Jitterbug\Models\AudioVisualItem::class)->make([
        'subclassType' => 'FilmItem',
      ]);
      $av_video_item = factory(Jitterbug\Models\AudioVisualItem::class)->make([
        'subclassType' => 'VideoItem',
      ]);

      $this->assertSame(1, $av_audio_item->getTypeIdAttribute(),'TypeIdAttribute returned wrong ID for Audio Item');
      $this->assertSame(2, $av_film_item->getTypeIdAttribute(), 'TypeIdAttribute returned wrong ID for Film Item');
      $this->assertSame(3, $av_video_item->getTypeIdAttribute(), 'TypeIdAttribute returned wrong ID for Video Item');

    }
}
