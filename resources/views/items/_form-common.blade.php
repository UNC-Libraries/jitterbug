      {{-- AudioVisualItem fields --}}
      <div class="row">
        <div class="mb-3 @if ($errors->has('call_number')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Call Number', 'call_number')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            @if (!$item->batch())
              @if (routeName() === 'items.create')
                {{ html()->text('call_number')->id('call-number')->class('form-control form-control-sm')->isReadonly()->placeholder('Will be auto-generated') }}
              @else
                {{ html()->text('call_number')->id('call-number')->class('form-control form-control-sm') }}
              @endif
              @if ($errors->has('call_number'))
                <div class="form-control-label"><small>{!! $errors->first('call_number') !!}</small></div>
              @endif
            @else
              {{ html()->text('call_number')->id('call-number')->class('form-control form-control-sm')->isReadonly() }}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('title')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Title', 'title')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('title')->class('form-control form-control-sm') }}
            @if ($errors->has('title'))
              <div class="form-control-label"><small>{!! $errors->first('title') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('container_note')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Container Note', 'container_note')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->textarea('container_note')->class('form-control form-control-sm')->rows(3) }}
            @if ($errors->has('container_note'))
              <div class="form-control-label"><small>{!! $errors->first('container_note') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('collection_id')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Collection', 'collection_id')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->select('collection_id', $collections, $item->collection_id)->id('collection-id')->class('form-control form-control-sm') }}
            @if ($errors->has('collection_id'))
              <div class="form-control-label"><small>{!! $errors->first('collection_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('accession_number')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Accession Number', 'accession_number')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('accession_number')->class('form-control form-control-sm') }}
            @if ($errors->has('accession_number'))
              <div class="form-control-label"><small>{!! $errors->first('accession_number') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('legacy')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Legacy Id', 'legacy')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('legacy')->class('form-control form-control-sm')->placeholder('e.g. V8M-135') }}
            @if ($errors->has('legacy'))
              <div class="form-control-label"><small>{!! $errors->first('legacy') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('format_id')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Format', 'format_id')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->select('format_id', $formats, $item->format_id)->id('format-id')->class('form-control form-control-sm') }}
            @if ($errors->has('format_id'))
              <div class="form-control-label"><small>{!! $errors->first('format_id') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('reel_tape_number')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Reel/Tape Number', 'reel_tape_number')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('reel_tape_number')->class('form-control form-control-sm')->placeholder('e.g. 1/2') }}
            @if ($errors->has('reel_tape_number'))
              <div class="form-control-label"><small>{!! $errors->first('reel_tape_number') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('recording_location')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Recording Location', 'recording_location')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('recording_location')->id('recording-location')->class('form-control form-control-sm')->placeholder('e.g. New Orleans, LA') }}
            @if ($errors->has('recording_location'))
              <div class="form-control-label"><small>{!! $errors->first('recording_location') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('physical_location')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Physical Location', 'physical_location')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('physical_location')->id('physical-location')->class('form-control form-control-sm')->placeholder('e.g. 26K.b31') }}
            @if ($errors->has('physical_location'))
              <div class="form-control-label"><small>{!! $errors->first('physical_location') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('access_restrictions')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Access Restrictions', 'access_restrictions')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('access_restrictions')->id('access-restrictions')->class('form-control form-control-sm')->placeholder('e.g. Campus') }}
            @if ($errors->has('access_restrictions'))
              <div class="form-control-label"><small>{!! $errors->first('access_restrictions') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('oclc')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('OCLC Id', 'oclc')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('oclc')->class('form-control form-control-sm') }}
            @if ($errors->has('oclc'))
              <div class="form-control-label"><small>{!! $errors->first('oclc') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('item_year')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Item Year', 'item_year')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('item_year')->class('form-control form-control-sm')->placeholder('e.g. Item year or range') }}
            @if ($errors->has('item_year'))
              <div class="form-control-label"><small>{!! $errors->first('item_year') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('item_date')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Item Date', 'item_date')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            <div class="input-group date">
              {{ html()->text('item_date')->class('form-control form-control-sm') }}
              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            </div>
            @if ($errors->has('item_date'))
              <div class="form-control-label"><small>{!! $errors->first('item_date') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('speed')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Speed', 'speed')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            {{ html()->text('speed')->id('speed')->class('form-control form-control-sm')->placeholder('e.g. 7.5 ips, 24 fps') }}
            @if ($errors->has('speed'))
              <div class="form-control-label"><small>{!! $errors->first('speed') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 @if ($errors->has('entry_date')) has-danger @endif">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Entry Date', 'entry_date')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            <div class="input-group date">
              {{ html()->text('entry_date')->class('form-control form-control-sm') }}
              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            </div>
            @if ($errors->has('entry_date'))
              <div class="form-control-label"><small>{!! $errors->first('entry_date') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3">
          <div class="col-sm-4 col-sm-offset-1 detail-label">
            {{ html()->label('Blank?', 'blank')->class('form-control-label') }}
          </div>
          <div class="col-sm-7 detail-value">
            @if ($item->blank !== '<mixed>' || !$item->batch())
              <label class="radio-inline">
                {{ html()->radio('blank', false, '1') }} Yes
              </label>
              <label class="radio-inline">
                {{ html()->radio('blank', true, '0') }} No
              </label>
            @else
              {{ html()->select('blank', array('1' => 'Yes', '0' => 'No', '<mixed>' => '<mixed>'), $item->blank)->class('form-control form-control-sm') }}
            @endif
          </div>
        </div>
      </div>
      {{-- End AudioVisualItem fields --}}
 