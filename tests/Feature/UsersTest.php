<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\Mark;
use Jitterbug\Models\User;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_inactivate_sets_inactive_to_true(): void
    {
        $user = User::factory()->create(['inactive' => 0]);
        $adminUser = User::factory()->create(['admin' => 1]);

        $this->be($adminUser);
        $response = $this->post('/users/inactivate',
            ['id' => $user->id],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $user = $user->fresh();

        $this->assertSame(1, $user->inactive, "User's inactive status should be 1");
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_inactivate_deletes_user_marks(): void
    {
        $user = User::factory()->create(['inactive' => 0]);
        $adminUser = User::factory()->create(['admin' => 1]);
        Mark::factory()->create(['user_id' => $user->id]);
        Mark::factory()->create(['user_id' => $user->id]);
        $this->assertCount(2, $user->marks);

        $this->be($adminUser);
        $response = $this->post('/users/inactivate',
            ['id' => $user->id],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $user = $user->fresh();

        $this->assertCount(0, $user->marks, "User's marks should have been deleted.");
        $response->assertJson(['marksDeleted' => 2]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_reactivate_sets_inactive_to_false(): void
    {
        $user = User::factory()->create(['inactive' => 1]);
        $adminUser = User::factory()->create(['admin' => 1]);

        $this->be($adminUser);
        $response = $this->post('/users/reactivate',
            ['id' => $user->id],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $user = $user->fresh();

        $this->assertSame(0, $user->inactive, "User's inactive status should be 0");
        $this->assertEquals(200, $response->getStatusCode());
    }
}
