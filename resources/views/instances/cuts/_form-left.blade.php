      {{-- Cut fields (left column) --}}
      <div class="row">
        <div class="form-group @if ($errors->has('preservation_instance_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('preservation_instance_id', 'PM #', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('preservation_instance_id', null, array('id' => 'preservation-instance-id', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly')) !!}
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
        <div class="form-group @if ($errors->has('cut_number')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('cut_number', 'Cut Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('cut_number', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('cut_number'))
              <div class="form-control-label"><small>{!! $errors->first('cut_number') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End Cut fields (left column) --}}