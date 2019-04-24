<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Models\Prefix;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

/**
 * Controller for the management of Prefixes in the Admin area.
 */
class PrefixesController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['auth', 'admin']);
  }
}