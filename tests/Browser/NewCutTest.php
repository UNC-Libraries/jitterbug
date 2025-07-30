<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Jitterbug\Models\AudioTransfer;
use Jitterbug\Models\Cut;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Helpers\TestHelper;

class NewCutTest extends DuskTestCase
{
    use DatabaseMigrations;

    private $user;

    private $transfer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $audioTransfer = AudioTransfer::factory()->create();
        $this->transfer = Transfer::factory()->create([
            'engineer_id' => $this->user->id,
            'subclass_type' => 'AudioTransfer',
            'subclass_id' => $audioTransfer->id, ]);
        TestHelper::addUserIdToRevision('Transfer', $this->transfer->id, $this->user->id);
    }

    public function test_user_is_able_to_add_cut_when_necessary(): void
    {
        $this->browse(function (Browser $browser) {
            $path = '/transfers/'.$this->transfer->id;
            $browser->loginAs($this->user->id)
                ->visit($path)
                ->assertSee('Add Cut')
                ->clickLink('Add Cut')
                ->assertPathBeginsWith('/cuts/create')
                ->type('side', '1')
                ->press('Save')
                ->assertPathIs($path)
                ->assertSee('Related Cut');
        });
    }

    public function test_user_may_edit_cut(): void
    {
        $this->browse(function (Browser $browser) {
            $cut = Cut::factory()->create();
            TestHelper::addUserIdToRevision('Cut', $cut->id, $this->user->id);

            $browser->loginAs($this->user->id)
                ->visit('/cuts/'.$cut->id.'?instanceId='.$cut->preservation_instance_id)
                ->clickLink('Edit')
                ->assertPathIs('/cuts/'.$cut->id.'/edit')
                ->type('title', 'The best film ever')
                ->press('Save')
                ->assertPathIs('/cuts/'.$cut->id);
        });
    }
}
