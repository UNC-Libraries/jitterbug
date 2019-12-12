      {{-- AudioMaster fields --}}
      <div class="row">
        {{-- audioFileFormat and audioFileCodec now reside in preservation_masters in the file_format and file_codec fields --}}
        <div class="form-group @if ($errors->has('audioFileFormat')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('audioFileFormat', 'File Format', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('audioFileFormat', routeName() === 'masters.create' ? 'BWF' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. BWF')) !!}
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
            {!! Form::text('audioFileCodec', routeName() === 'masters.create' ? 'Uncompressed PCM' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Uncompressed PCM')) !!}
            @if ($errors->has('audioFileCodec'))
              <div class="form-control-label"><small>{!! $errors->first('audioFileCodec') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.samplingRateId')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[samplingRateId]', 'Sampling Rate', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {{-- Sampling rate ID 8 is for 96kHz/24bit, the default for all new audio preservation masters --}}
            {!! Form::select('subclass[samplingRateId]', $samplingRates, $master->subclass !== null ? $master->subclass->samplingRateId : 8, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.samplingRateId'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.samplingRateId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>

      {{-- The fields below are only for old, analog PMs. All new PMs will be digital. So, we won't display them on the create page --}}
      @if (routeName() !== 'masters.create' && 
          ($master->subclass->tapeBrandId || $master->subclass->pmSpeedId || $master->subclass->testTones))
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.tapeBrandId')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[tapeBrandId]', 'Tape Brand', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('subclass[tapeBrandId]', $tapeBrands, $master->subclass->tapeBrandId, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.tapeBrandId'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.tapeBrandId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.pmSpeedId')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[pmSpeedId]', 'PM Speed', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('subclass[pmSpeedId]', $pmSpeeds, $master->subclass->pmSpeedId, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.pmSpeedId'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.pmSpeedId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.testTones')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[testTones]', 'Test Tones', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[testTones]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 1K, 10K at -10db')) !!}
            @if ($errors->has('subclass.testTones'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.testTones') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      @endif
      {{-- End AudioMaster fields --}}
