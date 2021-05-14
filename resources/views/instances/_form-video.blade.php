      {{-- VideoInstance fields --}}
      <div class="row">
        {{-- video_file_format and video_file_codec now reside in preservation_instances in the file_format and file_codec fields --}}
        <div class="form-group @if ($errors->has('video_file_format')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('video_file_format', 'File Format', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('video_file_format', routeName() === 'instances.create' ? 'MKV' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. MKV')) !!}
            @if ($errors->has('video_file_format'))
              <div class="form-control-label"><small>{!! $errors->first('video_file_format') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('video_file_codec')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('video_file_codec', 'File Codec', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('video_file_codec', routeName() === 'instances.create' ? 'FFV1' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. FFV1')) !!}
            @if ($errors->has('video_file_codec'))
              <div class="form-control-label"><small>{!! $errors->first('video_file_codec') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.video_frame_size')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[video_frame_size]', 'Frame Size', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[video_frame_size]', routeName() === 'instances.create' ? '720 x 486' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 720 x 486')) !!}
            @if ($errors->has('subclass.video_frame_size'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.video_frame_size') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.video_aspect_ratio')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[video_aspect_ratio]', 'Aspect Ratio', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[video_aspect_ratio]', routeName() === 'instances.create' ? '4:3' : null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 4:3')) !!}
            @if ($errors->has('subclass.video_aspect_ratio'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.video_aspect_ratio') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End VideoInstance fields --}}
