      {{-- FilmInstance fields --}}
      <div class="row">
        {{-- film_file_format and film_file_codec now reside in preservation_instances in the file_format and file_codec fields --}}
        <div class="form-group @if ($errors->has('film_file_format')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('File Format', 'film_file_format')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('film_file_format', routeName() === 'instances.create' ? 'DPX' : null)->class('form-control form-control-sm')->placeholder('e.g. DPX') }}
            @if ($errors->has('film_file_format'))
              <div class="form-control-label"><small>{!! $errors->first('film_file_format') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('film_file_codec')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('File Codec', 'film_file_codec')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('film_file_codec', routeName() === 'instances.create' ? 'Uncompressed 10-bit' : null)->class('form-control form-control-sm')->placeholder('e.g. Uncompressed 10-bit') }}
            @if ($errors->has('film_file_codec'))
              <div class="form-control-label"><small>{!! $errors->first('film_file_codec') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_frame_size')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Frame Size', 'subclass[film_frame_size]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[film_frame_size]', routeName() === 'instances.create' ? '720 x 486' : null)->class('form-control form-control-sm')->placeholder('e.g. 720 x 486') }}
            @if ($errors->has('subclass.film_frame_size'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_frame_size') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_aspect_ratio')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Aspect Ratio', 'subclass[film_aspect_ratio]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[film_aspect_ratio]', routeName() === 'instances.create' ? '4:3' : null)->class('form-control form-control-sm')->placeholder('e.g. 4:3') }}
            @if ($errors->has('subclass.film_aspect_ratio'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_aspect_ratio') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End FilmInstance fields --}}
