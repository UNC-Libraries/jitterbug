<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Jitterbug\Models as Models;

class CallNumberSequenceTest extends TestCase

{
  use DatabaseTransactions;
  /**
   * A basic test example.
   *
   * @return void
   */

  public function testNextAlwaysUseNewCallSequence()
  {
    $new_prefix_array = Models\CallNumberSequence::ALWAYS_USE_NEW_STYLE;
    $collectionId = 20005;
    $format = factory(Models\Format::class)->create([
        'prefix' => $new_prefix_array[array_rand(@$new_prefix_array)],
    ]);

    $sequence = Models\CallNumberSequence::next($collectionId, $format->id);
    $this->assertTrue(is_a($sequence,'Jitterbug\Models\NewCallNumberSequence'),
      'Call Number is not a NewCallNumberSequence, as it should be.');
  }

  public function testNextReturnsPrecedingNewCallNumberSequence()
  {
    $collectionId = 20006;
    $callNumber = factory(Models\NewCallNumberSequence::class)->create([
      'prefix' => 'FS',
      'collectionId' => $collectionId,
      'next' => 2
    ]);
    $format = factory(Models\Format::class)->create([
      'prefix' => $callNumber->prefix,
    ]);

    $sequence = Models\CallNumberSequence::next($collectionId, $format->id);
    $this->assertSame($callNumber->id, $sequence->id,
      'Call Number is not the existing last NewCallNumberSequence, as it should be.');
  }

  public function testNextReturnsPrecedingLegacyCallNumberSequence()
  {
    $collectionId = 20007;
    $prefix = 'CD';
    factory(Models\NewCallNumberSequence::class)->create([
      'prefix' => $prefix,
      'collectionId' => 20013,
      'next' => 2
    ]);
    factory(Models\LegacyCallNumberSequence::class)->create([
      'prefix' => $prefix,
      'next' => 2
    ]);
    $format = factory(Models\Format::class)->create([
      'prefix' => $prefix,
    ]);

    $sequence = Models\CallNumberSequence::next($collectionId, $format->id);
    $this->assertTrue(is_a($sequence,'Jitterbug\Models\LegacyCallNumberSequence'),
      'Call Number is not a LegacyCallNumberSequence, as it should be.');
  }
}