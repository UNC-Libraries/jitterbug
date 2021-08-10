      {{-- Cut fields (right column) --}}
      <div class="row">
        <div class="form-group @if ($errors->has('transfer_id')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('transfer_id', 'Transfer ID', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('transfer_id', null, array('id' => 'transfer-id', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly')) !!}
            @if ($errors->has('transfer_id'))
              <div class="form-control-label"><small>{!! $errors->first('transfer_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
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
        <div class="form-group @if ($errors->has('performer_composer')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('performer_composer', 'Performer Composer', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('performer_composer', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('performer_composer'))
              <div class="form-control-label"><small>{!! $errors->first('performer_composer') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('pm_start_time')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('pm_start_time', 'PM Start Time', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('pm_start_time', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('pm_start_time'))
              <div class="form-control-label"><small>{!! $errors->first('pm_start_time') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- Cut fields (right column) --}}