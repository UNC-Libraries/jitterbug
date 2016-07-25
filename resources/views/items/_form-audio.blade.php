      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[listeningCopy]', 'Listening Copy', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->itemable->listeningCopy !== '<mixed>')
              <label class="radio-inline">
                {!! Form::radio('itemable[listeningCopy]', '1') !!} Yes
              </label>
              <label class="radio-inline">
                {!! Form::radio('itemable[listeningCopy]', '0', true) !!} No
              </label>
            @else
              {!! Form::select('itemable[listeningCopy]',
              array('1' => 'Yes', '0' => 'No', '<mixed>' => '<mixed>'), $item->itemable->listeningCopy, array('class' => 'form-control form-control-sm')) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[audioMonoStereo]', 'Mono/Stereo', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->itemable->audioMonoStereo !== '<mixed>')
              <label class="radio-inline">
                {!! Form::radio('itemable[audioMonoStereo]', 'M') !!} Mono
              </label>
              <label class="radio-inline">
                {!! Form::radio('itemable[audioMonoStereo]', 'S') !!} Stereo
              </label>
              <label class="radio-inline">
                {!! Form::radio('itemable[audioMonoStereo]', '', true) !!} N/A
              </label>
            @else
              {!! Form::select('itemable[audioMonoStereo]',
              array('M' => 'Mono', 'S' => 'Stereo', '' => 'N/A', '<mixed>' => '<mixed>'), $item->itemable->audioMonoStereo, array('class' => 'form-control form-control-sm')) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('itemable.size')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[size]', 'Size', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[size]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 12"')) !!}
            @if ($errors->has('itemable.size'))
              <div class="form-control-label"><small>{!! $errors->first('itemable.size') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[trackConfiguration]', 'Track Config', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[trackConfiguration]', null, array('id' => 'track-configuration', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 1/2 track')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[audioBase]', 'Base', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[audioBase]', null, array('id' => 'audio-base', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Polyester')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[audioContentDescription]', 'Content Description', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('itemable[audioContentDescription]', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
          </div>
        </div>
      </div>