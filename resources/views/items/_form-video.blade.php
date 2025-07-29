      {{-- VideoItem fields --}}
      <div class="row">
        <div class="mb-3">
          <div class="col-sm-4 detail-label">
            {{ html()->label('Mono/Stereo', 'subclass[video_mono_stereo]')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            @if (!$item->batch() || $item->subclass->video_mono_stereo !== '<mixed>')
              <label class="radio-inline">
                {{ html()->radio('subclass[video_mono_stereo]', false, 'M') }} Mono
              </label>
              <label class="radio-inline">
                {{ html()->radio('subclass[video_mono_stereo]', false, 'S') }} Stereo
              </label>
              <label class="radio-inline">
                {{ html()->radio('subclass[video_mono_stereo]', true, '') }} N/A
              </label>
            @else
              {{ html()->select('subclass[video_mono_stereo]', array('M' => 'Mono', 'S' => 'Stereo', '' => 'N/A', '<mixed>' => '<mixed>'), $item->subclass->video_mono_stereo)->class('form-control form-control-sm') }}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('subclass.video_element')) has-danger @endif">
          <div class="col-sm-4 detail-label">
            {{ html()->label('Element', 'subclass[video_element]')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('subclass[video_element]')->class('form-control form-control-sm')->placeholder('e.g. Dub') }}
            @if ($errors->has('subclass.video_element'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.video_element') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('subclass.video_color')) has-danger @endif">
          <div class="col-sm-4 detail-label">
            {{ html()->label('Color', 'subclass[video_color]')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('subclass[video_color]')->class('form-control form-control-sm')->placeholder('e.g. B/W') }}
            @if ($errors->has('subclass.video_color'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.video_color') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('subclass.recording_standard')) has-danger @endif">
          <div class="col-sm-4 detail-label">
            {{ html()->label('Recording Standard', 'subclass[recording_standard]')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('subclass[recording_standard]')->class('form-control form-control-sm')->placeholder('e.g. NTSC') }}
            @if ($errors->has('subclass.recording_standard'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.recording_standard') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('subclass.video_content_description')) has-danger @endif">
          <div class="col-sm-4 detail-label">
            {{ html()->label('Content Description', 'subclass[video_content_description]')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->textarea('subclass[video_content_description]')->class('form-control form-control-sm')->rows(3) }}
            @if ($errors->has('subclass.video_content_description'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.video_content_description') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End VideoItem fields --}}