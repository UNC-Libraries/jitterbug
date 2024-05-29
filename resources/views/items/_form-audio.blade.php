      {{-- AudioItem fields --}}
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Listening Copy', 'subclass[listening_copy]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->subclass->listening_copy !== '<mixed>')
              <label class="radio-inline">
                {{ html()->radio('subclass[listening_copy]', false, '1') }} Yes
              </label>
              <label class="radio-inline">
                {{ html()->radio('subclass[listening_copy]', true, '0') }} No
              </label>
            @else
              {{ html()->select('subclass[listening_copy]', array('1' => 'Yes', '0' => 'No', '<mixed>' => '<mixed>'), $item->subclass->listening_copy)->class('form-control form-control-sm') }}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Mono/Stereo', 'subclass[audio_mono_stereo]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->subclass->audio_mono_stereo !== '<mixed>')
              <label class="radio-inline">
                {{ html()->radio('subclass[audio_mono_stereo]', false, 'M') }} Mono
              </label>
              <label class="radio-inline">
                {{ html()->radio('subclass[audio_mono_stereo]', false, 'S') }} Stereo
              </label>
              <label class="radio-inline">
                {{ html()->radio('subclass[audio_mono_stereo]', true, '') }} N/A
              </label>
            @else
              {{ html()->select('subclass[audio_mono_stereo]', array('M' => 'Mono', 'S' => 'Stereo', '' => 'N/A', '<mixed>' => '<mixed>'), $item->subclass->audio_mono_stereo)->class('form-control form-control-sm') }}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.size')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Size', 'subclass[size]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[size]')->class('form-control form-control-sm')->placeholder('e.g. 12"') }}
            @if ($errors->has('subclass.size'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.size') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.track_configuration')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Track Config', 'subclass[track_configuration]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[track_configuration]')->id('track-configuration')->class('form-control form-control-sm')->placeholder('e.g. 1/2 track') }}
            @if ($errors->has('subclass.track_configuration'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.track_configuration') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.audio_base')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Base', 'subclass[audio_base]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[audio_base]')->id('audio-base')->class('form-control form-control-sm')->placeholder('e.g. Polyester') }}
            @if ($errors->has('subclass.audio_base'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.audio_base') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.audio_content_description')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Content Description', 'subclass[audio_content_description]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->textarea('subclass[audio_content_description]')->class('form-control form-control-sm')->rows(3) }}
            @if ($errors->has('subclass.audio_content_description'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.audio_content_description') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End AudioItem fields --}}