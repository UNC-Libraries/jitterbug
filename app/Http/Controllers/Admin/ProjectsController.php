<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\ProjectRequest;
use Jitterbug\Models\Project;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Support\SolariumProxy;

/**
 * Controller for the management of projects in the Admin area.
 */
class ProjectsController extends Controller
{

  protected $solrMasters;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['auth', 'admin']);
    $this->solrMasters = new SolariumProxy('jitterbug-masters');
  }

  public function index(Request $request) {
    if ($request->ajax()) {
      $records = Project::orderBy('name')->get();
      return view('admin._names', compact('records'));
    }
  }

  public function store(ProjectRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();
      $project = new Project;
      $project->fill($input);
      $project->save();
      return response()->json($project);
    }
  }

  public function update($id, ProjectRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();

      $project = Project::findOrFail($id);
      $project->fill($input);

      if ($project->isDirty()) {

        // Update MySQL
        DB::transaction(function () use ($project) {
          $project->save();
        });

        // Update Solr
        $affectedMasters = 
          PreservationMaster::where('project_id', $id)->get();
        $this->solrMasters->update($affectedMasters);
      }
    }
  }

  public function destroy($id, Request $request) {
    if ($request->ajax()) {
      $count = PreservationMaster::where('project_id', $id)->count();
      if ($count === 0) {
        $project = Project::findOrFail($id);
        $project->delete();
        $response = array('status'=>'success');
        return response()->json($response);
      } else {
        $bag = new MessageBag();
        $bag->add('status', 'Looks like that project is currently in use. ' . 
          'Change the project of the related preservation masters before ' .
          'deleting.');
        $response = $bag;
        return response()->json($bag, 422);
      }
    }
  }

}

