<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
//use Jitterbug\Support\SolariumProxy;

class TransferAudioImportsTest extends TestCase
{
  /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseTransactions;
    use MockeryPHPUnitIntegration;
    private $user;
    private $callNumber1;
    private $callNumber2;
    private $department;
    private $playbackMachine;

    protected function setUp() {
      parent::setUp();
      $this->user = factory(Jitterbug\Models\User::class)->create();
      $this->department = factory(Jitterbug\Models\Department::class)->create(['name' => 'SFC']);
      $this->callNumber1 = factory(Jitterbug\Models\AudioVisualItem::class)->create(['call_number' =>'FT-6708']);
      $this->callNumber2 = factory(Jitterbug\Models\AudioVisualItem::class)->create(['call_number' =>'FT-6709']);
      $this->playbackMachine = factory(Jitterbug\Models\PlaybackMachine::class)->create(['name' => 'Otari 19462235 D']);
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
      $this->disableExceptionHandling();
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
      $this->disableExceptionHandling();
//      $mockSolariumProxy = Mockery::mock(Jitterbug\Support\SolariumProxy::class)->makePartial();
////      $mock->shouldReceive('update')->twice()->andReturn('hello');
//      $this->instance(Jitterbug\Support\SolariumProxy::class, $mockSolariumProxy, function ($mock) {
//        $mock->shouldReceive('update')->twice()->andReturn('hello');
//      }) ;
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
    protected function tearDown()
    {
      $this->user->delete();
      $this->callNumber1->delete();
      $this->callNumber2->delete();
      $this->department->delete();
      $this->playbackMachine->delete();
      Mockery::close();
    }
}
