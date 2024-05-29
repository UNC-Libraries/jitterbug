      {{-- Cut fields (right column) --}}
      <div class="row">
        <div class="form-group @if ($errors->has('transfer_id')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Transfer ID', 'transfer_id')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('transfer_id')->id('transfer-id')->class('form-control form-control-sm')->isReadonly() }}
            @if ($errors->has('transfer_id'))
              <div class="form-control-label"><small>{!! $errors->first('transfer_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('title')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Title', 'title')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('title')->class('form-control form-control-sm') }}
            @if ($errors->has('title'))
              <div class="form-control-label"><small>{!! $errors->first('title') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('performer_composer')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Performer Composer', 'performer_composer')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('performer_composer')->class('form-control form-control-sm') }}
            @if ($errors->has('performer_composer'))
              <div class="form-control-label"><small>{!! $errors->first('performer_composer') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('pm_start_time')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('PM Start Time', 'pm_start_time')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('pm_start_time')->class('form-control form-control-sm') }}
            @if ($errors->has('pm_start_time'))
              <div class="form-control-label"><small>{!! $errors->first('pm_start_time') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- Cut fields (right column) --}}