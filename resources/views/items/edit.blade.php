@extends('layouts.master', ['title' => "Edit $item->type Item"])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12 back">
      <a href="{{ route('items.index') }}"><i class="fa fa-caret-left" aria-hidden="true"></i> Back to Items</a>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>{{$item->type}} Item Details</h6>
    </div>
  </div>

  {!! Form::model($item, array('route' => array('items.update', $item->id), 'method' => 'put')) !!}
  {!! Form::hidden('id') !!}
  {!! Form::hidden('itemableType') !!}
  {!! Form::hidden('itemableId') !!}

  <div class="row first detail-container">
    <div class="col-xs-6">
      @include('items._form-common')
    </div>
    <div class="col-xs-6">
      {{-- Begin Itemable Fields --}}
      @if (get_class($item->itemable) == 'Junebug\Models\AudioItem')
        @include('items._form-audio')
      @endif
      {{-- End Itemable Fields --}}
      <div class="row">
        <div class="col-xs-4 detail-label">
          Created On
        </div>
        <div class="col-xs-7 detail-value">
          4/26/2016 by System
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 detail-label">
          Updated On
        </div>
        <div class="col-xs-7 detail-value">
          5/15/2016 by John Loy
        </div>
      </div>
    </div>
  </div>
  
  @include('shared._revisions', ['revisionable' => $item])

  <div class="row">
    <div class="col-xs-12">
      <hr class="after"/>
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <button class="btn btn-sm btn-primary" type="submit" style="outline: none;"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
      <a class="" href="{{ route('items.show', $item->id) }}">or Cancel</a>
    </div>
  </div>

  {!! Form::close() !!}

  @include('items._related')

</div>
@stop