<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Jitterbug\Models\AudioTransfer;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\User;
use Jitterbug\Models\Cut;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Venturecraft\Revisionable\Revision;

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
      'subclass_id' => $audioTransfer->id]);
    $this->generateRevision('Transfer', $this->transfer->id);
  }

  public function testUserIsAbleToAddCutWhenNecessary() : void
  {
    $this->browse(function (Browser $browser) {
      $path = '/transfers/' . $this->transfer->id;
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

  public function testUserMayEditCut() : void
  {
    $this->browse(function (Browser $browser) {
      $cut = Cut::factory()->create();
      $this->generateRevision('Cut', $cut->id);

      $browser->loginAs($this->user->id)
        ->visit('/cuts/' . $cut->id . '?instanceId=' . $cut->preservation_instance_id)
        ->clickLink('Edit')
        ->assertPathIs('/cuts/' . $cut->id . '/edit')

        ->type('title', 'The best film ever')
        ->press('Save')
        ->assertPathIs('/cuts/' . $cut->id);
    });
  }

  // when a factory object is generated, if that model uses Revisionable
  // a revision is automatically created without a user_id
  // this adds a necessary user_id to to that revision
  public function generateRevision($revisionableType, $revisionableId) : void
  {
    $revision = Revision::where('revisionable_type', $revisionableType)
      ->where('revisionable_id', $revisionableId)
      ->get()
      ->first();
    $revision->user_id = $this->user->id;
    $revision->save();
  }
}
