@extends('layouts.master', ['title' => "Edit $item->type Item"])

@section('content')
<div class="detail">
  <div class="row">
    <div class="col-xs-12 back">
      <a href="{{ route('items.index') }}"><i class="fa fa-caret-left" aria-hidden="true"></i> Back to Items</a>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>{{$item->type}} Item Details</h6>
    </div>
  </div>

  {!! Form::model($item, array('route' => array('items.update', $item->id), 'method' => 'put')) !!}
  {!! Form::hidden('id') !!}
  {!! Form::hidden('itemableType') !!}
  {!! Form::hidden('itemableId') !!}

  {{-- AudioVisualItem Fields --}}
  <div class="row first detail-container">
    <div class="col-xs-6">
      <div class="row">
        <div class="form-group @if ($errors->has('callNumber')) has-danger @endif">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('callNumber', 'Call Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('callNumber', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('callNumber'))
              <div class="form-control-label"><small>{!! $errors->first('callNumber') !!}</small></div>
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
            {!! Form::text('recordingLocation', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('oclcId', 'OCLC Id', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('oclcId', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('itemYear', 'Item Year', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemYear', null, array('class' => 'form-control form-control-sm')) !!}
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
            {!! Form::text('speed', null, array('class' => 'form-control form-control-sm')) !!}
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
    </div>
    <div class="col-xs-6">
      {{-- Begin Itemable Fields --}}
      @if (get_class($item->itemable()) == 'Junebug\Models\AudioItem')
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[listeningCopy]', 'Listening Copy', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            <label class="radio-inline">
              {!! Form::radio('itemable[listeningCopy]', 'Y') !!} Yes
            </label>
            <label class="radio-inline">
              {!! Form::radio('itemable[listeningCopy]', 'N') !!} No
            </label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[monoStereo]', 'Mono/Stereo', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            <label class="radio-inline">
              {!! Form::radio('itemable[monoStereo]', 'M') !!} Mono
            </label>
            <label class="radio-inline">
              {!! Form::radio('itemable[monoStereo]', 'S') !!} Stereo
            </label>
            <label class="radio-inline">
              {!! Form::radio('itemable[monoStereo]', '') !!} N/A
            </label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('itemable.size')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[size]', 'Size', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[size]', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('itemable.size'))
              <div class="form-control-label"><small>{!! $errors->first('itemable.size') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[trackConfiguration]', 'Track Config', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[trackConfiguration]', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[base]', 'Base', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[base]', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      @endif
      {{-- End Itemable Fields --}}
      <div class="row">
        <div class="col-xs-4 detail-label">
          Created On
        </div>
        <div class="col-xs-7 detail-value">
          4/26/2016 by System
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 detail-label">
          Updated On
        </div>
        <div class="col-xs-7 detail-value">
          5/15/2016 by John Loy
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <hr/>
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <button class="btn btn-sm btn-primary" type="submit" style="outline: none;"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
      <a class="" href="{{ route('items.show', $item->id) }}">or Cancel</a>
    </div>
  </div>

  {!! Form::close() !!}

  @if (count($item->preservationMasters()) > 0 )
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>Related Preservation Masters</h6>
    </div>
  </div>
  <div class="row first last">
    <div class="col-xs-12 col-fff">
      <table class="table table-sm table-hover">
        <thead>
          <tr>
            <th width="12%">#</th>
            <th width="20%">File Name</th>
            <th width="30%">File Location</th>
            <th width="15%">Department</th>
            <th width="16%">Duration</th>
            <th width="7%">Type</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($item->preservationMasters() as $master)
          <tr role="button" data-id="{{$master->id}}">
            <td>{{$master->id}}</td>
            <td>{{$master->fileName}}</td>
            <td>{{$master->fileLocation}}</td>
            <td>{{$master->department->name or ''}}</td>
            <td>{{$master->duration}}</td>
            <td>{{$master->type}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  @if (count($cuts) > 0 )
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>Related Cuts</h6>
    </div>
  </div>
  <div class="row first last">
    <div class="col-xs-12 col-fff">
      <table class="table table-sm table-hover">
        <thead>
          <tr>
            <th width="10%">PM #</th>
            <th width="15%">Cut Number</th>
            <th width="10%">Side</th>
            <th width="20%">Title</th>
            <th width="25%">Performer/Composer</th>
            <th width="20%">PM Start Time</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($cuts as $cut)
          <tr role="button" data-id="{{$cut->id}}">
            <td>{{$cut->preservationMasterId}}</td>
            <td>{{$cut->cutNumber}}</td>
            <td>{{$cut->side}}</td>
            <td>{{$cut->title}}</td>
            <td>{{$cut->performerComposer}}</td>
            <td>{{$cut->pmStartTime}}</td>
          </tr>
          @endforeach                       
        </tbody>
      </table>
    </div>
  </div>
  @endif

</div>
@stop