      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[videoMonoStereo]', 'Mono/Stereo', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->subclass->videoMonoStereo !== '<mixed>')
              <label class="radio-inline">
                {!! Form::radio('subclass[videoMonoStereo]', 'M') !!} Mono
              </label>
              <label class="radio-inline">
                {!! Form::radio('subclass[videoMonoStereo]', 'S') !!} Stereo
              </label>
              <label class="radio-inline">
                {!! Form::radio('subclass[videoMonoStereo]', '', true) !!} N/A
              </label>
            @else
              {!! Form::select('subclass[videoMonoStereo]',
              array('M' => 'Mono', 'S' => 'Stereo', '' => 'N/A', '<mixed>' => '<mixed>'), $item->subclass->videoMonoStereo, array('class' => 'form-control form-control-sm')) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.videoElement')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[videoElement]', 'Element', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[videoElement]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Dub')) !!}
            @if ($errors->has('subclass.videoElement'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.videoElement') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.videoColor')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[videoColor]', 'Color', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[videoColor]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. B/W')) !!}
            @if ($errors->has('subclass.videoColor'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.videoColor') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.recordingStandard')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[recordingStandard]', 'Recording Standard', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[recordingStandard]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. NTSC')) !!}
            @if ($errors->has('subclass.recordingStandard'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.recordingStandard') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.videoContentDescription')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[videoContentDescription]', 'Content Description', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('subclass[videoContentDescription]', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
            @if ($errors->has('subclass.videoContentDescription'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.videoContentDescription') !!}</small></div>
            @endif
          </div>
        </div>
      </div>