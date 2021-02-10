<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Jitterbug\Models\CollectionType;
use Jitterbug\Models\Prefix;
use Jitterbug\Models\Collection;
use Jitterbug\Models\CallNumberSequence;
use Jitterbug\Models\Format;
use Jitterbug\Models\NewCallNumberSequence;
use Jitterbug\Models\LegacyCallNumberSequence;

class CallNumberSequenceTest extends TestCase
{
  use RefreshDatabase;
  private $collectionType;
  private $prefix;
  private $collection;

  protected function setUp() : void
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

  public function testNextAlwaysUsesNewCallSequenceIfPrefixInNewStyleArray() : void
  {
    $format = Format::factory()->create();
    $format->attachPrefixes($this->prefix->id);

    $sequence = CallNumberSequence::next($this->collection->id, $format->id);
    $this->assertTrue(is_a($sequence,'Jitterbug\Models\NewCallNumberSequence'),
      'Sequence is not a NewCallNumberSequence, as it should be.');
  }

  public function testNextReturnsNewCallNumberSequenceIfItAlreadyExists() : void
  {
    $callNumber = NewCallNumberSequence::factory()->create([
      'prefix' => $this->prefix->label,
      'collection_id' => $this->collection->id,
      'next' => 2
    ]);
    $format = Format::factory()->create();
    $format->prefixes()->attach($this->prefix->id);

    $sequence = CallNumberSequence::next($this->collection->id, $format->id);
    $this->assertSame($callNumber->id, $sequence->id,
      'Sequence is not the existing NewCallNumberSequence, as it should be.');
    $this->assertTrue(is_a($sequence,'Jitterbug\Models\NewCallNumberSequence'),
      'Sequence is not a NewCallNumberSequence, as it should be.');
  }

  public function testNextReturnsExistingLegacyCallNumberSequenceIfNoNewCallNumberSequenceExists() : void
  {
    $prefix1 = Prefix::factory()->create([
      'label' => 'CD',
      'collection_type_id' => $this->collectionType->id,
    ]);
    NewCallNumberSequence::factory()->create([
      'prefix' => $prefix1->label,
      'next' => 2
    ]);
    $legacyCallNumber = LegacyCallNumberSequence::factory()->create([
      'prefix' => $prefix1->label,
      'next' => 2
    ]);
    $format = Format::factory()->create();
    $format->prefixes()->attach($prefix1->id);

    $sequence = CallNumberSequence::next($this->collection->id, $format->id);
    $this->assertTrue(is_a($sequence,'Jitterbug\Models\LegacyCallNumberSequence'),
      'Sequence is not a LegacyCallNumberSequence, as it should be.');
    $this->assertSame($legacyCallNumber->id, $sequence->id,
      'Sequence is not the existing legacyCallNumberSequence, as it should be.');
  }

  public function testNextRaises404ErrorForMissingPrefix() : void
  {
    $format = Format::factory()->create();
    // no prefixes have been attached to this format
    $this->expectException(NotFoundHttpException::class);
    CallNumberSequence::next($this->collection->id, $format->id);
  }
}
