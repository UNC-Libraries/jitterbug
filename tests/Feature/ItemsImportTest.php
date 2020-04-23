<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\AudioItem;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\User;

class ItemsImportTest extends TestCase
{
  use RefreshDatabase;
  private $user;
  private $audioVisualItem1;
  private $audioVisualItem2;

  protected function setUp() : void
  {
    parent::setUp();
    $this->user = factory(User::class)->create();
    $this->audioVisualItem1 = factory(AudioVisualItem::class)->create(['call_number' =>'FT-6708']);
    $this->audioVisualItem2 = factory(AudioVisualItem::class)->create(['call_number' =>'FT-6709']);
    factory(AudioItem::class)->create(['size' => '7"', 'track_configuration' => '1/2 track', 'base' => 'Polyester']);
    factory(AudioVisualItem::class)->create(['speed' => '78 rpm']);
  }

  public function testItemsImportUpload()
  {
    $user = $this->user;
    $filePath = base_path('tests/import-test-files/items-import/small_items_import.csv');
    $file = $this->getUploadableFile($filePath, 'sample_items_import.csv', 'text/csv');

    $this->actingAs($user)->post(
      '/items/batch/audio-import-upload',
      ['items-import-file' => $file,],
      array('HTTP_X-Requested-With' => 'XMLHttpRequest')
    );

    $path = storage_path('app/uploads');
    $filename = $user->username . '-items-import-' . fileTimestamp();

    $this->assertFileExists("{$path}/{$filename}.csv");
  }
}
