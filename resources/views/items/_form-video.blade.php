      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[monoStereo]', 'Mono/Stereo', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            <label class="radio-inline">
              {!! Form::radio('itemable[monoStereo]', 'M') !!} Mono
            </label>
            <label class="radio-inline">
              {!! Form::radio('itemable[monoStereo]', 'S') !!} Stereo
            </label>
            <label class="radio-inline">
              {!! Form::radio('itemable[monoStereo]', '', true) !!} N/A
            </label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[element]', 'Element', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[element]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Dub')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[color]', 'Color', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[color]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. B/W')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[recordingStandard]', 'Recording Standard', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[recordingStandard]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. NTSC')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[contentDescription]', 'Content Description', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('itemable[contentDescription]', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
          </div>
        </div>
      </div>