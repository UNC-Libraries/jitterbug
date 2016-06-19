      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[listeningCopy]', 'Listening Copy', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            <label class="radio-inline">
              {!! Form::radio('itemable[listeningCopy]', '1') !!} Yes
            </label>
            <label class="radio-inline">
              {!! Form::radio('itemable[listeningCopy]', '0', true) !!} No
            </label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[audioMonoStereo]', 'Mono/Stereo', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            <label class="radio-inline">
              {!! Form::radio('itemable[audioMonoStereo]', 'M') !!} Mono
            </label>
            <label class="radio-inline">
              {!! Form::radio('itemable[audioMonoStereo]', 'S') !!} Stereo
            </label>
            <label class="radio-inline">
              {!! Form::radio('itemable[audioMonoStereo]', '', true) !!} N/A
            </label>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group @if ($errors->has('itemable.size')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[size]', 'Size', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[size]', null, array('class' => 'form-control form-control-sm')) !!}
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
            {!! Form::text('itemable[trackConfiguration]', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[audioBase]', 'Base', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[audioBase]', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>