      {{-- PreservationInstance fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('call_number')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('call_number', 'Call Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (isset($linked) && $linked)
              {!! Form::text('call_number', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) !!}
            @else
              {!! Form::text('call_number', null, array('class' => 'form-control form-control-sm')) !!}
            @endif
            @if ($errors->has('call_number'))
              <div class="form-control-label"><small>{!! $errors->first('call_number') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('file_name')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('file_name', 'File Name', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (routeName()==='instances.batch.edit' || old('batch'))
              {!! Form::text('file_name', null, array('id' => 'fileName', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. FT6708_1_PM', 'readonly' => 'readonly')) !!}
            @else
              {!! Form::text('file_name', null, array('id' => 'fileName', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. FT6708_1_PM')) !!}
            @endif
            @if ($errors->has('file_name'))
              <div class="form-control-label"><small>{!! $errors->first('file_name') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('file_location')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('file_location', 'File Location', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('file_location', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. CDR')) !!}
            @if ($errors->has('file_location'))
              <div class="form-control-label"><small>{!! $errors->first('file_location') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('file_size_in_bytes')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('file_size_in_bytes', 'File Size (bytes)', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('file_size_in_bytes', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('file_size_in_bytes'))
              <div class="form-control-label"><small>{!! $errors->first('file_size_in_bytes') !!}</small></div>
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
        <div class="form-group @if ($errors->has('access_file_location')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('access_file_location', 'Access File Location', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('access_file_location', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Duracloud')) !!}
            @if ($errors->has('access_file_location'))
              <div class="form-control-label"><small>{!! $errors->first('access_file_location') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('reproduction_machine_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('reproduction_machine_id', 'Repro Machine', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('reproduction_machine_id', $reproductionMachines, $instance->reproduction_machine_id, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('reproduction_machine_id'))
              <div class="form-control-label"><small>{!! $errors->first('reproduction_machine_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('project_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('project_id', 'Project', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('project_id', $projects, $instance->project_id, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('project_id'))
              <div class="form-control-label"><small>{!! $errors->first('project_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('department_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('department_id', 'Department', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('department_id', $departments, $instance->department_id, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('department_id'))
              <div class="form-control-label"><small>{!! $errors->first('department_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End PreservationInstance fields --}}
 