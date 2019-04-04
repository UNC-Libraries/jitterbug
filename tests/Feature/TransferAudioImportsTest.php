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
//      $user = factory(Jitterbug\Models\User::class)->create();
//      Storage::fake('app/uploads');
//
//      $file = UploadedFile::fake()->create('sample_audio_import.csv', 53);
//
//      $response = $this->actingAs($user)->call('GET','TransfersController@index', [
//        //'audio-import-file' => $file,
//      ]);
//      print($response->getContent());
      // Assert the file was stored...
//      $path = Storage::disk('app/uploads')->getAdapter()->getPathPrefix();
//      Storage::disk('app/uploads')->assertExists("{$path}sample_audio_import.csv");

      // Assert a file does not exist...
//      Storage::disk('app/uploads')->assertMissing('missing.jpg');
    }
}
