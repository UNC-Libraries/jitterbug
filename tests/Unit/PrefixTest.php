<?php

use Jitterbug\Models\Format;
use Jitterbug\Models\Prefix;
use Jitterbug\Models\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PrefixTest extends TestCase
{
  use DatabaseTransactions;
  private $prefix1;
  private $prefix2;
  private $format1;
  private $format2;

  protected function setUp()
  {
    parent::setUp();
    $this->prefix1 = factory(Prefix::class)->create(['deleted_at' => null, 'collection_type_id' => 3]);
    $this->prefix2 = factory(Prefix::class)->create(['deleted_at' => null, 'collection_type_id' => 4]);
    $this->format1 = factory(Format::class)->create();
    $this->format2 = factory(Format::class)->create();
  }

  public function testFindPrefixLabelFindsLabelSuccessfully()
  {
    $collection = factory(Collection::class)->create(['collection_type_id' => 3]);

    // attach the formats to the prefix
    $this->format1->prefixes()->attach($this->prefix1->id);
    $this->format2->prefixes()->attach([$this->prefix1->id, $this->prefix2->id]);

    $this->assertEquals($this->prefix1->label, Prefix::findPrefixLabel($this->format2->id, $collection->id));
  }

  public function testFindPrefixLabelRaisesExceptionForNullCollectionTypeId()
  {
    $this->expectException(NotFoundHttpException::class);
    Prefix::findPrefixLabel($this->format1->id, 20001);
  }
}
