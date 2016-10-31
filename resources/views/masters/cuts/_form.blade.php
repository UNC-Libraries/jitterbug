      {{-- Cut fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('preservationMasterId')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('preservationMasterId', 'PM #', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('preservationMasterId', null, array('id' => 'preservation-master-id', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly')) !!}
            @if ($errors->has('preservationMasterId'))
              <div class="form-control-label"><small>{!! $errors->first('preservationMasterId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('callNumber')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('callNumber', 'Call Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('callNumber', null, array('id' => 'call-number', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly', 'placeholder' => 'Will be auto-populated')) !!}
            @if ($errors->has('callNumber'))
              <div class="form-control-label"><small>{!! $errors->first('callNumber') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('side')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('side', 'Side', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('side', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('side'))
              <div class="form-control-label"><small>{!! $errors->first('side') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('cutNumber')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('cutNumber', 'Cut Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('cutNumber', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('cutNumber'))
              <div class="form-control-label"><small>{!! $errors->first('cutNumber') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('title')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('title', 'Title', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('title', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('title'))
              <div class="form-control-label"><small>{!! $errors->first('title') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('performerComposer')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('performerComposer', 'Performer Composer', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('performerComposer', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('performerComposer'))
              <div class="form-control-label"><small>{!! $errors->first('performerComposer') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End Transfer fields --}}