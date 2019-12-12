@extends('layouts.master', ['title' => 'Create Preservation Master', 'section' => 'masters'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('masters.create') !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <h6>Create Preservation Master</h6>
    </div>
  </div>

  {!! Form::model($master, array('route' => array('masters.store'), 'method' => 'post')) !!}

  <div class="row first detail-container">
    <div class="row">
      <div class="col-xs-12 preform">
        <span id="master-type-controls">
          <span style="margin-right: .75rem">
            {!! Form::label('subclassType', 'Master Type: ', array('class' => 'form-control-label')) !!}
          </span>
          @if ($linked)
            {!! Form::hidden('subclassType') !!}
            <label class="radio-inline">
              {!! Form::radio('subclassType', 'AudioMaster', null, array('disabled' => 'disabled')) !!} Audio
            </label>
            <label class="radio-inline">
              {!! Form::radio('subclassType', 'FilmMaster', null, array('disabled' => 'disabled')) !!} Film
            </label>
            <label class="radio-inline">
              {!! Form::radio('subclassType', 'VideoMaster', null, array('disabled' => 'disabled')) !!} Video
            </label>
          @else
            <label class="radio-inline">
              {!! Form::radio('subclassType', 'AudioMaster') !!} Audio
            </label>
            <label class="radio-inline">
              {!! Form::radio('subclassType', 'FilmMaster') !!} Film
            </label>
            <label class="radio-inline">
              {!! Form::radio('subclassType', 'VideoMaster') !!} Video
            </label>
          @endif
        </span>
        <span class="divider"></span>
        <span style="margin-right: .75rem">
          {!! Form::label('batch-checkbox', 'Create Batch: ', array('class' => 'form-control-label')) !!}
        </span>
        <label style="margin-right: 1.25rem">
          {!! Form::checkbox('batch', '1', null, array('id' => 'batch-checkbox')) !!}
        </label>
        <span @if ($errors->has('batchSize')) class='has-danger' @endif style="margin-right: .75rem">
          {!! Form::label('batchSize', 'Batch Size: ', array('class' => 'form-control-label')) !!}
        </span>
        <label @if ($errors->has('batchSize')) class='has-danger' @endif>
          {!! Form::text('batchSize', null, array('class' => 'form-control form-control-sm', 'style' => 'display: inline; width: 50px; padding: 0.2rem 0.5rem;', 'maxlength' => '3')) !!}
        </label>
        <span class="divider"></span>
        <span style="margin-right: .75rem">
          {!! Form::label('mark', 'Mark: ', array('class' => 'form-control-label')) !!}
        </span>
        <label>
          {!! Form::checkbox('mark', '1') !!}
        </label>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <hr class="after"/>
      </div>
    </div>
    
    <div class="row">
      <div class="col-xs-6">
        @include('masters._form-common')
      </div>
      <div class="col-xs-6">
        {{-- Begin subclass fields --}}
        <div id="audio-form" @if (($linked && $master->subclassType !== 'AudioMaster') || old('subclassType') !== null && old('subclassType') !== 'AudioMaster') style="display: none" @endif>
          @include('masters._form-audio')
        </div>
        <div id="film-form" @if ($master->subclassType !== 'FilmMaster' && old('subclassType') !== 'FilmMaster') style="display: none" @endif>
          @include('masters._form-film')
        </div>
        <div id="video-form" @if ($master->subclassType !== 'VideoMaster' && old('subclassType') !== 'VideoMaster') style="display: none" @endif>
          @include('masters._form-video')
        </div>
        {{-- End subclass fields --}}
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <hr class="after"/>
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <button class="btn btn-sm btn-primary" type="submit" style="outline: none;"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
      @if ($linked)
      <a class="" href="{{ route('items.show', $item->id) }}">or Cancel</a>
      @else
      <a class="" href="{{ route('masters.index') }}">or Cancel</a>
      @endif
    </div>
  </div>

  {!! Form::close() !!}


</div>
@stop