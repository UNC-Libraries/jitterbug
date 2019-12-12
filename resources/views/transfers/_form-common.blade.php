      {{-- Transfer fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('preservationMasterId')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('preservationMasterId', 'PM #', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (isset($linked) && $linked)
              {!! Form::text('preservationMasterId', null, array('id' => 'preservation-master-id', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly')) !!}
            @else
              {!! Form::text('preservationMasterId', null, array('id' => 'preservation-master-id', 'class' => 'form-control form-control-sm')) !!}
            @endif
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
        <div class="form-group @if ($errors->has('transferDate')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('transferDate', 'Transfer Date', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            <div class="input-group date">
              {!! Form::text('transferDate', null, array('class' => 'form-control form-control-sm')) !!}
              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            </div>
            @if ($errors->has('transferDate'))
              <div class="form-control-label"><small>{!! $errors->first('transferDate') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('engineerId')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('engineerId', 'Engineer', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('engineerId', $engineers, $transfer->engineerId, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('engineerId'))
              <div class="form-control-label"><small>{!! $errors->first('engineerId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('vendorId')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('vendorId', 'Vendor', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('vendorId', $vendors, $transfer->vendorId, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('vendorId'))
              <div class="form-control-label"><small>{!! $errors->first('vendorId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('playbackMachineId')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('playbackMachineId', 'Playback Machine', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('playbackMachineId', $playbackMachines, $transfer->playbackMachineId, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('playbackMachineId'))
              <div class="form-control-label"><small>{!! $errors->first('playbackMachineId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('transferNote')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('transferNote', 'Transfer Note', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('transferNote', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
            @if ($errors->has('transferNote'))
              <div class="form-control-label"><small>{!! $errors->first('transferNote') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('conditionNote')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('conditionNote', 'Condition Note', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('conditionNote', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('conditionNote'))
              <div class="form-control-label"><small>{!! $errors->first('conditionNote') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End Transfer fields --}}