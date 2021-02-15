<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\AudioItem;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Prefix;
use Jitterbug\Models\User;
use Jitterbug\Models\Format;
use Jitterbug\Models\Collection;
use Jitterbug\Models\NewCallNumberSequence;

class ItemsImportTest extends TestCase
{
  use RefreshDatabase;
  private $user;
  private $audioVisualItem1;
  private $audioVisualItem2;
  private $format;
  private $collection1;
  private $collection2;
  private $prefix;

  protected function setUp() : void
  {
    parent::setUp();
    $this->user = User::factory()->create();
    $this->audioVisualItem1 = AudioVisualItem::factory()->create(['call_number' =>'FT-6708']);
    $this->audioVisualItem2 = AudioVisualItem::factory()->create(['call_number' =>'FT-6709']);
    $this->collection1 = Collection::factory()->create(['archival_identifier' => '20027']);
    $this->format = Format::factory()->create(['id' => 28]);
    $collectionTypeId = $this->collection1->collection_type_id;
    $this->prefix = Prefix::factory()->create(['deleted_at' => null, 'collection_type_id' => $collectionTypeId]);
    $this->format->prefixes()->attach([$this->prefix->id]);
  }

  public function testItemsImportUpload() : void
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

  public function testItemsImportUploadExecuteWithErrors() : void
  {
    $user = $this->user;
    $filePath = base_path('tests/import-test-files/items-import/sample_items_import_mixed_errors.csv');

    $response = $this->actingAs($user)
      ->withSession(['items-import-file' => $filePath])
      ->post('/items/batch/audio-import-execute',
        [],
        array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $responseArray = json_decode($response->getContent(), true);
    // see if the response html includes the uploaded file error string
    $htmlContainsErrorMessage = strpos($responseArray['html'], 'There are errors in your uploaded file.') !== false;

    $this->assertEquals('error', $responseArray['status'], "The JSON status should be 'error'.");
    $this->assertTrue($htmlContainsErrorMessage, 'The HTML in the response does not include the correct error notification.');
  }

  public function testItemsImportNewUploadExecuteWithSuccess() : void
  {
    NewCallNumberSequence::factory()->create([
      'prefix' => $this->prefix->label,
      'collection_id' => $this->collection1->id,
      'next' => 2
    ]);
    $user = $this->user;
    $filePath = base_path('tests/import-test-files/items-import/small_items_import.csv');

    $response = $this->actingAs($user)
      ->withSession(['items-import-file' => $filePath])
      ->post('/items/batch/audio-import-execute',
        [],
        array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $responseArray = json_decode($response->getContent(), true);
    $htmlContainsSuccessMessage = strpos($responseArray['html'], 'Your import was successful!') !== false;

    $this->assertEquals('success', $responseArray['status'], "The JSON status should be 'success'.");
    $this->assertTrue($htmlContainsSuccessMessage, 'The HTML in the response does not include the correct success notification.');
  }

  public function testItemsImportUpdateExecuteWithSuccess() : void
  {
    NewCallNumberSequence::factory()->create([
      'prefix' => $this->prefix->label,
      'collection_id' => $this->collection1->id,
      'next' => 2
    ]);
    $user = $this->user;
    $filePath = base_path('tests/import-test-files/items-import/items_import_with_call_number.csv');

    $response = $this->actingAs($user)
      ->withSession(['items-import-file' => $filePath])
      ->post('/items/batch/audio-import-execute',
        [],
        array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $responseArray = json_decode($response->getContent(), true);
    $htmlContainsSuccessMessage = strpos($responseArray['html'], 'Your import was successful!') !== false;

    $this->assertEquals('success', $responseArray['status'], "The JSON status should be 'success'.");
    $this->assertTrue($htmlContainsSuccessMessage, 'The HTML in the response does not include the correct success notification.');
  }

  public function testItemsImportUpdateActuallyUpdates() : void
  {
    $avItem = $this->audioVisualItem1;
    NewCallNumberSequence::factory()->create([
      'prefix' => $this->prefix->label,
      'collection_id' => $this->collection1->id,
      'next' => 2
    ]);
    $user = $this->user;
    $filePath = base_path('tests/import-test-files/items-import/items_import_with_call_number.csv');

    $this->actingAs($user)
      ->withSession(['items-import-file' => $filePath])
      ->post('/items/batch/audio-import-execute',
        [],
        array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $updatedTitle = $avItem->fresh()->title;

    $this->assertEquals('Test open reel 1', $updatedTitle, "The audiovisual item's title was not updated.");
  }

  public function testItemsImportValidationNoCallNumberSequence() : void
  {
    $user = $this->user;
    $filePath = base_path('tests/import-test-files/items-import/small_items_import.csv');

    $response = $this->actingAs($user)
      ->withSession(['items-import-file' => $filePath])
      ->post('/items/batch/audio-import-execute',
        [],
        array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $responseArray = json_decode($response->getContent(), true);
    $htmlContainsErrorMessage = strpos($responseArray['html'],
      'The Collection/Format pairing does not have a valid CallNumberSequence available.')!== false;

    $this->assertEquals('error', $responseArray['status'], "The JSON status should be 'error'.");
    $this->assertTrue($htmlContainsErrorMessage, 'The HTML in the response does not include the correct error notification.');
  }

  public function testItemsImportValidationMustAlreadyExistInDatabase() : void
  {
    $user = $this->user;
    $filePath = base_path('tests/import-test-files/items-import/sample_items_import_mixed_errors.csv');

    $response = $this->actingAs($user)
      ->withSession(['items-import-file' => $filePath])
      ->post('/items/batch/audio-import-execute',
        [],
        array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $responseArray = json_decode($response->getContent(), true);
    $htmlContainsErrorMessage = strpos($responseArray['html'],
        'AccessRestrictions must already exist in the database.')!== false;

    $this->assertEquals('error', $responseArray['status'], "The JSON status should be 'error'.");
    $this->assertTrue($htmlContainsErrorMessage, 'The HTML in the response does not include the correct error notification.');
  }
}
