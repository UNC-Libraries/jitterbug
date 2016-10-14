@extends('layouts.master', ['title' => 'Preservation Master', 'section' => 'masters'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('masters.edit', $master) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-e0">
      @if ($master->batch())
        <h6>{{$master->type}} Master Details (editing {{$master->count()}} masters)</h6>
      @else
        <h6>{{$master->type}} Master Details</h6>
      @endif
    </div>
  </div>

  @if ($master->batch())
    {!! Form::model($master, array('route' => array('masters.batch.update'), 'method' => 'put')) !!}
    {!! Form::hidden('ids') !!}
    {!! Form::hidden('subclassType') !!}
  @else
    {!! Form::model($master, array('route' => array('masters.update', $master->id), 'method' => 'put')) !!}
    {!! Form::hidden('id') !!}
    {!! Form::hidden('subclassType') !!}
    {!! Form::hidden('subclassId') !!}
  @endif

  <div class="row first detail-container">
    <div class="col-xs-6">
      @include('masters._form-common')
    </div>
    <div class="col-xs-6">
      {{-- Begin subclass fields --}}
      @if (get_class($master->subclass) === 'Junebug\Models\AudioMaster')
        @include('masters._form-audio')
      @endif
      @if (get_class($master->subclass) === 'Junebug\Models\FilmMaster')
        @include('masters._form-film')
      @endif
      @if (get_class($master->subclass) === 'Junebug\Models\VideoMaster')
        @include('masters._form-video')
      @endif
      {{-- End subclass fields --}}
      @if (!$master->batch())
      <div class="row">
        <div class="col-xs-4 detail-label">
          Created On
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->createdOnDisplay}}
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 detail-label">
          Updated On
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->updatedOnDisplay}}
        </div>
      </div>
      @endif
    </div>
  </div>
  
  @if (!$master->batch())
    @include('shared._revisions', ['revisionable' => $master])
  @endif

  <div class="row">
    <div class="col-xs-12">
      <hr class="after"/>
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <button class="btn btn-sm btn-primary" type="submit" style="outline: none;"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
      @if (!$master->batch())
        <a class="" href="{{ route('masters.show', $master->id) }}">or Cancel</a>
      @else
        <a class="" href="{{ route('masters.index') }}">or Cancel</a>
      @endif
    </div>
  </div>

  {!! Form::close() !!}

  @if (!$master->batch())
    @include('masters._related')
  @endif

</div>
@stop