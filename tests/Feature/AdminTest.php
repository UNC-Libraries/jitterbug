<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\User;
use TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['admin' => 1]);
    }

    public function test_user_is_made_admin_appropriately(): void
    {
        $regularUser = User::factory()->create(['inactive' => 0, 'admin' => 0]);
        $adminUser = $this->adminUser;
        $this->be($adminUser);

        $response = $this->post('/admin/make-admin',
            [
                'username' => $regularUser->username,
            ],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $this->assertEquals(1, User::find($regularUser->id)->admin);
        $response->assertSuccessful();
    }

    public function test_inactive_user_is_not_made_admin(): void
    {
        $inactiveUser = User::factory()->create(['inactive' => 1]);
        $adminUser = $this->adminUser;

        $response = $this->actingAs($adminUser)
            ->post('/admin/make-admin',
                [
                    'username' => $inactiveUser->username,
                ],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $this->assertEquals(0, User::find($inactiveUser->id)->admin);
        $response->assertStatus(422);
    }

    public function test_admin_user_has_admin_status_removed_appropriately(): void
    {
        $adminUser1 = User::factory()->create(['admin' => 1]);
        $adminUser = $this->adminUser;
        $this->be($adminUser);

        $response = $this->post('/admin/remove-admin',
            [
                'username' => $adminUser1->username,
            ],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $this->assertEquals(0, User::find($adminUser1->id)->admin);
        $response->assertSuccessful();
    }
}
