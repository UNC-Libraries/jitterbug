      {{-- Cut fields (right column) --}}
      <div class="row">
        <div class="form-group @if ($errors->has('title')) has-danger @endif">
          <div class="col-xs-4 detail-label">
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
          <div class="col-xs-4 detail-label">
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
      <div class="row">
        <div class="form-group @if ($errors->has('pmStartTime')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('pmStartTime', 'PM Start Time', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('pmStartTime', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('pmStartTime'))
              <div class="form-control-label"><small>{!! $errors->first('pmStartTime') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- Cut fields (right column) --}}