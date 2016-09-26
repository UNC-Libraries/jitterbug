@extends('layouts.master', ['title' => 'Preservation Masters', 'section' => 'masters'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('masters.create', $master) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>Create Preservation Master</h6>
    </div>
  </div>

  {!! Form::model($master, array('route' => array('masters.store'), 'method' => 'post')) !!}

  <div class="row">
    <div class="col-xs-12 preform">
      <span id="master-type-controls">
        <span style="margin-right: .75rem">
          {!! Form::label('masterableType', 'Master Type: ', array('class' => 'form-control-label')) !!}
        </span>
        @if ($linked)
          {!! Form::hidden('masterableType') !!}
          <label class="radio-inline">
            {!! Form::radio('masterableType', 'AudioMaster', null, array('disabled' => 'disabled')) !!} Audio
          </label>
          <label class="radio-inline">
            {!! Form::radio('masterableType', 'FilmMaster', null, array('disabled' => 'disabled')) !!} Film
          </label>
          <label class="radio-inline">
            {!! Form::radio('masterableType', 'VideoMaster', null, array('disabled' => 'disabled')) !!} Video
          </label>
        @else
          <label class="radio-inline">
            {!! Form::radio('masterableType', 'AudioMaster') !!} Audio
          </label>
          <label class="radio-inline">
            {!! Form::radio('masterableType', 'FilmMaster') !!} Film
          </label>
          <label class="radio-inline">
            {!! Form::radio('masterableType', 'VideoMaster') !!} Video
          </label>
        @endif
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
      <hr class="before"/>
    </div>
  </div>

  <div class="row first detail-container" style="margin-top: 0">
    <div class="col-xs-6">
      @include('masters._form-common')
    </div>
    <div class="col-xs-6">
      {{-- Begin Masterable Fields --}}
      <div id="audio-form" @if ($master->masterableType !== 'AudioMaster' && Form::old('masterableType') !== 'AudioMaster') style="display: none" @endif>
        @include('masters._form-audio')
      </div>
      <div id="film-form" @if ($master->masterableType !== 'FilmMaster' && Form::old('masterableType') !== 'FilmMaster') style="display: none" @endif>
        @include('masters._form-film')
      </div>
      <div id="video-form" @if ($master->masterableType !== 'VideoMaster' && Form::old('masterableType') !== 'VideoMaster') style="display: none" @endif>
        @include('masters._form-video')
      </div>
      {{-- End Masterable Fields --}}
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