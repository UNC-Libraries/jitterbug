@extends('layouts.master', ['title' => 'Audio Visual Items', 'section' => 'items'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('items.edit', $item) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-e0">
      @if ($item->batch())
        <h6>{{$item->type}} Item Details (editing {{$item->count()}} items)</h6>
      @else
        <h6>{{$item->type}} Item Details</h6>
      @endif
    </div>
  </div>

  @if ($item->batch())
    {!! Form::model($item, array('route' => array('items.batch.update'), 'method' => 'put')) !!}
    {!! Form::hidden('ids') !!}
    {!! Form::hidden('subclassType') !!}
  @else
    {!! Form::model($item, array('route' => array('items.update', $item->id), 'method' => 'put')) !!}
    {!! Form::hidden('id') !!}
    {!! Form::hidden('subclassType') !!}
    {!! Form::hidden('subclassId') !!}
  @endif

  <div class="row first detail-container">
    <div class="col-xs-6">
      @include('items._form-common')
    </div>
    <div class="col-xs-6">
      {{-- Begin subclass fields --}}
      @if (get_class($item->subclass) === 'Junebug\Models\AudioItem')
        @include('items._form-audio')
      @endif
      @if (get_class($item->subclass) === 'Junebug\Models\FilmItem')
        @include('items._form-film')
      @endif
      @if (get_class($item->subclass) === 'Junebug\Models\VideoItem')
        @include('items._form-video')
      @endif
      {{-- End subclass fields --}}
      @if (!$item->batch())
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
      @endif
    </div>
  </div>
  
  @if (!$item->batch())
    @include('shared._revisions', ['revisionable' => $item])
  @endif

  <div class="row">
    <div class="col-xs-12">
      <hr class="after"/>
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <button class="btn btn-sm btn-primary" type="submit" style="outline: none;"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
      @if (!$item->batch())
        <a class="" href="{{ route('items.show', $item->id) }}">or Cancel</a>
      @else
        <a class="" href="{{ route('items.index') }}">or Cancel</a>
      @endif
    </div>
  </div>

  {!! Form::close() !!}

  @if (!$item->batch())
    @include('items._related')
  @endif

</div>
@stop