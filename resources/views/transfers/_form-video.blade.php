      {{-- VideoTransfer fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.time_base_corrector')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Time Base Corrector', 'subclass[time_base_corrector]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[time_base_corrector]')->class('form-control form-control-sm')->placeholder('e.g. BuiltIn') }}
            @if ($errors->has('subclass.time_base_corrector'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.time_base_corrector') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.ad_converter')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('A/D Converter', 'subclass[ad_converter]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[ad_converter]')->class('form-control form-control-sm')->placeholder('e.g. BuiltIn') }}
            @if ($errors->has('subclass.ad_converter'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.ad_converter') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End VideoTransfer fields --}}