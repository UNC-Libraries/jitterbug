@extends('layouts.main', ['title' => 'Create Transfer', 'section' => 'transfers'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('transfers.create') !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <h6>Create Transfer</h6>
    </div>
  </div>

  {{ html()->modelForm($transfer, 'POST', route('transfers.store', ))->open() }}

  <div class="row first detail-container">
    <div class="row">
      <div class="col-xs-12 preform">
        <span id="transfer-type-controls">
          <span style="margin-right: .75rem">
            {{ html()->label('Transfer Type: ', 'subclass_type')->class('form-control-label') }}
          </span>
          @if ($linked)
            {{ html()->hidden('subclass_type') }}
            <label class="radio-inline">
              {{ html()->radio('subclass_type', null, 'AudioTransfer')->attribute('disabled', 'disabled') }} Audio
            </label>
            <label class="radio-inline">
              {{ html()->radio('subclass_type', null, 'FilmTransfer')->attribute('disabled', 'disabled') }} Film
            </label>
            <label class="radio-inline">
              {{ html()->radio('subclass_type', null, 'VideoTransfer')->attribute('disabled', 'disabled') }} Video
            </label>
          @else
            <label class="radio-inline">
              {{ html()->radio('subclass_type', false, 'AudioTransfer') }} Audio
            </label>
            <label class="radio-inline">
              {{ html()->radio('subclass_type', false, 'FilmTransfer') }} Film
            </label>
            <label class="radio-inline">
              {{ html()->radio('subclass_type', false, 'VideoTransfer') }} Video
            </label>
          @endif
        </span>
        <span class="divider"></span>
        <span style="margin-right: .75rem">
          {{ html()->label('Mark: ', 'mark')->class('form-control-label') }}
        </span>
        <label>
          {{ html()->checkbox('mark', false, '1') }}
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
        @include('transfers._form-common')
      </div>
      <div class="col-xs-6">
        {{-- Begin subclass fields --}}
        <div id="audio-form" @if (($linked && $transfer->subclass_type !== 'AudioTransfer') || old('subclass_type') !== null && old('subclass_type') !== 'AudioTransfer') style="display: none" @endif>
          @include('transfers._form-audio')
        </div>
        <div id="film-form" @if ($transfer->subclass_type !== 'FilmTransfer' && old('subclass_type') !== 'FilmTransfer') style="display: none" @endif>
          @include('transfers._form-film')
        </div>
        <div id="video-form" @if ($transfer->subclass_type !== 'VideoTransfer' && old('subclass_type') !== 'VideoTransfer') style="display: none" @endif>
          @include('transfers._form-video')
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
      <a class="" href="{{ route('instances.show', $instance->id) }}">or Cancel</a>
      @else
      <a class="" href="{{ route('transfers.index') }}">or Cancel</a>
      @endif
    </div>
  </div>

  {{ html()->closeModelForm() }}


</div>
@stop