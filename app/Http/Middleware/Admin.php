<?php

namespace Jitterbug\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Auth;
use Closure;

class Admin
{
    /**
     * Verify the user is an admin. Redirect if they are not.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.index');
        }

        return $next($request);
    }
}
