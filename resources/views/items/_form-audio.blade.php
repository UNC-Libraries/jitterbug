      {{-- AudioItem fields --}}
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[listening_copy]', 'Listening Copy', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->subclass->listening_copy !== '<mixed>')
              <label class="radio-inline">
                {!! Form::radio('subclass[listening_copy]', '1') !!} Yes
              </label>
              <label class="radio-inline">
                {!! Form::radio('subclass[listening_copy]', '0', true) !!} No
              </label>
            @else
              {!! Form::select('subclass[listening_copy]',
              array('1' => 'Yes', '0' => 'No', '<mixed>' => '<mixed>'), $item->subclass->listening_copy, array('class' => 'form-control form-control-sm')) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[audio_mono_stereo]', 'Mono/Stereo', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->subclass->audio_mono_stereo !== '<mixed>')
              <label class="radio-inline">
                {!! Form::radio('subclass[audio_mono_stereo]', 'M') !!} Mono
              </label>
              <label class="radio-inline">
                {!! Form::radio('subclass[audio_mono_stereo]', 'S') !!} Stereo
              </label>
              <label class="radio-inline">
                {!! Form::radio('subclass[audio_mono_stereo]', '', true) !!} N/A
              </label>
            @else
              {!! Form::select('subclass[audio_mono_stereo]',
              array('M' => 'Mono', 'S' => 'Stereo', '' => 'N/A', '<mixed>' => '<mixed>'), $item->subclass->audio_mono_stereo, array('class' => 'form-control form-control-sm')) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.size')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[size]', 'Size', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[size]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 12"')) !!}
            @if ($errors->has('subclass.size'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.size') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.track_configuration')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[track_configuration]', 'Track Config', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[track_configuration]', null, array('id' => 'track-configuration', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 1/2 track')) !!}
            @if ($errors->has('subclass.track_configuration'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.track_configuration') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.audio_base')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[audio_base]', 'Base', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[audio_base]', null, array('id' => 'audio-base', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Polyester')) !!}
            @if ($errors->has('subclass.audio_base'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.audio_base') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.audio_content_description')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[audio_content_description]', 'Content Description', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('subclass[audio_content_description]', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
            @if ($errors->has('subclass.audio_content_description'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.audio_content_description') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End AudioItem fields --}}