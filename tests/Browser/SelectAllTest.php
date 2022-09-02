<?php

namespace Tests\Browser;

use Facebook\WebDriver\WebDriverKeys;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Jitterbug\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SelectAllTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testSelectAllWorks()
    {
        User::factory()->create();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
        ->visit('/instances')
        ->keys('#search', 'general', '{enter}')
        ->pause(1000)
        ->click('table > thead > tr > th')
        ->driver->getKeyboard()->sendKeys([WebDriverKeys::COMMAND, 'a']);

            $browser->pause(10000)->assertPresent('.selected');
        });
    }
}
