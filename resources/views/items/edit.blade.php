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

  {{-- AudioVisualItem Fields --}}
  <div class="row first detail-container">
    <div class="col-xs-6">
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('callNumber', 'Call Number') !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('callNumber', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('title', 'Title') !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('title', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('containerNote', 'Container Note') !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('containerNote', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('collectionId', 'Collection') !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('collectionId', $collections, $item->collectionId, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('formatId', 'Format') !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::select('formatId', $formats, $item->formatId, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('recordingLocation', 'Rec Location') !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('recordingLocation', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('oclcId', 'OCLC Id') !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('oclcId', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('itemYear', 'Item Year') !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemYear', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('itemDate', 'Item Date') !!}
          </div>
          <div class="col-xs-7 detail-value">
            <div class="input-group date">
              {!! Form::text('itemDate', null, array('class' => 'form-control form-control-sm')) !!}
              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('speed', 'Speed') !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('speed', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-1 detail-label">
            {!! Form::label('entryDate', 'Entry Date') !!}
          </div>
          <div class="col-xs-7 detail-value">
            <div class="input-group date">
              {!! Form::text('entryDate', null, array('class' => 'form-control form-control-sm')) !!}
              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            </div>
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
            {!! Form::label('itemable[listeningCopy]', 'Listening Copy') !!}
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
            {!! Form::label('itemable[monoStereo]', 'Mono/Stereo') !!}
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
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('size', 'Size') !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('size', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('trackConfiguration', 'Track Config') !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('trackConfiguration', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('base', 'Base') !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('base', null, array('class' => 'form-control form-control-sm')) !!}
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
      <button class="btn btn-sm btn-warning" type="submit" style="outline: none;"><i class="fa fa-ban" aria-hidden="true"></i> Cancel</button>
      <button class="btn btn-sm btn-danger" type="submit" style="outline: none;"><i class="fa fa-remove" aria-hidden="true"></i> Delete</button>
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