      {{-- AudioVisualItem Fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('callNumber')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('callNumber', 'Call Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch())
              {!! Form::text('callNumber', null, array('class' => 'form-control form-control-sm')) !!}
              @if ($errors->has('callNumber'))
                <div class="form-control-label"><small>{!! $errors->first('callNumber') !!}</small></div>
              @endif
            @else
              {!! Form::text('callNumber', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('title')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('title', 'Title', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('title', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('title'))
              <div class="form-control-label"><small>{!! $errors->first('title') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('containerNote', 'Container Note', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('containerNote', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('collectionId')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('collectionId', 'Collection', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('collectionId', $collections, $item->collectionId, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('collectionId'))
              <div class="form-control-label"><small>{!! $errors->first('collectionId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('formatId')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('formatId', 'Format', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('formatId', $formats, $item->formatId, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('formatId'))
              <div class="form-control-label"><small>{!! $errors->first('formatId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('recordingLocation', 'Rec Location', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('recordingLocation', null, array('id' => 'recording-location', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. New Orleans, LA')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('oclc', 'OCLC Id', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('oclc', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('itemYear', 'Item Year', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemYear', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Item year or range')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('itemDate')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('itemDate', 'Item Date', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            <div class="input-group date">
              {!! Form::text('itemDate', null, array('class' => 'form-control form-control-sm')) !!}
              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            </div>
            @if ($errors->has('itemDate'))
              <div class="form-control-label"><small>{!! $errors->first('itemDate') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('speed', 'Speed', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('speed', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 7.5 ips, 24 fps')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('entryDate')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('entryDate', 'Entry Date', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            <div class="input-group date">
              {!! Form::text('entryDate', null, array('class' => 'form-control form-control-sm')) !!}
              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            </div>
            @if ($errors->has('entryDate'))
              <div class="form-control-label"><small>{!! $errors->first('entryDate') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End AudioVisualItem Fields --}}
 