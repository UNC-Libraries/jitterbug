<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Jitterbug\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    // this test uses a non LDAP login method that only works on a local or test environment
    public function testLoggingInWorks()
    {
        User::factory()->create([
            'username' => 'best_user',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
          ->type('username', 'best_user')
          ->type('password', 'password')
          ->press('Sign In')
          ->assertPathIs('/dashboard');
        });
    }
}
