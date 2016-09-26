      <div class="row">
        <div class="form-group @if ($errors->has('audioFileFormat')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('audioFileFormat', 'File Format', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('audioFileFormat', routeName() === 'masters.create' ? 'BWF' : null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('audioFileFormat'))
              <div class="form-control-label"><small>{!! $errors->first('audioFileFormat') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('audioFileCodec')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('audioFileCodec', 'File Codec', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('audioFileCodec', routeName() === 'masters.create' ? 'Uncompressed PCM' : null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('audioFileCodec'))
              <div class="form-control-label"><small>{!! $errors->first('audioFileCodec') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('masterable.samplingRateId')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('masterable[samplingRateId]', 'Sampling Rate', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {{-- Sampling rate ID 8 is for 96kHz/24bit, the default for all new audio preservation masters --}}
            {!! Form::select('masterable[samplingRateId]', $samplingRates, $master->masterable !== null ? $master->masterable->samplingRateId : 8, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('masterable.samplingRateId'))
              <div class="form-control-label"><small>{!! $errors->first('masterable.samplingRateId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>

      {{-- The fields below are only for old, analog PMs. All new PMs will be digital. So, we won't display them on the create page --}}
      @if (routeName() !== 'masters.create' && 
          ($master->masterable->tapeBrandId || $master->masterable->pmSpeedId || $master->masterable->testTones))
      <div class="row">
        <div class="form-group @if ($errors->has('masterable.tapeBrandId')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('masterable[tapeBrandId]', 'Tape Brand', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('masterable[tapeBrandId]', $tapeBrands, $master->masterable->tapeBrandId, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('masterable.tapeBrandId'))
              <div class="form-control-label"><small>{!! $errors->first('masterable.tapeBrandId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('masterable.pmSpeedId')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('masterable[pmSpeedId]', 'PM Speed', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('masterable[pmSpeedId]', $pmSpeeds, $master->masterable->pmSpeedId, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('masterable.pmSpeedId'))
              <div class="form-control-label"><small>{!! $errors->first('masterable.pmSpeedId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('masterable.testTones')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('masterable[testTones]', 'Test Tones', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('masterable[testTones]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 1K, 10K at -10db')) !!}
            @if ($errors->has('masterable.testTones'))
              <div class="form-control-label"><small>{!! $errors->first('masterable.testTones') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      @endif
