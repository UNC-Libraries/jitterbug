@extends('layouts.master', ['title' => 'Create Transfer', 'section' => 'transfers'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('transfers.create', $transfer) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>Create Transfer</h6>
    </div>
  </div>

  {!! Form::model($transfer, array('route' => array('transfers.store'), 'method' => 'post')) !!}

  <div class="row">
    <div class="col-xs-12 preform">
      <span id="transfer-type-controls">
        <span style="margin-right: .75rem">
          {!! Form::label('subclassType', 'Transfer Type: ', array('class' => 'form-control-label')) !!}
        </span>
        @if ($linked)
          {!! Form::hidden('subclassType') !!}
          <label class="radio-inline">
            {!! Form::radio('subclassType', 'AudioTransfer', null, array('disabled' => 'disabled')) !!} Audio
          </label>
          <label class="radio-inline">
            {!! Form::radio('subclassType', 'FilmTransfer', null, array('disabled' => 'disabled')) !!} Film
          </label>
          <label class="radio-inline">
            {!! Form::radio('subclassType', 'VideoTransfer', null, array('disabled' => 'disabled')) !!} Video
          </label>
        @else
          <label class="radio-inline">
            {!! Form::radio('subclassType', 'AudioTransfer') !!} Audio
          </label>
          <label class="radio-inline">
            {!! Form::radio('subclassType', 'FilmTransfer') !!} Film
          </label>
          <label class="radio-inline">
            {!! Form::radio('subclassType', 'VideoTransfer') !!} Video
          </label>
        @endif
      </span>
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
      @include('transfers._form-common')
    </div>
    <div class="col-xs-6">
      {{-- Begin subclass fields --}}
      <div id="audio-form" @if (($linked && $transfer->subclassType !== 'AudioTransfer') || old('subclassType') !== null && old('subclassType') !== 'AudioTransfer') style="display: none" @endif>
        @include('transfers._form-audio')
      </div>
      <div id="film-form" @if ($transfer->subclassType !== 'FilmTransfer' && old('subclassType') !== 'FilmTransfer') style="display: none" @endif>
        @include('transfers._form-film')
      </div>
      <div id="video-form" @if ($transfer->subclassType !== 'VideoTransfer' && old('subclassType') !== 'VideoTransfer') style="display: none" @endif>
        @include('transfers._form-video')
      </div>
      {{-- End subclass fields --}}
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
      <a class="" href="{{ route('masters.show', $master->id) }}">or Cancel</a>
      @else
      <a class="" href="{{ route('transfers.index') }}">or Cancel</a>
      @endif
    </div>
  </div>

  {!! Form::close() !!}


</div>
@stop