<?php

namespace Jitterbug\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Verify the user is an admin. Redirect if they are not.
     *
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
