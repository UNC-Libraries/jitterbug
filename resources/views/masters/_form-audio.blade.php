      {{-- AudioMaster fields --}}
      <div class="row">
        {{-- audio_file_format and audio_file_codec now reside in preservation_masters in the file_format and file_codec fields --}}
        <div class="form-group @if ($errors->has('audio_file_format')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('audio_file_format', 'File Format', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('audio_file_format', routeName() === 'masters.create' ? 'BWF' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. BWF')) !!}
            @if ($errors->has('audio_file_format'))
              <div class="form-control-label"><small>{!! $errors->first('audio_file_format') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('audio_file_codec')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('audio_file_codec', 'File Codec', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('audio_file_codec', routeName() === 'masters.create' ? 'Uncompressed PCM' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Uncompressed PCM')) !!}
            @if ($errors->has('audio_file_codec'))
              <div class="form-control-label"><small>{!! $errors->first('audio_file_codec') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.sampling_rate_id')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[sampling_rate_id]', 'Sampling Rate', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {{-- Sampling rate ID 8 is for 96kHz/24bit, the default for all new audio preservation masters --}}
            {!! Form::select('subclass[sampling_rate_id]', $samplingRates, $master->subclass !== null ? $master->subclass->sampling_rate_id : 8, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.sampling_rate_id'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.sampling_rate_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>

      {{-- The fields below are only for old, analog PMs. All new PMs will be digital. So, we won't display them on the create page --}}
      @if (routeName() !== 'masters.create' && 
          ($master->subclass->tape_brand_id || $master->subclass->pm_speed_id || $master->subclass->test_tones))
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.tape_brand_id')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[tape_brand_id]', 'Tape Brand', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('subclass[tape_brand_id]', $tapeBrands, $master->subclass->tape_brand_id, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.tape_brand_id'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.tape_brand_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.pm_speed_id')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[pm_speed_id]', 'PM Speed', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('subclass[pm_speed_id]', $pmSpeeds, $master->subclass->pm_speed_id, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.pm_speed_id'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.pm_speed_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.test_tones')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[test_tones]', 'Test Tones', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[test_tones]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 1K, 10K at -10db')) !!}
            @if ($errors->has('subclass.test_tones'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.test_tones') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      @endif
      {{-- End AudioMaster fields --}}
