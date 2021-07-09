@extends('layouts.main', ['title' => 'Create Cut', 'section' => 'instances'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('instances.cuts.create', $instance) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <h6>Create Cut</h6>
    </div>
  </div>

  {!! Form::model($cut, array('route' => array('cuts.store', $instance->id), 'method' => 'post')) !!}
  {!! Form::hidden('transferId') !!}

  <div class="row first detail-container">
    <div class="row">
      <div class="col-xs-6">
        @include('instances.cuts._form-left')
      </div>
      <div class="col-xs-6">
        @include('instances.cuts._form-right')
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
      <a class="" href="{{ route('transfers.show', $transfer->id) }}">or Cancel</a>
    </div>
  </div>

  {!! Form::close() !!}


</div>
@stop