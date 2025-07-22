<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\CallNumberSequence;
use Jitterbug\Models\Collection;
use Jitterbug\Models\CollectionType;
use Jitterbug\Models\Format;
use Jitterbug\Models\LegacyCallNumberSequence;
use Jitterbug\Models\NewCallNumberSequence;
use Jitterbug\Models\Prefix;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CallNumberSequenceTest extends TestCase
{
    use RefreshDatabase;

    private $collectionType;

    private $prefix;

    private $collection;

    protected function setUp(): void
    {
        parent::setUp();
        $new_prefix_array = CallNumberSequence::ALWAYS_USE_NEW_STYLE;
        $this->collectionType = CollectionType::factory()->create(['name' => 'SFC Collection']);
        $this->prefix = Prefix::factory()->create([
            'label' => $new_prefix_array[array_rand($new_prefix_array)],
            'collection_type_id' => $this->collectionType->id,
        ]);
        $this->collection = Collection::factory()->create([
            'collection_type_id' => $this->collectionType->id,
        ]);
    }

    public function test_next_always_uses_new_call_sequence_if_prefix_in_new_style_array(): void
    {
        $format = Format::factory()->create();
        $format->attachPrefixes($this->prefix->id);

        $sequence = CallNumberSequence::next($this->collection->id, $format->id);
        $this->assertTrue(is_a($sequence, \Jitterbug\Models\NewCallNumberSequence::class),
            'Sequence is not a NewCallNumberSequence, as it should be.');
    }

    public function test_next_returns_new_call_number_sequence_if_it_already_exists(): void
    {
        $callNumber = NewCallNumberSequence::factory()->create([
            'prefix' => $this->prefix->label,
            'collection_id' => $this->collection->id,
            'next' => 2,
        ]);
        $format = Format::factory()->create();
        $format->prefixes()->attach($this->prefix->id);

        $sequence = CallNumberSequence::next($this->collection->id, $format->id);
        $this->assertSame($callNumber->id, $sequence->id,
            'Sequence is not the existing NewCallNumberSequence, as it should be.');
        $this->assertTrue(is_a($sequence, \Jitterbug\Models\NewCallNumberSequence::class),
            'Sequence is not a NewCallNumberSequence, as it should be.');
    }

    public function test_next_returns_existing_legacy_call_number_sequence_if_no_new_call_number_sequence_exists(): void
    {
        $prefix1 = Prefix::factory()->create([
            'label' => 'CD',
            'collection_type_id' => $this->collectionType->id,
        ]);
        NewCallNumberSequence::factory()->create([
            'prefix' => $prefix1->label,
            'next' => 2,
        ]);
        $legacyCallNumber = LegacyCallNumberSequence::factory()->create([
            'prefix' => $prefix1->label,
            'next' => 2,
        ]);
        $format = Format::factory()->create();
        $format->prefixes()->attach($prefix1->id);

        $sequence = CallNumberSequence::next($this->collection->id, $format->id);
        $this->assertTrue(is_a($sequence, \Jitterbug\Models\LegacyCallNumberSequence::class),
            'Sequence is not a LegacyCallNumberSequence, as it should be.');
        $this->assertSame($legacyCallNumber->id, $sequence->id,
            'Sequence is not the existing legacyCallNumberSequence, as it should be.');
    }

    public function test_next_raises404_error_for_missing_prefix(): void
    {
        $format = Format::factory()->create();
        // no prefixes have been attached to this format
        $this->expectException(NotFoundHttpException::class);
        CallNumberSequence::next($this->collection->id, $format->id);
    }
}
