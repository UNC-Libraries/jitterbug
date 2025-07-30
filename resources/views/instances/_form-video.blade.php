      {{-- VideoInstance fields --}}
      <div class="row">
        {{-- video_file_format and video_file_codec now reside in preservation_instances in the file_format and file_codec fields --}}
        <div class="mb-3 @if ($errors->has('video_file_format')) has-danger @endif">
          <div class="col-sm-4 detail-label">
            {{ html()->label('File Format', 'video_file_format')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('video_file_format', routeName() === 'instances.create' ? 'MKV' : null)->class('form-control form-control-sm')->placeholder('e.g. MKV') }}
            @if ($errors->has('video_file_format'))
              <div class="form-control-label"><small>{!! $errors->first('video_file_format') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('video_file_codec')) has-danger @endif">
          <div class="col-sm-4 detail-label">
            {{ html()->label('File Codec', 'video_file_codec')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('video_file_codec', routeName() === 'instances.create' ? 'FFV1' : null)->class('form-control form-control-sm')->placeholder('e.g. FFV1') }}
            @if ($errors->has('video_file_codec'))
              <div class="form-control-label"><small>{!! $errors->first('video_file_codec') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('subclass.video_frame_size')) has-danger @endif">
          <div class="col-sm-4 detail-label">
            {{ html()->label('Frame Size', 'subclass[video_frame_size]')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('subclass[video_frame_size]', routeName() === 'instances.create' ? '720 x 486' : null)->class('form-control form-control-sm')->placeholder('e.g. 720 x 486') }}
            @if ($errors->has('subclass.video_frame_size'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.video_frame_size') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('subclass.video_aspect_ratio')) has-danger @endif">
          <div class="col-sm-4 detail-label">
            {{ html()->label('Aspect Ratio', 'subclass[video_aspect_ratio]')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('subclass[video_aspect_ratio]', routeName() === 'instances.create' ? '4:3' : null)->class('form-control form-control-sm')->placeholder('e.g. 4:3') }}
            @if ($errors->has('subclass.video_aspect_ratio'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.video_aspect_ratio') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End VideoInstance fields --}}
