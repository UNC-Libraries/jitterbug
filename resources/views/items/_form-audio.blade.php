      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[listeningCopy]', 'Listening Copy', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->subclass->listeningCopy !== '<mixed>')
              <label class="radio-inline">
                {!! Form::radio('subclass[listeningCopy]', '1') !!} Yes
              </label>
              <label class="radio-inline">
                {!! Form::radio('subclass[listeningCopy]', '0', true) !!} No
              </label>
            @else
              {!! Form::select('subclass[listeningCopy]',
              array('1' => 'Yes', '0' => 'No', '<mixed>' => '<mixed>'), $item->subclass->listeningCopy, array('class' => 'form-control form-control-sm')) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[audioMonoStereo]', 'Mono/Stereo', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->subclass->audioMonoStereo !== '<mixed>')
              <label class="radio-inline">
                {!! Form::radio('subclass[audioMonoStereo]', 'M') !!} Mono
              </label>
              <label class="radio-inline">
                {!! Form::radio('subclass[audioMonoStereo]', 'S') !!} Stereo
              </label>
              <label class="radio-inline">
                {!! Form::radio('subclass[audioMonoStereo]', '', true) !!} N/A
              </label>
            @else
              {!! Form::select('subclass[audioMonoStereo]',
              array('M' => 'Mono', 'S' => 'Stereo', '' => 'N/A', '<mixed>' => '<mixed>'), $item->subclass->audioMonoStereo, array('class' => 'form-control form-control-sm')) !!}
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
        <div class="form-group @if ($errors->has('subclass.trackConfiguration')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[trackConfiguration]', 'Track Config', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[trackConfiguration]', null, array('id' => 'track-configuration', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 1/2 track')) !!}
            @if ($errors->has('subclass.trackConfiguration'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.trackConfiguration') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.audioBase')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[audioBase]', 'Base', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[audioBase]', null, array('id' => 'audio-base', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Polyester')) !!}
            @if ($errors->has('subclass.audioBase'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.audioBase') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.audioContentDescription')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[audioContentDescription]', 'Content Description', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('subclass[audioContentDescription]', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
            @if ($errors->has('subclass.audioContentDescription'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.audioContentDescription') !!}</small></div>
            @endif
          </div>
        </div>
      </div>