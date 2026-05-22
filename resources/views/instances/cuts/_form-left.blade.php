      {{-- Cut fields (left column) --}}
      <div class="row">
        <div class="mb-3 @if ($errors->has('preservation_instance_id')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('PM #', 'preservation_instance_id')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('preservation_instance_id')->id('preservation-instance-id')->class('form-control form-control-sm')->isReadonly() }}
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
        <div class="mb-3 @if ($errors->has('side')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Side', 'side')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('side')->class('form-control form-control-sm') }}
            @if ($errors->has('side'))
              <div class="form-control-label"><small>{!! $errors->first('side') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('cut_number')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Cut Number', 'cut_number')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('cut_number')->class('form-control form-control-sm') }}
            @if ($errors->has('cut_number'))
              <div class="form-control-label"><small>{!! $errors->first('cut_number') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End Cut fields (left column) --}}