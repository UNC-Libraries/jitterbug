<?php
use Jitterbug\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

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
