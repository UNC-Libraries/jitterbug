<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Jitterbug\Models;

class CallNumberSequenceTest extends TestCase
{
  use DatabaseTransactions;
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
      'collection_type_id' => 3,
    ]);
    $this->collection = factory(Models\Collection::class)->create([
      'collection_type_id' => $this->collectionType->id,
    ]);
  }

  public function testNextAlwaysUsesNewCallSequenceIfPrefixInNewStyleArray()
  {
    $format = factory(Models\Format::class)->create([
      # TODO APPDEV-8643 remove when column is removed
      'prefix' => $this->prefix->label,
    ]);

    $sequence = Models\CallNumberSequence::next($this->collection->id, $format->id);
    $this->assertTrue(is_a($sequence,'Jitterbug\Models\NewCallNumberSequence'),
      'Sequence is not a NewCallNumberSequence, as it should be.');
  }

  public function testNextReturnsNewCallNumberSequenceIfItAlreadyExists()
  {
    $callNumber = factory(Models\NewCallNumberSequence::class)->create([
      'prefix' => $this->prefix->label,
      'collection_id' => $this->collection->id,
      'next' => 2
    ]);
    $format = factory(Models\Format::class)->create([
      # TODO APPDEV-8643 remove when column is removed
      'prefix' => $callNumber->prefix,
    ]);
    $format->prefixes()->attach($this->prefix->id);

    $sequence = Models\CallNumberSequence::next($this->collection->id, $format->id);
    $this->assertSame($callNumber->id, $sequence->id,
      'Sequence is not the existing NewCallNumberSequence, as it should be.');
    $this->assertTrue(is_a($sequence,'Jitterbug\Models\NewCallNumberSequence'),
      'Sequence is not a NewCallNumberSequence, as it should be.');
  }

  public function testNextReturnsExistingLegacyCallNumberSequenceIfNoNewCallNumberSequenceExists()
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
    $format = factory(Models\Format::class)->create([
      # TODO APPDEV-8643 remove when column is removed
      'prefix' => $prefix1->label,
    ]);
    $format->prefixes()->attach($prefix1->id);

    $sequence = Models\CallNumberSequence::next($this->collection->id, $format->id);
    $this->assertTrue(is_a($sequence,'Jitterbug\Models\LegacyCallNumberSequence'),
      'Sequence is not a LegacyCallNumberSequence, as it should be.');
    $this->assertSame($legacyCallNumber->id, $sequence->id,
      'Sequence is not the existing legacyCallNumberSequence, as it should be.');
  }
}