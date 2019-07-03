<?php

use Jitterbug\Models\Prefix;
use Jitterbug\Models\User;
use Jitterbug\Models\Format;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FormatsTest extends TestCase
{
  private $adminUser;
  private $prefix;
  private $format;

  protected function setUp() {
    parent::setUp();
    $this->adminUser = factory(User::class)->create(['admin' => 1]);
    $this->format = factory(Format::class)->create(['name' => '16mm']);
    $this->prefix = factory(Prefix::class)->create();
  }

  public function testAttachPrefixes()
  {
    $this->disableExceptionHandling();
    $adminUser = $this->adminUser;
    $format = $this->format;
    $this->be($adminUser);
    $prefix = $this->prefix;

    $response = $this->post('/formats/attach_prefixes',
      [
        'id' => $format->id,
        'prefixIds' => array($prefix->id),
      ],
      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $this->assertDatabaseHas('format_prefix', ['format_id' => $format->id, 'prefix_id' => $prefix->id]);
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testDetachPrefixes()
  {
    $adminUser = $this->adminUser;
    $format = $this->format;
    $this->be($adminUser);
    $prefix = $this->prefix;
    $format->prefixes()->attach($prefix);
    $this->assertDatabaseHas('format_prefix', ['format_id' => $format->id, 'prefix_id' => $prefix->id]);

    $response = $this->post('/formats/detach_prefixes',
      [
        'id' => $format->id,
        'prefixIds' => array($prefix->id),
      ],
      array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $this->assertDatabaseMissing('format_prefix', ['format_id' => $format->id, 'prefix_id' => $prefix->id]);
    $this->assertEquals(200, $response->getStatusCode());
  }
}
