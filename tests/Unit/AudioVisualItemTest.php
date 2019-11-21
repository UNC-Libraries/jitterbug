<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AudioVisualItemTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTypeIdAttribute()
    {
      $av_audio_item = factory(Jitterbug\Models\AudioVisualItem::class)->make();
      $av_film_item = factory(Jitterbug\Models\AudioVisualItem::class)->make([
        'subclass_type' => 'FilmItem',
      ]);
      $av_video_item = factory(Jitterbug\Models\AudioVisualItem::class)->make([
        'subclass_type' => 'VideoItem',
      ]);

      $this->assertSame(1, $av_audio_item->getTypeIdAttribute(),'TypeIdAttribute returned wrong ID for Audio Item');
      $this->assertSame(2, $av_film_item->getTypeIdAttribute(), 'TypeIdAttribute returned wrong ID for Film Item');
      $this->assertSame(3, $av_video_item->getTypeIdAttribute(), 'TypeIdAttribute returned wrong ID for Video Item');

    }
}
