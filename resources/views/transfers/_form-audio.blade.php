      {{-- AudioTransfer fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.stylus')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[stylus]', 'Stylus', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[stylus]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 2.0TE')) !!}
            @if ($errors->has('subclass.stylus'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.stylus') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.cartridge')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[cartridge]', 'Cartridge', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[cartridge]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Stanton 500')) !!}
            @if ($errors->has('subclass.cartridge'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.cartridge') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.first_sound')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[first_sound]', 'First Sound', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('subclass[first_sound]', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
            @if ($errors->has('subclass.first_sound'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.first_sound') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End AudioTransfer fields --}}