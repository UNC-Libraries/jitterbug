<?php
namespace Jitterbug\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

use Auth;
use DB;
use Log;
use Session;
use Solarium;
use Uuid;

use Jitterbug\Export\ItemsExport;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\AudioVisualItemType;
use Jitterbug\Models\AudioVisualItemCollection;
use Jitterbug\Models\AudioVisualItemFormat;
use Jitterbug\Models\AudioItem;
use Jitterbug\Models\BatchAudioVisualItem;
use Jitterbug\Models\CallNumberSequence;
use Jitterbug\Models\Collection;
use Jitterbug\Models\Cut;
use Jitterbug\Models\FilmItem;
use Jitterbug\Models\Format;
use Jitterbug\Models\Mark;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\VideoItem;
use Jitterbug\Http\Requests\ItemRequest;
use Jitterbug\Support\SolariumProxy;
use Jitterbug\Support\SolariumPaginator;

class DashboardController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }
  
  public function index(Request $request)
  {

    return view('dashboard.index');
  }

}