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
    $collection = factory(Models\Collection::class)->make();
    $format = factory(Models\Format::class)->create([
        'prefix' => $new_prefix_array[array_rand(@$new_prefix_array)],
    ]);

    $sequence = Models\CallNumberSequence::next($collection->id, $format->id);
    $this->assertTrue(is_a($sequence,'Jitterbug\Models\NewCallNumberSequence'),
      'Call Number is not a NewCallNumberSequence, as it should be.');
  }

  public function testNextFollowsPrecedingNewCallNumberSequence()
  {

  }

  function isNewCallNumber($callNumber){
    preg_match('/^\w*-\d*\/\d*$/', $callNumber);
  }
  function isLegacyCallNumber($callNumber){
    preg_match('/^\w*-\d*$/', $callNumber);
  }
}