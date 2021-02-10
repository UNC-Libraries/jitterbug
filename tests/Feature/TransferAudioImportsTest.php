<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\User;
use Jitterbug\Models\Department;
use Jitterbug\Models\AudioItem;
use Jitterbug\Models\PlaybackMachine;

class TransferAudioImportsTest extends TestCase
{
  /**
     * A basic test example.
     *
     * @return void
     */
    use RefreshDatabase;
    private $user;
    private $audioVisualItem1;
    private $audioVisualItem2;
    private $department;
    private $playbackMachine;

    protected function setUp() : void
    {
      parent::setUp();
      $this->user = User::factory()->create();
      $this->department = Department::factory()->create(['name' => 'SFC']);
      $this->audioVisualItem1 = AudioVisualItem::factory()->create(['call_number' =>'FT-6708']);
      $this->audioVisualItem2 = AudioVisualItem::factory()->create(['call_number' =>'FT-6709']);
      $this->playbackMachine = PlaybackMachine::factory()->create(['name' => 'Otari 19462235 D']);
      AudioItem::factory()->create(['size' => '7"', 'track_configuration' => '1/2 track', 'base' => 'Polyester']);
      AudioVisualItem::factory()->create(['speed' => '78 rpm']);
    }

    public function testAudioImportUpload()
    {
      $user = $this->user;
      $filePath = base_path('tests/import-test-files/audio-import/sample_audio_import_missing_original_pm_column.csv');
      $file = $this->getUploadableFile($filePath, 'sample_audio_import.csv', 'text/csv');

      $this->actingAs($user)->post(
        '/transfers/batch/audio-import-upload',
        ['audio-import-file' => $file,],
        array('HTTP_X-Requested-With' => 'XMLHttpRequest')
      );

      $path = storage_path('app/uploads');
      $filename = $user->username . '-audio-import-' . fileTimestamp();

      $this->assertFileExists("{$path}/{$filename}.csv");
    }

    public function testAudioImportUploadExecuteWithErrors()
    {
      $user = $this->user;
      $filePath = base_path('tests/import-test-files/audio-import/small_import_non_validated.csv');

      $response = $this->actingAs($user)
                       ->withSession(['audio-import-file' => $filePath])
                       ->post('/transfers/batch/audio-import-execute',
                         [],
                         array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

      $responseArray = json_decode($response->getContent(), true);
      // see if the response html includes the uploaded file error string
      $htmlContainsErrorMessage = strpos($responseArray['html'], 'There are errors in your uploaded file.') !== false;

      $this->assertEquals('error', $responseArray['status'], "The JSON status should be 'error'.");
      $this->assertTrue($htmlContainsErrorMessage, 'The HTML in the response does not include the correct error notification.');
    }

    public function testAudioImportUploadExecuteWithSuccess()
    {
      $user = $this->user;
      $filePath = base_path('tests/import-test-files/audio-import/small_upload_file_no_errors.csv');

      $response = $this->actingAs($user)
                       ->withSession(['audio-import-file' => $filePath])
                       ->post('/transfers/batch/audio-import-execute',
                         [],
                         array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

      $responseArray = json_decode($response->getContent(), true);
      $htmlContainsSuccessMessage = strpos($responseArray['html'], 'Your import was successful!') !== false;


      $this->assertEquals('success', $responseArray['status'], "The JSON status should be 'success'.");
      $this->assertTrue($htmlContainsSuccessMessage, 'The HTML in the response does not include the correct success notification.');
    }

  public function testAudioImportUploadUpdateSizeWithSuccess()
  {
    $user = $this->user;
    $avItem = $this->audioVisualItem1;
    $filePath = base_path('tests/import-test-files/audio-import/small_upload_file_no_errors.csv');

    $response = $this->actingAs($user)
                     ->withSession(['audio-import-file' => $filePath])
                     ->post('/transfers/batch/audio-import-execute',
                        [],
                        array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $responseArray = json_decode($response->getContent(), true);
    $audioItem = $avItem->subclass;

    $this->assertEquals('success', $responseArray['status'], "The JSON status should be 'success'.");
    $this->assertEquals('7"', $audioItem->size, 'The size column in the related AudioItem was not set correctly.');
  }

  public function testAudioImportUploadUpdateTrackConfigWithSuccess()
  {
    $user = $this->user;
    $avItem = $this->audioVisualItem1;
    $filePath = base_path('tests/import-test-files/audio-import/small_upload_file_no_errors.csv');

    $response = $this->actingAs($user)
      ->withSession(['audio-import-file' => $filePath])
      ->post('/transfers/batch/audio-import-execute',
        [],
        array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $responseArray = json_decode($response->getContent(), true);
    $audioItem = $avItem->subclass;

    $this->assertEquals('success', $responseArray['status'], "The JSON status should be 'success'.");
    $this->assertEquals('1/2 track', $audioItem->track_configuration,
      'The track configuration column in the related AudioItem was not set correctly.');
  }

  public function testAudioImportUploadUpdateBaseWithSuccess()
  {
    $user = $this->user;
    $avItem = $this->audioVisualItem1;
    $filePath = base_path('tests/import-test-files/audio-import/small_upload_file_no_errors.csv');

    $response = $this->actingAs($user)
      ->withSession(['audio-import-file' => $filePath])
      ->post('/transfers/batch/audio-import-execute',
        [],
        array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $responseArray = json_decode($response->getContent(), true);
    $audioItem = $avItem->subclass;

    $this->assertEquals('success', $responseArray['status'], "The JSON status should be 'success'.");
    $this->assertEquals('Polyester', $audioItem->base,
      'The base column in the related AudioItem was not set correctly.');
  }

  public function testAudioImportUploadUpdateSpeedWithSuccess()
  {
    $user = $this->user;
    $avItem = $this->audioVisualItem1;
    $filePath = base_path('tests/import-test-files/audio-import/small_upload_file_no_errors.csv');

    $response = $this->actingAs($user)
      ->withSession(['audio-import-file' => $filePath])
      ->post('/transfers/batch/audio-import-execute',
        [],
        array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

    $responseArray = json_decode($response->getContent(), true);
    $avItemInDb = Jitterbug\Models\AudioVisualItem::find($avItem->id);
    $this->assertEquals('success', $responseArray['status'], "The JSON status should be 'success'.");
    $this->assertEquals('78 rpm', $avItemInDb->speed,
      'The speed column in the AudioVisualItem entry was not set correctly.');
  }
}
