      <div class="row">
        <div class="form-group @if ($errors->has('videoFileFormat')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('videoFileFormat', 'File Format', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('videoFileFormat', routeName() === 'masters.create' ? 'MKV' : null, array('class' => 'form-control form-control-sm')) !!}
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
            {!! Form::text('videoFileCodec', routeName() === 'masters.create' ? 'FFV1' : null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('videoFileCodec'))
              <div class="form-control-label"><small>{!! $errors->first('videoFileCodec') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.videoFrameSize')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[videoFrameSize]', 'Frame Size', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[videoFrameSize]', routeName() === 'masters.create' ? '720 x 480' : null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.videoFrameSize'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.videoFrameSize') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.videoAspectRatio')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[videoAspectRatio]', 'Aspect Ratio', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[videoAspectRatio]', routeName() === 'masters.create' ? '4:3' : null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.videoAspectRatio'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.videoAspectRatio') !!}</small></div>
            @endif
          </div>
        </div>
      </div>