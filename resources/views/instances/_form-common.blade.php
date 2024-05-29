      {{-- PreservationInstance fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('call_number')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {{ html()->label('Call Number', 'call_number')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            @if (isset($linked) && $linked)
              {{ html()->text('call_number')->class('form-control form-control-sm')->isReadonly() }}
            @else
              {{ html()->text('call_number')->class('form-control form-control-sm') }}
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
            {{ html()->label('File Name', 'file_name')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            @if (routeName()==='instances.batch.edit' || old('batch'))
              {{ html()->text('file_name')->id('fileName')->class('form-control form-control-sm')->placeholder('e.g. FT6708_1_PM')->isReadonly() }}
            @else
              {{ html()->text('file_name')->id('fileName')->class('form-control form-control-sm')->placeholder('e.g. FT6708_1_PM') }}
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
            {{ html()->label('File Location', 'file_location')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('file_location')->class('form-control form-control-sm')->placeholder('e.g. CDR') }}
            @if ($errors->has('file_location'))
              <div class="form-control-label"><small>{!! $errors->first('file_location') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('file_size_in_bytes')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {{ html()->label('File Size (bytes)', 'file_size_in_bytes')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('file_size_in_bytes')->class('form-control form-control-sm') }}
            @if ($errors->has('file_size_in_bytes'))
              <div class="form-control-label"><small>{!! $errors->first('file_size_in_bytes') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('duration')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {{ html()->label('Duration', 'duration')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('duration')->class('form-control form-control-sm')->placeholder('e.g. HH:MM:SS') }}
            @if ($errors->has('duration'))
              <div class="form-control-label"><small>{!! $errors->first('duration') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('checksum')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {{ html()->label('Checksum', 'checksum')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('checksum')->class('form-control form-control-sm') }}
            @if ($errors->has('checksum'))
              <div class="form-control-label"><small>{!! $errors->first('checksum') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('access_file_location')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {{ html()->label('Access File Location', 'access_file_location')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('access_file_location')->class('form-control form-control-sm')->placeholder('e.g. Duracloud') }}
            @if ($errors->has('access_file_location'))
              <div class="form-control-label"><small>{!! $errors->first('access_file_location') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('reproduction_machine_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {{ html()->label('Repro Machine', 'reproduction_machine_id')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->select('reproduction_machine_id', $reproductionMachines, $instance->reproduction_machine_id)->class('form-control form-control-sm') }}
            @if ($errors->has('reproduction_machine_id'))
              <div class="form-control-label"><small>{!! $errors->first('reproduction_machine_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('project_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {{ html()->label('Project', 'project_id')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->select('project_id', $projects, $instance->project_id)->class('form-control form-control-sm') }}
            @if ($errors->has('project_id'))
              <div class="form-control-label"><small>{!! $errors->first('project_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('department_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {{ html()->label('Department', 'department_id')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->select('department_id', $departments, $instance->department_id)->class('form-control form-control-sm') }}
            @if ($errors->has('department_id'))
              <div class="form-control-label"><small>{!! $errors->first('department_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End PreservationInstance fields --}}
 