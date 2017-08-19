<?php namespace Jitterbug\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler {

 /**
  * A list of the exception types that should not be reported.
  *
  * @var array
  */
  protected $dontReport = [
    'Symfony\Component\HttpKernel\Exception\HttpException'
  ];

  /**
   * Convert an authentication exception into an unauthenticated response.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Illuminate\Auth\AuthenticationException  $exception
   * @return \Illuminate\Http\Response
   */
  protected function unauthenticated($request, AuthenticationException $exception)
  {
    if ($request->expectsJson()) {
      return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    return redirect()->guest('login');
  }

 /**
  * Report or log an exception.
  *
  * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
  *
  * @param  \Exception  $e
  * @return void
  */
  public function report(Exception $e)
  {
    return parent::report($e);
  }

 /**
  * Render an exception into an HTTP response.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \Exception  $e
  * @return \Illuminate\Http\Response
  */
  public function render($request, Exception $e)
  {

    // The following exceptions are handled in the parent class
    if (!$e instanceof HttpResponseException &&
    	!$e instanceof ModelNotFoundException &&
    	!$e instanceof AuthenticationException &&
    	!$e instanceof AuthorizationException &&
    	!$e instanceof ValidationException) {

      if ($e instanceof TokenMismatchException) {
        return response()->view('errors.token-mismatch', [], 403);
      }

      // Decordate the exception with a 500 exception so that
      // the parent class renders the 500 page.
      $e = new HttpException(500, 'Internal Server Error', $e);
    }

    return parent::render($request, $e);
  }

}
