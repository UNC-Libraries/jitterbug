      {{-- AudioVisualItem fields --}}
      <div class="row">
        <div class="form-group @if ($errors->has('call_number')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('call_number', 'Call Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch())
              @if (routeName() === 'items.create')
                {!! Form::text('call_number', null, array('id' => 'call-number', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly', 'placeholder' => 'Will be auto-generated')) !!}
              @else
                {!! Form::text('call_number', null, array('id' => 'call-number', 'class' => 'form-control form-control-sm')) !!}
              @endif
              @if ($errors->has('call_number'))
                <div class="form-control-label"><small>{!! $errors->first('call_number') !!}</small></div>
              @endif
            @else
              {!! Form::text('call_number', null, array('id' => 'call-number', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly')) !!}
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
        <div class="form-group @if ($errors->has('container_note')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('container_note', 'Container Note', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('container_note', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
            @if ($errors->has('container_note'))
              <div class="form-control-label"><small>{!! $errors->first('container_note') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('collection_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('collection_id', 'Collection', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('collection_id', $collections, $item->collection_id, array('id' => 'collection-id', 'class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('collection_id'))
              <div class="form-control-label"><small>{!! $errors->first('collection_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('accession_number')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('accession_number', 'Accession Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('accession_number', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('accession_number'))
              <div class="form-control-label"><small>{!! $errors->first('accession_number') !!}</small></div>
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
        <div class="form-group @if ($errors->has('format_id')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('format_id', 'Format', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('format_id', $formats, $item->format_id, array('id' => 'format-id', 'class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('format_id'))
              <div class="form-control-label"><small>{!! $errors->first('format_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('reel_tape_number')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('reel_tape_number', 'Reel/Tape Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('reel_tape_number', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 1/2')) !!}
            @if ($errors->has('reel_tape_number'))
              <div class="form-control-label"><small>{!! $errors->first('reel_tape_number') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('recording_location')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('recording_location', 'Recording Location', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('recording_location', null, array('id' => 'recording-location', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. New Orleans, LA')) !!}
            @if ($errors->has('recording_location'))
              <div class="form-control-label"><small>{!! $errors->first('recording_location') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('physical_location')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('physical_location', 'Physical Location', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('physical_location', null, array('id' => 'physical-location', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 26K.b31')) !!}
            @if ($errors->has('physical_location'))
              <div class="form-control-label"><small>{!! $errors->first('physical_location') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('access_restrictions')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('access_restrictions', 'Access Restrictions', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('access_restrictions', null, array('id' => 'access-restrictions', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Campus')) !!}
            @if ($errors->has('access_restrictions'))
              <div class="form-control-label"><small>{!! $errors->first('access_restrictions') !!}</small></div>
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
        <div class="form-group @if ($errors->has('item_year')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('item_year', 'Item Year', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('item_year', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Item year or range')) !!}
            @if ($errors->has('item_year'))
              <div class="form-control-label"><small>{!! $errors->first('item_year') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('item_date')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('item_date', 'Item Date', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            <div class="input-group date">
              {!! Form::text('item_date', null, array('class' => 'form-control form-control-sm')) !!}
              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            </div>
            @if ($errors->has('item_date'))
              <div class="form-control-label"><small>{!! $errors->first('item_date') !!}</small></div>
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
        <div class="form-group @if ($errors->has('entry_date')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('entry_date', 'Entry Date', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            <div class="input-group date">
              {!! Form::text('entry_date', null, array('class' => 'form-control form-control-sm')) !!}
              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            </div>
            @if ($errors->has('entry_date'))
              <div class="form-control-label"><small>{!! $errors->first('entry_date') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('blank', 'Blank?', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if ($item->blank !== '<mixed>' || !$item->batch())
              <label class="radio-inline">
                {!! Form::radio('blank', '1') !!} Yes
              </label>
              <label class="radio-inline">
                {!! Form::radio('blank', '0', true) !!} No
              </label>
            @else
              {!! Form::select('blank',
              array('1' => 'Yes', '0' => 'No', '<mixed>' => '<mixed>'), $item->blank, array('class' => 'form-control form-control-sm')) !!}
            @endif
          </div>
        </div>
      </div>
      {{-- End AudioVisualItem fields --}}
 