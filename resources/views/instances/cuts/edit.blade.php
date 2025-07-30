@extends('layouts.main', ['title' => 'Cut', 'section' => 'instances'])
@section('content')
<div id="detail">
  <div class="row">
    <div class="col-sm-12">
      {!! Breadcrumbs::render('instances.cuts.edit', $instance, $cut) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <h6>Cut Details</h6>
    </div>
  </div>

  {{ html()->modelForm($cut, 'PUT', route('cuts.update', [$cut->id]))->open() }}

  <div class="row first detail-container">
    {{-- Left Column --}}
    <div class="col-sm-6">
      @include('instances.cuts._form-left')
    </div>
    {{-- Right Column --}}
    <div class="col-sm-6">
      @include('instances.cuts._form-right')
      <div class="row">
        <div class="col-sm-4 detail-label">
          Created On
        </div>
        <div class="col-sm-8 detail-value">
          {{$cut->createdOnDisplay}}
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4 detail-label">
          Updated On
        </div>
        <div class="col-sm-8 detail-value">
          {{$cut->updatedOnDisplay}}
        </div>
      </div>
    </div>
  </div>

  @include('shared._revisions', ['revisionable' => $cut])

  <div class="row">
    <div class="col-sm-12">
      <hr class="after"/>
    </div>
  </div>
  <div class="row last">
    <div class="col-sm-12 actions">
      <button class="btn btn-sm btn-primary" type="submit" style="outline: none;"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
      <a class="" href="{{ route('cuts.show', $cut->id) }}">or Cancel</a>
    </div>
  </div>

  {{ html()->closeModelForm() }}

  @include('instances.cuts._related')

</div>
@stop