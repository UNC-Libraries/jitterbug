@extends('layouts.main', ['title' => 'Create Preservation Instance', 'section' => 'instances'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('instances.create') !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <h6>Create Preservation Instance</h6>
    </div>
  </div>

  {!! Form::model($instance, array('route' => array('instances.store'), 'method' => 'post')) !!}

  <div class="row first detail-container">
    <div class="row">
      <div class="col-xs-12 preform">
        <span id="instance-type-controls">
          <span style="margin-right: .75rem">
            {!! Form::label('subclass_type', 'Instance Type: ', array('class' => 'form-control-label')) !!}
          </span>
          @if ($linked)
            {!! Form::hidden('subclass_type') !!}
            <label class="radio-inline">
              {!! Form::radio('subclass_type', 'AudioInstance', null, array('disabled' => 'disabled')) !!} Audio
            </label>
            <label class="radio-inline">
              {!! Form::radio('subclass_type', 'FilmInstance', null, array('disabled' => 'disabled')) !!} Film
            </label>
            <label class="radio-inline">
              {!! Form::radio('subclass_type', 'VideoInstance', null, array('disabled' => 'disabled')) !!} Video
            </label>
          @else
            <label class="radio-inline">
              {!! Form::radio('subclass_type', 'AudioInstance') !!} Audio
            </label>
            <label class="radio-inline">
              {!! Form::radio('subclass_type', 'FilmInstance') !!} Film
            </label>
            <label class="radio-inline">
              {!! Form::radio('subclass_type', 'VideoInstance') !!} Video
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
        <span @if ($errors->has('batch_size')) class='has-danger' @endif style="margin-right: .75rem">
          {!! Form::label('batch_size', 'Batch Size: ', array('class' => 'form-control-label')) !!}
        </span>
        <label @if ($errors->has('batch_size')) class='has-danger' @endif>
          {!! Form::text('batch_size', null, array('class' => 'form-control form-control-sm', 'style' => 'display: inline; width: 50px; padding: 0.2rem 0.5rem;', 'maxlength' => '3')) !!}
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
        @include('instances._form-common')
      </div>
      <div class="col-xs-6">
        {{-- Begin subclass fields --}}
        <div id="audio-form" @if (($linked && $instance->subclass_type !== 'AudioInstance') || old('subclass_type') !== null && old('subclass_type') !== 'AudioInstance') style="display: none" @endif>
          @include('instances._form-audio')
        </div>
        <div id="film-form" @if ($instance->subclass_type !== 'FilmInstance' && old('subclass_type') !== 'FilmInstance') style="display: none" @endif>
          @include('instances._form-film')
        </div>
        <div id="video-form" @if ($instance->subclass_type !== 'VideoInstance' && old('subclass_type') !== 'VideoInstance') style="display: none" @endif>
          @include('instances._form-video')
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
      <a class="" href="{{ route('instances.index') }}">or Cancel</a>
      @endif
    </div>
  </div>

  {!! Form::close() !!}


</div>
@stop