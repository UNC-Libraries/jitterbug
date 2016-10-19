      {{-- FilmMaster fields --}}
      <div class="row">
        {{-- filmFileFormat and fileFileCodec now reside in preservation_masters in the file_format and file_codec fields --}}
        <div class="form-group @if ($errors->has('filmFileFormat')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('filmFileFormat', 'File Format', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('filmFileFormat', routeName() === 'masters.create' ? 'DPX' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. DPX')) !!}
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
            {!! Form::text('filmFileCodec', routeName() === 'masters.create' ? 'Uncompressed 10-bit' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Uncompressed 10-bit')) !!}
            @if ($errors->has('filmFileCodec'))
              <div class="form-control-label"><small>{!! $errors->first('filmFileCodec') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.filmFrameSize')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[filmFrameSize]', 'Frame Size', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[filmFrameSize]', routeName() === 'masters.create' ? '720 x 480' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 720 x 480')) !!}
            @if ($errors->has('subclass.filmFrameSize'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.filmFrameSize') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.filmAspectRatio')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[filmAspectRatio]', 'Aspect Ratio', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[filmAspectRatio]', routeName() === 'masters.create' ? '4:3' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 4:3')) !!}
            @if ($errors->has('subclass.filmAspectRatio'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.filmAspectRatio') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End FilmMaster fields --}}