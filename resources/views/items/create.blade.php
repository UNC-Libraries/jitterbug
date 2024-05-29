@extends('layouts.main', ['title' => 'Create Audio Visual Item', 'section' => 'items'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('items.create') !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <h6>Create Audio Visual Item</h6>
    </div>
  </div>

  {{ html()->modelForm($item, 'POST', route('items.store', ))->open() }}

  <div class="row first detail-container">
    <div class="row">
      <div class="col-xs-12 preform">
        <span id="item-type-controls">
          <span style="margin-right: .75rem">
            {{ html()->label('Item Type: ', 'subclass_type')->class('form-control-label') }}
          </span>
          <label class="radio-inline">
            {{ html()->radio('subclass_type', false, 'AudioItem') }} Audio
          </label>
          <label class="radio-inline">
            {{ html()->radio('subclass_type', false, 'FilmItem') }} Film
          </label>
          <label class="radio-inline">
            {{ html()->radio('subclass_type', false, 'VideoItem') }} Video
          </label>
        </span>
        <span class="divider"></span>
        <span style="margin-right: .75rem">
          {{ html()->label('Create Batch: ', 'batch')->class('form-control-label') }}
        </span>
        <label style="margin-right: 1.25rem">
          {{ html()->checkbox('batch', false, '1') }}
        </label>
        <span @if ($errors->has('batch_size')) class='has-danger' @endif style="margin-right: .75rem">
          {{ html()->label('Batch Size: ', 'batch_size')->class('form-control-label') }}
        </span>
        <label @if ($errors->has('batch_size')) class='has-danger' @endif>
          {{ html()->text('batch_size')->class('form-control form-control-sm')->style('display: inline; width: 50px; padding: 0.2rem 0.5rem;')->maxlength('3') }}
        </label>
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
        @include('items._form-common')
      </div>
      <div class="col-xs-6">
        {{-- Begin subclass fields --}}
        <div id="audio-form" @if (old('subclass_type') !== null && old('subclass_type') !== 'AudioItem') style="display: none;" @endif>
          @include('items._form-audio')
        </div>
        <div id="film-form" @if (old('subclass_type') !== 'FilmItem') style="display: none;" @endif>
          @include('items._form-film')
        </div>
        <div id="video-form" @if (old('subclass_type') !== 'VideoItem') style="display: none;" @endif>
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

  {{ html()->closeModelForm() }}

</div>
@stop