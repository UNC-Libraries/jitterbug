<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Jitterbug\Models\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CollectionTest extends TestCase
{
  use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
  public function testFindArchivalIdentifierIsSuccesful()
  {
    $collection = factory(Collection::class)->create(['archival_identifier' => 'hello']);
    $this->assertSame('hello', Collection::findArchivalIdentifier($collection->id));
  }

  public function testFindArchivalIdentifierReturns404IfCollectionDoesntExist()
  {
    $this->expectException(NotFoundHttpException::class);
    Collection::findArchivalIdentifier(1);
  }
}
