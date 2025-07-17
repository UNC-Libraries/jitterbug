<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $this->prefix1 = Prefix::factory()->create(['deleted_at' => null, 'collection_type_id' => 3]);
        $this->prefix2 = Prefix::factory()->create(['deleted_at' => null, 'collection_type_id' => 4]);
        $this->format = Format::factory()->create();
    }

    public function test_find_prefix_label_finds_label_successfully(): void
    {
        $collection = Collection::factory()->create(['collection_type_id' => 3]);

        // attach the formats to the prefix
        $this->format->prefixes()->attach([$this->prefix1->id, $this->prefix2->id]);

        $this->assertEquals($this->prefix1->label, Prefix::findPrefixLabel($this->format->id, $collection->id));
    }

    public function test_find_prefix_label_raises_exception_for_null_collection_type_id(): void
    {
        $this->expectException(NotFoundHttpException::class);
        Prefix::findPrefixLabel($this->format->id, 20001);
    }
}
