@extends('layouts.master', ['title' => 'Edit Transfer', 'section' => 'transfers'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('transfers.edit', $transfer) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      @if ($transfer->batch())
        <h6>{{$transfer->type}} Transfer Details (editing {{$transfer->count()}} transfers)</h6>
      @else
        <h6>{{$transfer->type}} Transfer Details</h6>
      @endif
    </div>
  </div>

  @if ($transfer->batch())
    {!! Form::model($transfer, array('route' => array('transfers.batch.update'), 'method' => 'put')) !!}
    {!! Form::hidden('ids') !!}
    {!! Form::hidden('subclass_type') !!}
  @else
    {!! Form::model($transfer, array('route' => array('transfers.update', $transfer->id), 'method' => 'put')) !!}
    {!! Form::hidden('id') !!}
    {!! Form::hidden('subclass_type') !!}
    {!! Form::hidden('subclass_id') !!}
  @endif

  <div class="row first detail-container">
    <div class="col-xs-6">
      @include('transfers._form-common')
    </div>
    <div class="col-xs-6">
      {{-- Begin subclass fields --}}
      @if (get_class($transfer->subclass) === 'Jitterbug\Models\AudioTransfer')
        @include('transfers._form-audio')
      @endif
      @if (get_class($transfer->subclass) === 'Jitterbug\Models\FilmTransfer')
        @include('transfers._form-film')
      @endif
      @if (get_class($transfer->subclass) === 'Jitterbug\Models\VideoTransfer')
        @include('transfers._form-video')
      @endif
      {{-- End subclass fields --}}
      @if (!$transfer->batch())
      <div class="row">
        <div class="col-xs-4 detail-label">
          Created On
        </div>
        <div class="col-xs-8 detail-value">
          {{$transfer->createdOnDisplay}}
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 detail-label">
          Updated On
        </div>
        <div class="col-xs-8 detail-value">
          {{$transfer->updatedOnDisplay}}
        </div>
      </div>
      @endif
    </div>
  </div>
  
  @if (!$transfer->batch())
    @include('shared._revisions', ['revisionable' => $transfer])
  @endif

  <div class="row">
    <div class="col-xs-12">
      <hr class="after"/>
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <button class="btn btn-sm btn-primary" type="submit" style="outline: none;"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
      @if (!$transfer->batch())
        <a class="" href="{{ route('transfers.show', $transfer->id) }}">or Cancel</a>
      @else
        <a class="" href="{{ route('transfers.index') }}">or Cancel</a>
      @endif
    </div>
  </div>

  {!! Form::close() !!}

  @if (!$transfer->batch())
    @include('transfers._related')
  @endif

</div>
@stop