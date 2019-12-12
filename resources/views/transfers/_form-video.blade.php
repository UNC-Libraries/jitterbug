      {{-- VideoTransfer fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.timeBaseCorrector')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[timeBaseCorrector]', 'Time Base Corrector', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[timeBaseCorrector]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. BuiltIn')) !!}
            @if ($errors->has('subclass.timeBaseCorrector'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.timeBaseCorrector') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.adConverter')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[adConverter]', 'A/D Converter', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[adConverter]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. BuiltIn')) !!}
            @if ($errors->has('subclass.adConverter'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.adConverter') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End VideoTransfer fields --}}