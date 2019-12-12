      {{-- FilmMaster fields --}}
      <div class="row">
        {{-- film_file_format and film_file_codec now reside in preservation_masters in the file_format and file_codec fields --}}
        <div class="form-group @if ($errors->has('film_file_format')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('film_file_format', 'File Format', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('film_file_format', routeName() === 'masters.create' ? 'DPX' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. DPX')) !!}
            @if ($errors->has('film_file_format'))
              <div class="form-control-label"><small>{!! $errors->first('film_file_format') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('film_file_codec')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('film_file_codec', 'File Codec', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('film_file_codec', routeName() === 'masters.create' ? 'Uncompressed 10-bit' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Uncompressed 10-bit')) !!}
            @if ($errors->has('film_file_codec'))
              <div class="form-control-label"><small>{!! $errors->first('film_file_codec') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_frame_size')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[film_frame_size]', 'Frame Size', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[film_frame_size]', routeName() === 'masters.create' ? '720 x 486' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 720 x 486')) !!}
            @if ($errors->has('subclass.film_frame_size'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_frame_size') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_aspect_ratio')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[film_aspect_ratio]', 'Aspect Ratio', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[film_aspect_ratio]', routeName() === 'masters.create' ? '4:3' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 4:3')) !!}
            @if ($errors->has('subclass.film_aspect_ratio'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_aspect_ratio') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End FilmMaster fields --}}