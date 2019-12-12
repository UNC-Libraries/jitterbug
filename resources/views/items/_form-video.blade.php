      {{-- VideoItem fields --}}
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[video_mono_stereo]', 'Mono/Stereo', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->subclass->video_mono_stereo !== '<mixed>')
              <label class="radio-inline">
                {!! Form::radio('subclass[video_mono_stereo]', 'M') !!} Mono
              </label>
              <label class="radio-inline">
                {!! Form::radio('subclass[video_mono_stereo]', 'S') !!} Stereo
              </label>
              <label class="radio-inline">
                {!! Form::radio('subclass[video_mono_stereo]', '', true) !!} N/A
              </label>
            @else
              {!! Form::select('subclass[video_mono_stereo]',
              array('M' => 'Mono', 'S' => 'Stereo', '' => 'N/A', '<mixed>' => '<mixed>'), $item->subclass->video_mono_stereo, array('class' => 'form-control form-control-sm')) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.video_element')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[video_element]', 'Element', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[video_element]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Dub')) !!}
            @if ($errors->has('subclass.video_element'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.video_element') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.video_color')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[video_color]', 'Color', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[video_color]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. B/W')) !!}
            @if ($errors->has('subclass.video_color'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.video_color') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.recording_standard')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[recording_standard]', 'Recording Standard', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[recording_standard]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. NTSC')) !!}
            @if ($errors->has('subclass.recording_standard'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.recording_standard') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.video_content_description')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[video_content_description]', 'Content Description', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('subclass[video_content_description]', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
            @if ($errors->has('subclass.video_content_description'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.video_content_description') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End VideoItem fields --}}