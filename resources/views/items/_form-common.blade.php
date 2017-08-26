      {{-- AudioVisualItem fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('callNumber')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('callNumber', 'Call Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch())
              @if (routeName() === 'items.create')
                {!! Form::text('callNumber', null, array('id' => 'call-number', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly', 'placeholder' => 'Will be auto-generated')) !!}
              @else
                {!! Form::text('callNumber', null, array('id' => 'call-number', 'class' => 'form-control form-control-sm')) !!}
              @endif
              @if ($errors->has('callNumber'))
                <div class="form-control-label"><small>{!! $errors->first('callNumber') !!}</small></div>
              @endif
            @else
              {!! Form::text('callNumber', null, array('id' => 'call-number', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly')) !!}
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
        <div class="form-group @if ($errors->has('containerNote')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('containerNote', 'Container Note', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('containerNote', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
            @if ($errors->has('containerNote'))
              <div class="form-control-label"><small>{!! $errors->first('containerNote') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('collectionId')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('collectionId', 'Collection', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('collectionId', $collections, $item->collectionId, array('id' => 'collection-id', 'class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('collectionId'))
              <div class="form-control-label"><small>{!! $errors->first('collectionId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('accessionNumber')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('accessionNumber', 'Accession Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('accessionNumber', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('accessionNumber'))
              <div class="form-control-label"><small>{!! $errors->first('accessionNumber') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('legacy')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('legacy', 'Legacy Id', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('legacy', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. V8M-135')) !!}
            @if ($errors->has('legacy'))
              <div class="form-control-label"><small>{!! $errors->first('legacy') !!}</small></div>
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
            {!! Form::select('formatId', $formats, $item->formatId, array('id' => 'format-id', 'class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('formatId'))
              <div class="form-control-label"><small>{!! $errors->first('formatId') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('recordingLocation')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('recordingLocation', 'Rec Location', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('recordingLocation', null, array('id' => 'recording-location', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. New Orleans, LA')) !!}
            @if ($errors->has('recordingLocation'))
              <div class="form-control-label"><small>{!! $errors->first('recordingLocation') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('accessRestrictions')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('accessRestrictions', 'Access Restrictions', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('accessRestrictions', null, array('id' => 'access-restrictions', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Campus')) !!}
            @if ($errors->has('accessRestrictions'))
              <div class="form-control-label"><small>{!! $errors->first('accessRestrictions') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('oclc')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('oclc', 'OCLC Id', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('oclc', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('oclc'))
              <div class="form-control-label"><small>{!! $errors->first('oclc') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('itemYear')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('itemYear', 'Item Year', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemYear', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Item year or range')) !!}
            @if ($errors->has('itemYear'))
              <div class="form-control-label"><small>{!! $errors->first('itemYear') !!}</small></div>
            @endif
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
        <div class="form-group @if ($errors->has('speed')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('speed', 'Speed', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('speed', null, array('id' => 'speed', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 7.5 ips, 24 fps')) !!}
            @if ($errors->has('speed'))
              <div class="form-control-label"><small>{!! $errors->first('speed') !!}</small></div>
            @endif
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
      {{-- End AudioVisualItem fields --}}
 