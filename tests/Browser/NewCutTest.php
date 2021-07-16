<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Log;
use Jitterbug\Models\AudioTransfer;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Venturecraft\Revisionable\Revision;

class NewCutTest extends DuskTestCase
{
  use DatabaseMigrations;

  public function testUserIsAbleToAddCutWhenNecessary() : void
  {
    $user = User::factory()->create();
    $audioTransfer = AudioTransfer::factory()->create();
    $transfer = Transfer::factory()->create([
      'engineer_id' => $user->id,
      'subclass_type' => 'AudioTransfer',
      'subclass_id' => $audioTransfer->id]);
    // add user_id to automatically generated related revision
    $revision = Revision::where('revisionable_type', 'Transfer')
      ->where('revisionable_id', $transfer->id)
      ->get()
      ->first();
    $revision->user_id = $user->id;
    $revision->save();

    $this->browse(function (Browser $browser) {
      $browser->loginAs(1)
        ->visit('/transfers/1')
        ->assertSee('Add Cut')

        ->clickLink('Add Cut')
        ->assertPathBeginsWith('/cuts/create')
        ->type('side', '1')
        ->press('Save')
        ->assertPathIs('/transfers/1')
        ->assertSee('Related Cut');
    });
  }
}
