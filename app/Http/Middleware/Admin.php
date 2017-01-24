<?php

namespace Jitterbug\Http\Middleware;

use Auth;
use Closure;
use Log;

class Admin
{
  /**
   * Verify the user is an admin. Redirect if they are not.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if (!Auth::user()->isAdmin()) {
      return redirect()->route('dashboard.index');
    }

    return $next($request);
  }
}
