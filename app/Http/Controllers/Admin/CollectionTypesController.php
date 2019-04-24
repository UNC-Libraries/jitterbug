<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Models\CollectionType;


use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

/**
 * Controller for the management of collection types in the Admin area.
 */
class CollectionTypesController extends Controller
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
