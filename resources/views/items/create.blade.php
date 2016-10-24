@extends('layouts.master', ['title' => 'Create Audio Visual Item', 'section' => 'items'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('items.create', $item) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <h6>Create Audio Visual Item</h6>
    </div>
  </div>

  {!! Form::model($item, array('route' => array('items.store'), 'method' => 'post')) !!}

  <div class="row first detail-container">
    <div class="row">
      <div class="col-xs-12 preform">
        <span id="item-type-controls">
          <span style="margin-right: .75rem">
            {!! Form::label('subclassType', 'Item Type: ', array('class' => 'form-control-label')) !!}
          </span>
          <label class="radio-inline">
            {!! Form::radio('subclassType', 'AudioItem') !!} Audio
          </label>
          <label class="radio-inline">
            {!! Form::radio('subclassType', 'FilmItem') !!} Film
          </label>
          <label class="radio-inline">
            {!! Form::radio('subclassType', 'VideoItem') !!} Video
          </label>
        </span>
        <span class="divider"></span>
        <span style="margin-right: .75rem">
          {!! Form::label('batch', 'Create Batch: ', array('class' => 'form-control-label')) !!}
        </span>
        <label style="margin-right: 1.25rem">
          {!! Form::checkbox('batch', '1') !!}
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
        @include('items._form-common')
      </div>
      <div class="col-xs-6">
        {{-- Begin subclass fields --}}
        <div id="audio-form" @if (old('subclassType') !== null && old('subclassType') !== 'AudioItem') style="display: none" @endif>
          @include('items._form-audio')
        </div>
        <div id="film-form" @if (old('subclassType') !== 'FilmItem') style="display: none" @endif>
          @include('items._form-film')
        </div>
        <div id="video-form" @if (old('subclassType') !== 'VideoItem') style="display: none" @endif>
          @include('items._form-video')
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
      <a class="" href="{{ route('items.index') }}">or Cancel</a>
    </div>
  </div>

  {!! Form::close() !!}

</div>
@stop