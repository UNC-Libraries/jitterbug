      {{-- PreservationMaster Fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('callNumber')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('callNumber', 'Call Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if ((isset($linked) && $linked) || routeName()==='masters.edit' || routeName()==='masters.batch.edit')
              {!! Form::text('callNumber', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) !!}
            @else
              {!! Form::text('callNumber', null, array('class' => 'form-control form-control-sm')) !!}
            @endif
            @if ($errors->has('callNumber'))
              <div class="form-control-label"><small>{!! $errors->first('callNumber') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('fileName')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('fileName', 'File Name', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (routeName()==='masters.batch.edit')
              {!! Form::text('fileName', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. FT6708_1_PM', 'readonly' => 'readonly')) !!}
            @else
              {!! Form::text('fileName', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. FT6708_1_PM')) !!}
            @endif
            @if ($errors->has('fileName'))
              <div class="form-control-label"><small>{!! $errors->first('fileName') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('fileLocation')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('fileLocation', 'File Location', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('fileLocation', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. CDR')) !!}
            @if ($errors->has('fileLocation'))
              <div class="form-control-label"><small>{!! $errors->first('fileLocation') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('fileSizeInBytes')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('fileSizeInBytes', 'File Size (bytes)', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('fileSizeInBytes', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('fileSizeInBytes'))
              <div class="form-control-label"><small>{!! $errors->first('fileSizeInBytes') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('duration')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('duration', 'Duration', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('duration', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. HH:MM:SS')) !!}
            @if ($errors->has('duration'))
              <div class="form-control-label"><small>{!! $errors->first('duration') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('checksum')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('checksum', 'Checksum', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('checksum', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('checksum'))
              <div class="form-control-label"><small>{!! $errors->first('checksum') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('accessFileLocation')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('accessFileLocation', 'Access File Location', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('accessFileLocation', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Duracloud')) !!}
            @if ($errors->has('accessFileLocation'))
              <div class="form-control-label"><small>{!! $errors->first('accessFileLocation') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- Reproduction machine is only for old, analog PMs. All new PMs will be digital. So, we won't display it on the create page. --}}
      @if (routeName() !== 'masters.create' && $master->reproductionMachineId)
      <div class="row">
        <div class="form-group @if ($errors->has('reproductionMachineId')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('reproductionMachineId', 'Repro Machine', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('reproductionMachineId', $reproductionMachines, $master->reproductionMachineId, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('reproductionMachineId'))
              <div class="form-control-label"><small>{!! $errors->first('reproductionMachineId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      @endif
      <div class="row">
        <div class="form-group @if ($errors->has('projectId')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('projectId', 'Project', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('projectId', $projects, $master->projectId, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('projectId'))
              <div class="form-control-label"><small>{!! $errors->first('projectId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('departmentId')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('departmentId', 'Department', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('departmentId', $departments, $master->departmentId, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('departmentId'))
              <div class="form-control-label"><small>{!! $errors->first('departmentId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End PreservationMaster Fields --}}
 