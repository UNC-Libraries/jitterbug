      {{-- AudioTransfer fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.stylus')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Stylus', 'subclass[stylus]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[stylus]')->class('form-control form-control-sm')->placeholder('e.g. 2.0TE') }}
            @if ($errors->has('subclass.stylus'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.stylus') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.cartridge')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Cartridge', 'subclass[cartridge]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[cartridge]')->class('form-control form-control-sm')->placeholder('e.g. Stanton 500') }}
            @if ($errors->has('subclass.cartridge'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.cartridge') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.first_sound')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('First Sound', 'subclass[first_sound]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->textarea('subclass[first_sound]')->class('form-control form-control-sm')->rows(3) }}
            @if ($errors->has('subclass.first_sound'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.first_sound') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End AudioTransfer fields --}}