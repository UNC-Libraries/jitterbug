      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[videoMonoStereo]', 'Mono/Stereo', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->itemable->videoMonoStereo !== '<mixed>')
              <label class="radio-inline">
                {!! Form::radio('itemable[videoMonoStereo]', 'M') !!} Mono
              </label>
              <label class="radio-inline">
                {!! Form::radio('itemable[videoMonoStereo]', 'S') !!} Stereo
              </label>
              <label class="radio-inline">
                {!! Form::radio('itemable[videoMonoStereo]', '', true) !!} N/A
              </label>
            @else
              {!! Form::select('itemable[videoMonoStereo]',
              array('M' => 'Mono', 'S' => 'Stereo', '' => 'N/A', '<mixed>' => '<mixed>'), $item->itemable->videoMonoStereo, array('class' => 'form-control form-control-sm')) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('itemable.videoElement')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[videoElement]', 'Element', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[videoElement]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Dub')) !!}
            @if ($errors->has('itemable.videoElement'))
              <div class="form-control-label"><small>{!! $errors->first('itemable.videoElement') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('itemable.videoColor')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[videoColor]', 'Color', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[videoColor]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. B/W')) !!}
            @if ($errors->has('itemable.videoColor'))
              <div class="form-control-label"><small>{!! $errors->first('itemable.videoColor') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('itemable.recordingStandard')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[recordingStandard]', 'Recording Standard', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[recordingStandard]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. NTSC')) !!}
            @if ($errors->has('itemable.recordingStandard'))
              <div class="form-control-label"><small>{!! $errors->first('itemable.recordingStandard') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('itemable.videoContentDescription')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[videoContentDescription]', 'Content Description', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('itemable[videoContentDescription]', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
            @if ($errors->has('itemable.videoContentDescription'))
              <div class="form-control-label"><small>{!! $errors->first('itemable.videoContentDescription') !!}</small></div>
            @endif
          </div>
        </div>
      </div>