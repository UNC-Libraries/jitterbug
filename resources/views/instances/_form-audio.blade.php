      {{-- AudioInstance fields --}}
      <div class="row">
        {{-- audio_file_format and audio_file_codec now reside in preservation_instances in the file_format and file_codec fields --}}
        <div class="form-group @if ($errors->has('audio_file_format')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('File Format', 'audio_file_format')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('audio_file_format', routeName() === 'instances.create' ? 'BWF' : null)->class('form-control form-control-sm')->placeholder('e.g. BWF') }}
            @if ($errors->has('audio_file_format'))
              <div class="form-control-label"><small>{!! $errors->first('audio_file_format') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('audio_file_codec')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('File Codec', 'audio_file_codec')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('audio_file_codec', routeName() === 'instances.create' ? 'Uncompressed PCM' : null)->class('form-control form-control-sm')->placeholder('e.g. Uncompressed PCM') }}
            @if ($errors->has('audio_file_codec'))
              <div class="form-control-label"><small>{!! $errors->first('audio_file_codec') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.sampling_rate_id')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Sampling Rate', 'subclass[sampling_rate_id]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{-- Sampling rate ID 8 is for 96kHz/24bit, the default for all new audio preservation instances --}}
            {{ html()->select('subclass[sampling_rate_id]', $samplingRates, $instance->subclass !== null ? $instance->subclass->sampling_rate_id : 8)->class('form-control form-control-sm') }}
            @if ($errors->has('subclass.sampling_rate_id'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.sampling_rate_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>

      {{-- The fields below are only for old, analog PMs. All new PMs will be digital. So, we won't display them on the create page --}}
      @if (routeName() !== 'instances.create' &&
          ($instance->subclass->tape_brand_id || $instance->subclass->pm_speed_id || $instance->subclass->test_tones))
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.tape_brand_id')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Tape Brand', 'subclass[tape_brand_id]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->select('subclass[tape_brand_id]', $tapeBrands, $instance->subclass->tape_brand_id)->class('form-control form-control-sm') }}
            @if ($errors->has('subclass.tape_brand_id'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.tape_brand_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.pm_speed_id')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('PM Speed', 'subclass[pm_speed_id]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->select('subclass[pm_speed_id]', $pmSpeeds, $instance->subclass->pm_speed_id)->class('form-control form-control-sm') }}
            @if ($errors->has('subclass.pm_speed_id'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.pm_speed_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.test_tones')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Test Tones', 'subclass[test_tones]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[test_tones]')->class('form-control form-control-sm')->placeholder('e.g. 1K, 10K at -10db') }}
            @if ($errors->has('subclass.test_tones'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.test_tones') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      @endif
      {{-- End AudioInstance fields --}}
