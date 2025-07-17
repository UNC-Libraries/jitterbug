<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\User;

class RoutingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_homepage_redirect_response()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_transfers_index_response()
    {
        $user = User::factory()->create();
        $this->be($user);
        $response = $this->call('GET', '/transfers');

        $this->assertEquals(200, $response->getStatusCode());
    }
}
