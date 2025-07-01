<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Collection;
use Jitterbug\Models\Format;
use Jitterbug\Models\Prefix;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PrefixTest extends TestCase
{
    use RefreshDatabase;

    private $prefix1;

    private $prefix2;

    private $format;

    protected function setUp(): void
    {
        parent::setUp();
        $this->prefix1 = Prefix::factory()->create(['deleted_at' => null, 'collection_type_id' => 3, 'label' => 'VT']);
        $this->prefix2 = Prefix::factory()->create(['deleted_at' => null, 'collection_type_id' => 4, 'label' => 'FD', 'legacy' => 0]);
        $this->prefix3 = Prefix::factory()->create(['deleted_at' => null, 'collection_type_id' => 4, 'label' => 'D', 'legacy' => 1]);
        $this->format = Format::factory()->create();
    }

    public function testFindPrefixLabelFindsLabelSuccessfully()
    {
        $collection = Collection::factory()->create(['collection_type_id' => 3]);

        // attach the formats to the prefix
        $this->format->prefixes()->attach([$this->prefix1->id, $this->prefix2->id]);

        $this->assertEquals($this->prefix1->label, Prefix::findPrefixLabel($this->format->id, $collection->id));
    }

    public function testFindPrefixLabelRaisesExceptionForNullCollectionTypeId()
    {
        $this->expectException(NotFoundHttpException::class);
        Prefix::findPrefixLabel($this->format->id, 20001);
    }

    public function testFindLegacyPrefixLabelForSHCCollectionSpecialCase()
    {
        $collection = Collection::factory()->create(['collection_type_id' => 4]);
        AudioVisualItem::factory()->create(['call_number' => 'DAT-1234/1', 'collection_id' => $collection->id]);

        // attach the formats to the prefix
        $this->format->prefixes()->attach([$this->prefix2->id, $this->prefix3->id]);

        $this->assertEquals($this->prefix3->label, Prefix::findPrefixLabel($this->format->id, $collection->id));
    }

    public function testFindNonLegacyPrefixLabelForSHCCollectionSpecialCase()
    {
        $collection = Collection::factory()->create(['collection_type_id' => 4]);
        AudioVisualItem::factory()->create(['call_number' => 'FD-1234/1', 'collection_id' => $collection->id]);

        // attach the formats to the prefix
        $this->format->prefixes()->attach([$this->prefix2->id, $this->prefix3->id]);

        $this->assertEquals($this->prefix2->label, Prefix::findPrefixLabel($this->format->id, $collection->id));
    }
}
