@extends('layouts.master', ['title' => 'Edit Cut', 'section' => 'masters'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('masters.cuts.edit', $master, $cut) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <h6>Cut Details</h6>
    </div>
  </div>

  {!! Form::model($cut, array('route' => array('masters.cuts.update', $master->id, $cut->id), 'method' => 'put')) !!}

  <div class="row first detail-container">
    {{-- Left Column --}}
    <div class="col-xs-6">
      @include('masters.cuts._form-left')
    </div>
    {{-- Right Column --}}
    <div class="col-xs-6">
      @include('masters.cuts._form-right')
      <div class="row">
        <div class="col-xs-4 detail-label">
          Created On
        </div>
        <div class="col-xs-8 detail-value">
          {{$cut->createdOnDisplay}}
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 detail-label">
          Updated On
        </div>
        <div class="col-xs-8 detail-value">
          {{$cut->updatedOnDisplay}}
        </div>
      </div>
    </div>
  </div>
  
  @include('shared._revisions', ['revisionable' => $cut])

  <div class="row">
    <div class="col-xs-12">
      <hr class="after"/>
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <button class="btn btn-sm btn-primary" type="submit" style="outline: none;"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
      <a class="" href="{{ route('masters.cuts.show', array($master->id, $cut->id)) }}">or Cancel</a>
    </div>
  </div>

  {!! Form::close() !!}

  @include('masters.cuts._related')

</div>
@stop