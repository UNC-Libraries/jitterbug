<?php

use Illuminate\Http\UploadedFile;

class TransferAudioImportsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAudioImportUpload()
    {
      Storage::fake('app/uploads');

      $file = UploadedFile::fake()->create('sample_audio_import.csv', 53);

      $response = $this->json('POST', 'transfers/batch/audio-import-upload', [
        'audio-import-file' => $file,
      ]);

      // Assert the file was stored...
      Storage::disk('app/uploads')->assertExists($file);

      // Assert a file does not exist...
      Storage::disk('app/uploads')->assertMissing('missing.jpg');
    }
}
