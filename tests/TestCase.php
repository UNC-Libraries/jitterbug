<?php
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\UploadedFile;

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;
	}

  protected function disableExceptionHandling()
  {
    app()->instance(ExceptionHandler::class, new PassThroughHandler);
  }

  protected function getUploadableFile($file, $original_name, $type)
  {
    $dummy = file_get_contents($file);
    file_put_contents(base_path('tests/' . basename($file)), $dummy);
    $path = base_path('tests/' . basename($file));
    $size = 111;
    $error = null;
    $test = true;
    $file = new UploadedFile($path, $original_name, $type, $size, $error, $test);
    return $file;
  }

  protected $connectionsToTransact = [
	  'mysql'
  ];
}

class PassThroughHandler extends Jitterbug\Exceptions\Handler
{
  public function __construct() {}
  public function report(Exception $e)
  {
    // no-op
  }
  public function render($request, Exception $e)
  {
    throw $e;
  }
}

