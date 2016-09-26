      <div class="row">
        <div class="form-group @if ($errors->has('videoFileFormat')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('videoFileFormat', 'File Format', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('videoFileFormat', 'MKV', array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('videoFileFormat'))
              <div class="form-control-label"><small>{!! $errors->first('videoFileFormat') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('videoFileCodec')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('videoFileCodec', 'File Codec', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('videoFileCodec', 'FFV1', array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('videoFileCodec'))
              <div class="form-control-label"><small>{!! $errors->first('videoFileCodec') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('masterable.videoFrameSize')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('masterable[videoFrameSize]', 'Frame Size', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('masterable[videoFrameSize]', '720 x 480', array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('masterable.videoFrameSize'))
              <div class="form-control-label"><small>{!! $errors->first('masterable.videoFrameSize') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('masterable.videoAspectRatio')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('masterable[videoAspectRatio]', 'Aspect Ratio', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('masterable[videoAspectRatio]', '4:3', array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('masterable.videoAspectRatio'))
              <div class="form-control-label"><small>{!! $errors->first('masterable.videoAspectRatio') !!}</small></div>
            @endif
          </div>
        </div>
      </div>