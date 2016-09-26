      <div class="row">
        <div class="form-group @if ($errors->has('filmFileFormat')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('filmFileFormat', 'File Format', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('filmFileFormat', 'DPX', array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('filmFileFormat'))
              <div class="form-control-label"><small>{!! $errors->first('filmFileFormat') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('filmFileCodec')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('filmFileCodec', 'File Codec', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('filmFileCodec', 'Uncompressed 10-bit', array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('filmFileCodec'))
              <div class="form-control-label"><small>{!! $errors->first('filmFileCodec') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('masterable.filmFrameSize')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('masterable[filmFrameSize]', 'Frame Size', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('masterable[filmFrameSize]', '720 x 480', array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('masterable.filmFrameSize'))
              <div class="form-control-label"><small>{!! $errors->first('masterable.filmFrameSize') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('masterable.filmAspectRatio')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('masterable[filmAspectRatio]', 'Aspect Ratio', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('masterable[filmAspectRatio]', '4:3', array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('masterable.filmAspectRatio'))
              <div class="form-control-label"><small>{!! $errors->first('masterable.filmAspectRatio') !!}</small></div>
            @endif
          </div>
        </div>
      </div>