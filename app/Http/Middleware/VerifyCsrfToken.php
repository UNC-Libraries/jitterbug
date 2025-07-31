<?php

namespace Jitterbug\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * Handle an incoming request.
     *
     *
     * @throws TokenMismatchException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        return parent::handle($request, $next);
    }
}
