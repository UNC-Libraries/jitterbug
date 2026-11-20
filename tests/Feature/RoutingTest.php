<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\User;
use TestCase;

class RoutingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic functional test example.
     */
    public function test_homepage_redirect_response(): void
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_transfers_index_response(): void
    {
        $user = User::factory()->create();
        $this->be($user);
        $response = $this->call('GET', '/transfers');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_logout_requires_post(): void
    {
        $user = User::factory()->create();
        $this->be($user);

        $this->get('/logout')->assertStatus(405);
    }

    public function test_post_logout_logs_user_out(): void
    {
        $user = User::factory()->create();
        $this->be($user);

        $this->post('/logout')
            ->assertRedirect('/login?logout=true');

        $this->assertGuest();
    }
}
