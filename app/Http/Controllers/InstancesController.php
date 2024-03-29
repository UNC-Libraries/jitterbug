<?php

namespace Jitterbug\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Jitterbug\Export\InstancesExport;
use Jitterbug\Http\Requests\InstanceRequest;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\BatchPreservationInstance;
use Jitterbug\Models\Cut;
use Jitterbug\Models\Department;
use Jitterbug\Models\Mark;
use Jitterbug\Models\PmSpeed;
use Jitterbug\Models\PreservationInstance;
use Jitterbug\Models\PreservationInstanceCollection;
use Jitterbug\Models\PreservationInstanceDepartment;
use Jitterbug\Models\PreservationInstanceFormat;
use Jitterbug\Models\PreservationInstanceType;
use Jitterbug\Models\Project;
use Jitterbug\Models\ReproductionMachine;
use Jitterbug\Models\SamplingRate;
use Jitterbug\Models\TapeBrand;
use Jitterbug\Models\Transfer;
use Jitterbug\Support\SolariumPaginator;
use Jitterbug\Support\SolariumProxy;
use Uuid;

class InstancesController extends Controller
{
    protected $solrItems;

    protected $solrInstances;

    protected $solrTransfers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->solrItems = new SolariumProxy('jitterbug-items');
        $this->solrInstances = new SolariumProxy('jitterbug-instances');
        $this->solrTransfers = new SolariumProxy('jitterbug-transfers');
    }

    /**
     * Show the list of preservation instances and a search interface for
     * filtering and searching.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // The query string consists of search terms and an array of
            // selected filters for each filter list
            $queryString = urldecode($request->query('q'));
            $queryParams = json_decode($queryString);

            $page = $request->query('page');
            $perPage = $request->query('perPage');
            $start = $perPage * ($page - 1);
            $sortColumn = $request->query('sortColumn');
            $sortDirection = $request->query('sortDirection');

            $resultSet = $this->solrInstances->query($queryParams, $start, $perPage, $sortColumn, $sortDirection);
            $instances = new SolariumPaginator($resultSet, $page, $perPage);
            $totalRecordCount = $instances->total().' '.Str::plural('record', $instances->total());

            $instanceIds = [];
            foreach ($instances as $instance) {
                $instanceIds[] = $instance->id;
            }
            $marks = Mark::whereIn('markable_id', $instanceIds)
            ->where('markable_type', 'PreservationInstance')
            ->where('user_id', Auth::user()->id)
            ->get()->pluck('markable_id');

            return view('instances._instances',
                compact('instances', 'marks', 'start', 'sortColumn', 'sortDirection', 'totalRecordCount'));
        }

        $types = PreservationInstanceType::all();
        $collections = PreservationInstanceCollection::all();
        $formats = PreservationInstanceFormat::all();
        $departments = PreservationInstanceDepartment::all();
        $maxEditLimit = PreservationInstance::BATCH_EDIT_MAX_LIMIT;

        return view('instances.index',
            compact('types', 'collections', 'formats', 'departments', 'maxEditLimit'));
    }

    /**
     * Display the details of a instance.
     */
    public function show($id)
    {
        $instance = PreservationInstance::findOrFail($id);
        $transfers = $instance->transfers()->get();
        $cuts = $instance->cuts()->get();

        return view('instances.show', compact('instance', 'transfers', 'cuts'));
    }

    /**
     * Display the form for creating a new audio, video, or film instance.
     */
    public function create(Request $request)
    {
        $itemId = $request->itemId;
        $item = null;
        if ($itemId !== null) {
            $item = AudioVisualItem::findOrFail($itemId);
        }

        $instance = new PreservationInstance;
        $linked = false;
        if ($item !== null) {
            $instance->call_number = $item->call_number;
            $instance->subclass_type = $item->type.'Instance';
            $linked = true;
        }

        $reproductionMachines = ['' => 'Select a reproduction machine'] +
             ReproductionMachine::pluck('name', 'id')->all();
        $departments = ['' => 'Select a department'] + Department::pluck('name', 'id')->all();
        $projects = ['' => 'Select a project'] + Project::orderBy('name')
             ->pluck('name', 'id')->all();
        $samplingRates = ['' => 'Select a sampling rate'] +
             SamplingRate::pluck('name', 'id')->all();

        return view('instances.create',
            compact('instance', 'item', 'linked', 'reproductionMachines',
                'departments', 'projects', 'samplingRates'));
    }

    /**
     * Save the details of a new instance and its subclass, then update solr.
     */
    public function store(InstanceRequest $request)
    {
        $input = $request->all();
        $batch = isset($input['batch']) ? true : false;
        $batchSize = $input['batch_size'];
        $mark = isset($input['mark']) ? true : false;

        $instanceId = null;
        $instances = [];

        // Update MySQL
        DB::transaction(
            function () use ($request, $input, $batch, $batchSize, $mark,
                &$instanceId, &$instances) {
                // The transaction id will be used by the 'revisionable' package
                // when a model event is fired. We are passing it down via a connection
                // variable.
                $transactionId = Uuid::uuid4();
                DB::statement("set @transaction_id = '$transactionId';");

                $batchIndex = 0;

                do {
                    $subclass = new $request->subclass_type;
                    $subclass->fill($input['subclass']);

                    $instance = new PreservationInstance;
                    $instance->subclass_type = $input['subclass_type'];
                    $instance->fill($input);

                    $subclass->save();
                    $instance->subclass_id = $subclass->id;
                    $instance->save();
                    if ($mark) {
                        $instance->addMark();
                    }

                    $instanceId = $instance->id;
                    $instances[] = $instance;
                } while ($batch && ++$batchIndex < $batchSize);

                DB::statement('set @transaction_id = null;');
            });

        // Update Solr
        $this->solrInstances->update($instances);
        // we track which AV items have preservation instances
        // so for each created preservation instance, the related item should be updated
        foreach ($instances as $instance) {
            $item =
        AudioVisualItem::where('call_number', $instance->call_number)->first();
            if ($item !== null) {
                $this->solrItems->update($item);
            }
        }

        if ($batch) {
            $request->session()->put('alert', ['type' => 'success', 'message' => '<strong>Woot!</strong> '.
        'Preservation instances were successfully created.', ]);

            return redirect()->route('instances.index');
        } else {
            $request->session()->put('alert', ['type' => 'success', 'message' => '<strong>Woot!</strong> '.
        'Preservation instance was successfully created.', ]);

            return redirect()->route('instances.show', [$instanceId]);
        }
    }

    /**
     * Display the form for editing a instance.
     */
    public function edit($id)
    {
        $instance = PreservationInstance::findOrFail($id);
        $transfers = $instance->transfers()->get();
        $cuts = $instance->cuts()->get();

        $departments = ['' => 'Select a department'] +
             Department::pluck('name', 'id')->all();
        $projects = ['' => 'Select a project'] +
             Project::orderBy('name')->pluck('name', 'id')->all();
        $reproductionMachines = ['' => 'Select a reproduction machine'] +
             ReproductionMachine::pluck('name', 'id')->all();
        $tapeBrands = ['' => 'Select a tape brand'] +
             TapeBrand::pluck('name', 'id')->all();
        $samplingRates = ['' => 'Select a sampling rate'] +
             SamplingRate::pluck('name', 'id')->all();
        $pmSpeeds = ['' => 'Select a speed'] +
             PmSpeed::pluck('name', 'id')->all();

        return view('instances.edit',
            compact('instance', 'transfers', 'cuts', 'departments', 'projects',
                'reproductionMachines', 'tapeBrands', 'samplingRates', 'pmSpeeds'));
    }

    /**
     * Display the form for editing multiple instances at a time.
     */
    public function batchEdit(Request $request)
    {
        $max = PreservationInstance::BATCH_EDIT_MAX_LIMIT;

        $instanceIds = explode(',', $request->input('ids'));
        // See similar in ItemsController.php for comments on the below
        if ($request->method() === 'POST') {
            $request->session()->put('batchInstanceIds', $instanceIds);
        } elseif ($request->method() === 'GET') {
            $instanceIds = $request->session()->get('batchInstanceIds');
        }

        if ($instanceIds === null) {
            $request->session()->put('alert', ['type' => 'warning', 'message' => '<strong>Hmm, something\'s up.</strong> '.
        'That batch edit form is no longer valid. Please make a '.
        'new selection and try batch editing again.', ]);

            return redirect()->route('instances.index');
        }

        $instanceIdsCount = count($instanceIds);

        if ($instanceIdsCount > $max) {
            $request->session()->put('alert', ['type' => 'danger', 'message' => '<strong>Hold on there.</strong> '.
        'Batch editing is limited to '.$max.' instances. Please narrow '.
        'your selection.', ]);

            return redirect()->route('instances.index');
        }

        $first = PreservationInstance::find($instanceIds[0]);
        $subclassType = $first->subclass_type;

        $instances = PreservationInstance::whereIn('id', $instanceIds)
                            ->where('subclass_type', $subclassType)->get();
        if ($instanceIdsCount !== $instances->count()) {
            $request->session()->put('alert', ['type' => 'danger', 'message' => '<strong>Oops! There\'s a problem.</strong> '.
        'Batch editing can only be done with preservation instances of the same type. '.
        'Please change your selection.', ]);

            return redirect()->route('instances.index');
        }

        $subclassIds = [];
        foreach ($instances as $instance) {
            $subclassIds[] = $instance->subclass->id;
        }
        $subclasses = $subclassType::whereIn('id', $subclassIds)->get();

        $instance = new BatchPreservationInstance($instances, $subclasses);

        // Build select lists
        $departments = [];
        if ($instance->department_id === '<mixed>') {
            $departments = ['' => 'Select a department'] +
                     ['<mixed>' => '<mixed>'] +
                     Department::pluck('name', 'id')->all();
        } else {
            $departments = ['' => 'Select a department'] +
                     Department::pluck('name', 'id')->all();
        }

        $projects = [];
        if ($instance->project_id === '<mixed>') {
            $projects = ['' => 'Select a project'] +
                     ['<mixed>' => '<mixed>'] +
                     Project::orderBy('name')->pluck('name', 'id')->all();
        } else {
            $projects = ['' => 'Select a project'] +
                     Project::orderBy('name')->pluck('name', 'id')->all();
        }

        $reproductionMachines = [];
        if ($instance->reproduction_machine_id === '<mixed>') {
            $reproductionMachines = ['' => 'Select a reproduction machine'] +
                     ['<mixed>' => '<mixed>'] +
                     ReproductionMachine::pluck('name', 'id')->all();
        } else {
            $reproductionMachines = ['' => 'Select a reproduction machine'] +
                     ReproductionMachine::pluck('name', 'id')->all();
        }

        $tapeBrands = [];
        if ($instance->tape_brand_id === '<mixed>') {
            $tapeBrands = ['' => 'Select a tape brand'] +
                     ['<mixed>' => '<mixed>'] +
                     TapeBrand::pluck('name', 'id')->all();
        } else {
            $tapeBrands = ['' => 'Select a tape brand'] +
                     TapeBrand::pluck('name', 'id')->all();
        }

        $samplingRates = [];
        if ($instance->sampling_rate_id === '<mixed>') {
            $samplingRates = ['' => 'Select a sampling rate'] +
                     ['<mixed>' => '<mixed>'] +
                     SamplingRate::pluck('name', 'id')->all();
        } else {
            $samplingRates = ['' => 'Select a sampling rate'] +
                     SamplingRate::pluck('name', 'id')->all();
        }

        $pmSpeeds = [];
        if ($instance->pm_speed_id === '<mixed>') {
            $pmSpeeds = ['' => 'Select a speed'] +
                     ['<mixed>' => '<mixed>'] +
                     PmSpeed::pluck('name', 'id')->all();
        } else {
            $pmSpeeds = ['' => 'Select a speed'] +
                     PmSpeed::pluck('name', 'id')->all();
        }

        return view('instances.edit',
            compact('instance', 'departments', 'projects', 'reproductionMachines',
                'tapeBrands', 'samplingRates', 'pmSpeeds'));
    }

    public function resolveRange(Request $request)
    {
        return parent::rangeFor($request, $this->solrInstances);
    }

    public function update($id, InstanceRequest $request)
    {
        $input = $request->all();
        $instance = PreservationInstance::findOrFail($id);
        $subclass = $instance->subclass;

        $originalCallNumber = $instance->call_number;

        $instance->fill($input);
        $subclass->fill($input['subclass']);

        // This will be uncommon
        $callNumberChanged = $instance->isDirty('call_number');

        // Update MySQL
        DB::transaction(function () use ($instance, $subclass, $callNumberChanged) {
            $transactionId = Uuid::uuid4();
            DB::statement("set @transaction_id = '$transactionId';");

            if ($callNumberChanged) {
                $transfers = $instance->transfers;
                foreach ($transfers as $transfer) {
                    $transfer->call_number = $instance->call_number;
                    $transfer->save();
                }
                $cuts = $instance->cuts;
                foreach ($cuts as $cut) {
                    $cut->call_number = $instance->call_number;
                    $cut->save();
                }
            }

            $subclass->save();
            $instance->touch(); // Touch in case not dirty and subclass is dirty
            $instance->save();

            DB::statement('set @transaction_id = null;');
        });

        // Update Solr
        if ($callNumberChanged) {
            // Need to update the original and new related items in Solr in case cuts
            // were on the original.
            $originalItem =
        AudioVisualItem::where('call_number', $originalCallNumber)->first();
            $newItem =
        AudioVisualItem::where('call_number', $instance->call_number)->first();
            $this->solrItems->update([$originalItem, $newItem]);
            // Need to update transfers since the call number has changed.
            $this->solrTransfers->update($instance->transfers);
        }
        $this->solrInstances->update($instance);

        $request->session()->put('alert', ['type' => 'success', 'message' => '<strong>Yep.</strong> '.
        'Preservation instance was successfully updated.', ]);

        return redirect()->route('instances.show', [$id]);
    }

    /**
     * Update multiple instances at once.
     */
    public function batchUpdate(InstanceRequest $request)
    {
        $input = $request->allWithoutMixed();
        $instanceIds = explode(',', $input['ids']);
        unset($input['ids']);
        $instances = PreservationInstance::whereIn('id', $instanceIds)->get();

        $callNumberChanged = false;
        // Determine if the call number has changed, which will be uncommon
        if (isset($input['callNumber'])) {
            foreach ($instances as $instance) {
                if ($instance->call_number !== $input['callNumber']) {
                    $callNumberChanged = true;
                    break;
                }
            }
        }

        $originalCallNumbers = [];
        $transfersToUpdateInSolr = [];
        // Update MySQL
        DB::transaction(function () use ($instances, $callNumberChanged, $input,
            &$originalCallNumbers, &$transfersToUpdateInSolr) {
            $transactionId = Uuid::uuid4();
            DB::statement("set @transaction_id = '$transactionId';");

            foreach ($instances as $instance) {
                $originalCallNumbers[] = $instance->call_number;

                $instance->fill($input);
                $subclass = $instance->subclass;
                $subclass->fill($input['subclass']);

                if ($callNumberChanged) {
                    $transfers = $instance->transfers;
                    foreach ($transfers as $transfer) {
                        $transfer->call_number = $instance->call_number;
                        $transfer->save();
                        $transfersToUpdateInSolr[] = $transfer;
                    }
                    $cuts = $instance->cuts;
                    foreach ($cuts as $cut) {
                        $cut->call_number = $instance->call_number;
                        $cut->save();
                    }
                }

                $subclass->save();
                $instance->touch(); // Touch in case not dirty and subclass is dirty
                $instance->save();
            }

            DB::statement('set @transaction_id = null;');
        });

        // Update Solr
        if ($callNumberChanged) {
            // Need to update the items core because cuts may have moved from one call
            // number to another
            $items =
        AudioVisualItem::whereIn('call_number', $originalCallNumbers)->get();
            $newItem =
        AudioVisualItem::where('call_number', $input['callNumber'])->first();
            $items->push($newItem);
            $this->solrItems->update($items);
            // Need to update transfers since the call number has changed.
            $this->solrTransfers->update($transfersToUpdateInSolr);
        }
        $this->solrInstances->update($instances);

        $request->session()->forget('batchInstanceIds');

        $request->session()->put('alert', ['type' => 'success', 'message' => '<strong>Woohoo!</strong> '.
        'Preservation instances were successfully updated.', ]);

        return redirect()->route('instances.index');
    }

    public function destroy($id, Request $request)
    {
        $instance = PreservationInstance::findOrFail($id);
        $subclass = $instance->subclass;

        $command = $request->deleteCommand;

        $transfers = null;
        $cuts = null;

        // Update MySQL
        DB::transaction(function () use ($command, $instance, $subclass,
            &$transfers, &$cuts) {
            $transactionId = Uuid::uuid4();
            DB::statement("set @transaction_id = '$transactionId';");

            if ($command === 'all') {
                $transfers = $instance->transfers;
                foreach ($transfers as $transfer) {
                    $transfer->subclass->delete();
                    $transfer->removeAllMarks();
                    $transfer->delete();
                }

                $cuts = $instance->cuts;
                foreach ($cuts as $cut) {
                    $cut->delete();
                }
            }

            $instance->removeAllMarks();
            $instance->delete();
            $subclass->delete();

            DB::statement('set @transaction_id = null;');
        });

        // Update Solr
        $this->solrInstances->delete($instance);
        if ($command === 'all') {
            if ($transfers !== null) {
                $this->solrTransfers->delete($transfers);
            }
            if ($cuts !== null) {
                // Since cuts were deleted, we need to get the audio visual item
                // and update it in Solr to remove the cuts from the index.
                $item =
          AudioVisualItem::where('call_number', $instance->call_number)->first();
                if ($item !== null) {
                    $this->solrItems->update($item);
                }
            }
        }

        $request->session()->put('alert', ['type' => 'success', 'message' => '<strong>It\'s done!</strong> '.
        'Preservation instance was successfully deleted.', ]);

        return redirect()->route('instances.index');
    }

    public function batchDestroy(Request $request)
    {
        $max = 100;

        $instanceIds = explode(',', $request->ids);
        $instances = PreservationInstance::whereIn('id', $instanceIds)->get();

        if ($instances->count() > $max) {
            $request->session()->put('alert', ['type' => 'danger', 'message' => '<strong>Whoa there!</strong> '.
        'Batch deleting is limited to '.$max.' instances. Please narrow '.
        'your selection.', ]);

            return redirect()->route('instances.index');
        }

        $command = $request->deleteCommand;
        $transfers = $cuts = null;

        // Update MySQL
        DB::transaction(function () use ($command, $instanceIds, $instances,
            &$transfers, &$cuts) {
            $transactionId = Uuid::uuid4();
            DB::statement("set @transaction_id = '$transactionId';");

            if ($command === 'all') {
                $transfers =
          Transfer::whereIn('preservation_instance_id', $instanceIds)->get();
                foreach ($transfers as $transfer) {
                    $transfer->subclass->delete();
                    $transfer->removeAllMarks();
                    $transfer->delete();
                }

                $cuts = Cut::whereIn('preservation_instance_id', $instanceIds)->get();
                foreach ($cuts as $cut) {
                    $cut->delete();
                }
            }

            foreach ($instances as $instance) {
                $instance->subclass->delete();
                $instance->removeAllMarks();
                $instance->delete();
            }

            DB::statement('set @transaction_id = null;');
        });

        // Update Solr
        $this->solrInstances->delete($instances);
        if ($command === 'all') {
            if ($transfers !== null) {
                $this->solrTransfers->delete($transfers);
            }
            if ($cuts !== null) {
                // Since cuts where deleted, we need to get the audio visual items
                // and update them in Solr to remove the cuts from the index.
                $cutCallNumbers = $cuts->pluck('call_number')->unique()->all();
                $items =
          AudioVisualItem::whereIn('call_number', $cutCallNumbers)->get();
                if ($items !== null) {
                    $this->solrItems->update($items);
                }
            }
        }

        $request->session()->put('alert', ['type' => 'success', 'message' => '<strong>It\'s done!</strong> '.
        'Preservation instances were successfully deleted.', ]);

        return redirect()->route('instances.index');
    }

    /**
     * Return the fields that are exportable for the given selection of instances.
     */
    public function batchExportFields(Request $request)
    {
        if ($request->ajax()) {
            $instanceIds = explode(',', $request->ids);
            $export = new InstancesExport($instanceIds);
            $fields = $export->exportableFields();

            return view('shared._data-export-fields', compact('fields'));
        }
    }

    public function batchExportBuild(Request $request)
    {
        if ($request->ajax()) {
            $instanceIds = explode(',', $request->ids);
            $fields = $request->fields;
            $export = new InstancesExport($instanceIds);
            $filePath = $export->build($fields);
            $request->session()->put('exportFilePath', $filePath);
            $response = ['status' => 'success', 'file' => $filePath];

            return response()->json($response);
        }
    }
}
