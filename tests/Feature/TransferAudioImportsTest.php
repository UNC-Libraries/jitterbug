<?php



class TransferAudioImportsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAudioImportUpload()
    {
      $user = factory(Jitterbug\Models\User::class)->create();
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
}
