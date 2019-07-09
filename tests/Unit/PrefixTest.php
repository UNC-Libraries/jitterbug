<?php

use Jitterbug\Models\Format;
use Jitterbug\Models\Prefix;
use Jitterbug\Models\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PrefixTest extends TestCase
{
  use DatabaseTransactions;

  public function testFindPrefixLabel()
  {
    $this->disableExceptionHandling();
    $collection = factory(Collection::class)->create(['collection_type_id' => 3]);
    $prefix1 = factory(Prefix::class)->create(['deleted_at' => null, 'collection_type_id' => 3]);
    $prefix2 = factory(Prefix::class)->create(['deleted_at' => null, 'collection_type_id' => 4]);
    $format1 = factory(Format::class)->create();
    $format2 = factory(Format::class)->create();

    // attach the formats to the prefix
    $format1->prefixes()->attach($prefix1->id);
    $format2->prefixes()->attach([$prefix1->id, $prefix2->id]);

    $this->assertEquals($prefix1->label, Prefix::findPrefixLabel($format2->id, $collection->id));
  }
}
