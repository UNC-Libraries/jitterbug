      {{-- Transfer fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('preservation_instance_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('preservation_instance_id', 'PM #', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (isset($linked) && $linked)
              {!! Form::text('preservation_instance_id', null, array('id' => 'preservation-instance-id', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly')) !!}
            @else
              {!! Form::text('preservation_instance_id', null, array('id' => 'preservation-instance-id', 'class' => 'form-control form-control-sm')) !!}
            @endif
            @if ($errors->has('preservation_instance_id'))
              <div class="form-control-label"><small>{!! $errors->first('preservation_instance_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('call_number')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('call_number', 'Call Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('call_number', null, array('id' => 'call-number', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly', 'placeholder' => 'Will be auto-populated')) !!}
            @if ($errors->has('call_number'))
              <div class="form-control-label"><small>{!! $errors->first('call_number') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('transfer_date')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('transfer_date', 'Transfer Date', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            <div class="input-group date">
              {!! Form::text('transfer_date', null, array('class' => 'form-control form-control-sm')) !!}
              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            </div>
            @if ($errors->has('transfer_date'))
              <div class="form-control-label"><small>{!! $errors->first('transfer_date') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('engineer_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('engineer_id', 'Engineer', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('engineer_id', $engineers, $transfer->engineer_id, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('engineer_id'))
              <div class="form-control-label"><small>{!! $errors->first('engineer_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('vendor_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('vendor_id', 'Vendor', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('vendor_id', $vendors, $transfer->vendor_id, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('vendor_id'))
              <div class="form-control-label"><small>{!! $errors->first('vendor_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('playback_machine_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('playback_machine_id', 'Playback Machine', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('playback_machine_id', $playbackMachines, $transfer->playback_machine_id, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('playback_machine_id'))
              <div class="form-control-label"><small>{!! $errors->first('playback_machine_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('transfer_note')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('transfer_note', 'Transfer Note', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('transfer_note', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
            @if ($errors->has('transfer_note'))
              <div class="form-control-label"><small>{!! $errors->first('transfer_note') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('condition_note')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('condition_note', 'Condition Note', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('condition_note', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('condition_note'))
              <div class="form-control-label"><small>{!! $errors->first('condition_note') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End Transfer fields --}}