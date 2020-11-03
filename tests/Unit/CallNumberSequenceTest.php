<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CallNumberSequenceTest extends TestCase
{
  use RefreshDatabase;
  private $collectionType;
  private $prefix;
  private $collection;

  protected function setUp() : void
  {
    parent::setUp();
    $new_prefix_array = Models\CallNumberSequence::ALWAYS_USE_NEW_STYLE;
    $this->collectionType = factory(Models\CollectionType::class)->create(['name' => 'SFC Collection']);
    $this->prefix = factory(Models\Prefix::class)->create([
      'label' => $new_prefix_array[array_rand($new_prefix_array)],
      'collection_type_id' => $this->collectionType->id,
    ]);
    $this->collection = factory(Models\Collection::class)->create([
      'collection_type_id' => $this->collectionType->id,
    ]);
  }

  public function testNextAlwaysUsesNewCallSequenceIfPrefixInNewStyleArray() : void
  {
    $format = factory(Models\Format::class)->create();
    $format->attachPrefixes($this->prefix->id);

    $sequence = Models\CallNumberSequence::next($this->collection->id, $format->id);
    $this->assertTrue(is_a($sequence,'Jitterbug\Models\NewCallNumberSequence'),
      'Sequence is not a NewCallNumberSequence, as it should be.');
  }

  public function testNextReturnsNewCallNumberSequenceIfItAlreadyExists() : void
  {
    $callNumber = factory(Models\NewCallNumberSequence::class)->create([
      'prefix' => $this->prefix->label,
      'collection_id' => $this->collection->id,
      'next' => 2
    ]);
    $format = factory(Models\Format::class)->create();
    $format->prefixes()->attach($this->prefix->id);

    $sequence = Models\CallNumberSequence::next($this->collection->id, $format->id);
    $this->assertSame($callNumber->id, $sequence->id,
      'Sequence is not the existing NewCallNumberSequence, as it should be.');
    $this->assertTrue(is_a($sequence,'Jitterbug\Models\NewCallNumberSequence'),
      'Sequence is not a NewCallNumberSequence, as it should be.');
  }

  public function testNextReturnsExistingLegacyCallNumberSequenceIfNoNewCallNumberSequenceExists() : void
  {
    $prefix1 = factory(Models\Prefix::class)->create([
      'label' => 'CD',
      'collection_type_id' => $this->collectionType->id,
    ]);
    factory(Models\NewCallNumberSequence::class)->create([
      'prefix' => $prefix1->label,
      'collection_id' => 20013,
      'next' => 2
    ]);
    $legacyCallNumber = factory(Models\LegacyCallNumberSequence::class)->create([
      'prefix' => $prefix1->label,
      'next' => 2
    ]);
    $format = factory(Models\Format::class)->create();
    $format->prefixes()->attach($prefix1->id);

    $sequence = Models\CallNumberSequence::next($this->collection->id, $format->id);
    $this->assertTrue(is_a($sequence,'Jitterbug\Models\LegacyCallNumberSequence'),
      'Sequence is not a LegacyCallNumberSequence, as it should be.');
    $this->assertSame($legacyCallNumber->id, $sequence->id,
      'Sequence is not the existing legacyCallNumberSequence, as it should be.');
  }

  public function testNextRaises404ErrorForMissingPrefix() : void
  {
    $format = factory(Models\Format::class)->create();
    // no prefixes have been attached to this format
    $this->expectException(NotFoundHttpException::class);
    Models\CallNumberSequence::next($this->collection->id, $format->id);
  }
}
