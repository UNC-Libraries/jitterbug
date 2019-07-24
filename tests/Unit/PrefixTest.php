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
  private $format;

  protected function setUp()
  {
    parent::setUp();
    $this->prefix1 = factory(Prefix::class)->create(['deleted_at' => null, 'collection_type_id' => 3]);
    $this->prefix2 = factory(Prefix::class)->create(['deleted_at' => null, 'collection_type_id' => 4]);
    $this->format = factory(Format::class)->create();
  }

  public function testFindPrefixLabelFindsLabelSuccessfully()
  {
    $collection = factory(Collection::class)->create(['collection_type_id' => 3]);

    // attach the formats to the prefix
    $this->format->prefixes()->attach([$this->prefix1->id, $this->prefix2->id]);

    $this->assertEquals($this->prefix1->label, Prefix::findPrefixLabel($this->format->id, $collection->id));
  }

  public function testFindPrefixLabelRaisesExceptionForNullCollectionTypeId()
  {
    $this->expectException(NotFoundHttpException::class);
    Prefix::findPrefixLabel($this->format->id, 20001);
  }
}
