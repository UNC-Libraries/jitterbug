<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\DepartmentRequest;
use Jitterbug\Models\Department;
use Jitterbug\Models\PreservationInstance;
use Jitterbug\Support\SolariumProxy;

/**
 * Controller for the management of departments in the Admin area.
 */
class DepartmentsController extends Controller
{

  protected $solrInstances;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['auth', 'admin']);
    $this->solrInstances = new SolariumProxy('jitterbug-instances');
  }

  public function index(Request $request) {
    if ($request->ajax()) {
      $records = Department::orderBy('name')->get();
      return view('admin._names', compact('records'));
    }
  }

  public function store(DepartmentRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();
      $department = new Department;
      $department->fill($input);
      $department->save();
      return response()->json($department);
    }
  }

  public function update($id, DepartmentRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();

      $department = Department::findOrFail($id);
      $department->fill($input);

      if ($department->isDirty()) {

        // Update MySQL
        DB::transaction(function () use ($department) {
          $department->save();
        });

        // Update Solr
        $affectedInstances =
          PreservationInstance::where('department_id', $id)->get();
        $this->solrInstances->update($affectedInstances);
      }
    }
  }

  public function destroy($id, Request $request) {
    if ($request->ajax()) {
      $count = PreservationInstance::where('department_id', $id)->count();
      if ($count === 0) {
        $department = Department::findOrFail($id);
        $department->delete();
        $response = array('status'=>'success');
        return response()->json($response);
      } else {
        $bag = new MessageBag();
        $bag->add('status', 'Looks like that department is currently in use. ' . 
          'Change the department of the related preservation instances before ' .
          'deleting.');
        $response = $bag;
        return response()->json($bag, 422);
      }
    }
  }

}

