      {{-- Transfer fields --}}
      <div class="row">
        <div class="mb-3 @if ($errors->has('preservation_instance_id')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('PM #', 'preservation_instance_id')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            @if (isset($linked) && $linked)
              {{ html()->text('preservation_instance_id')->id('preservation-instance-id')->class('form-control form-control-sm')->isReadonly() }}
            @else
              {{ html()->text('preservation_instance_id')->id('preservation-instance-id')->class('form-control form-control-sm') }}
            @endif
            @if ($errors->has('preservation_instance_id'))
              <div class="form-control-label"><small>{!! $errors->first('preservation_instance_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('call_number')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Call Number', 'call_number')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('call_number')->id('call-number')->class('form-control form-control-sm')->isReadonly()->placeholder('Will be auto-populated') }}
            @if ($errors->has('call_number'))
              <div class="form-control-label"><small>{!! $errors->first('call_number') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('transfer_date')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Transfer Date', 'transfer_date')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            <div class="input-group date">
              {{ html()->text('transfer_date')->class('form-control form-control-sm') }}
              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            </div>
            @if ($errors->has('transfer_date'))
              <div class="form-control-label"><small>{!! $errors->first('transfer_date') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('engineer_id')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Engineer', 'engineer_id')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->select('engineer_id', $engineers, $transfer->engineer_id)->class('form-control form-control-sm') }}
            @if ($errors->has('engineer_id'))
              <div class="form-control-label"><small>{!! $errors->first('engineer_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('vendor_id')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Vendor', 'vendor_id')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->select('vendor_id', $vendors, $transfer->vendor_id)->class('form-control form-control-sm') }}
            @if ($errors->has('vendor_id'))
              <div class="form-control-label"><small>{!! $errors->first('vendor_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('playback_machine_id')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Playback Machine', 'playback_machine_id')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->select('playback_machine_id', $playbackMachines, $transfer->playback_machine_id)->class('form-control form-control-sm') }}
            @if ($errors->has('playback_machine_id'))
              <div class="form-control-label"><small>{!! $errors->first('playback_machine_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('transfer_note')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Transfer Note', 'transfer_note')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->textarea('transfer_note')->class('form-control form-control-sm')->rows(3) }}
            @if ($errors->has('transfer_note'))
              <div class="form-control-label"><small>{!! $errors->first('transfer_note') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('condition_note')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Condition Note', 'condition_note')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('condition_note')->class('form-control form-control-sm') }}
            @if ($errors->has('condition_note'))
              <div class="form-control-label"><small>{!! $errors->first('condition_note') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End Transfer fields --}}