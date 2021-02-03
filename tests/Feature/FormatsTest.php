<?php

use Jitterbug\Models\Prefix;
use Jitterbug\Models\User;
use Jitterbug\Models\Format;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormatsTest extends TestCase
{
  use RefreshDatabase;
  private $adminUser;
  private $prefix;
  private $format;

  protected function setUp() : void
  {
    parent::setUp();
    $this->adminUser = User::factory()->make(['admin' => 1]);
    $this->format = Format::factory()->make(['name' => '16mm']);
    $this->prefix = Prefix::factory()->make();
  }

  public function testAttachPrefixes()
  {
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
