<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\Format;
use Jitterbug\Models\Prefix;
use Jitterbug\Models\User;
use PHPUnit\Framework\TestCase;

class FormatsTest extends TestCase
{
    use RefreshDatabase;

    private $adminUser;

    private $prefix;

    private $format;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['admin' => 1]);
        $this->format = Format::factory()->create(['name' => '16mm']);
        $this->prefix = Prefix::factory()->create();
    }

    public function test_attach_prefixes(): void
    {
        $adminUser = $this->adminUser;
        $format = $this->format;
        $this->be($adminUser);
        $prefix = $this->prefix;

        $response = $this->post('/formats/attach_prefixes',
            [
                'id' => $format->id,
                'prefixIds' => [$prefix->id],
            ],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $this->assertDatabaseHas('format_prefix', ['format_id' => $format->id, 'prefix_id' => $prefix->id]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_detach_prefixes(): void
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
                'prefixIds' => [$prefix->id],
            ],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $this->assertDatabaseMissing('format_prefix', ['format_id' => $format->id, 'prefix_id' => $prefix->id]);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
