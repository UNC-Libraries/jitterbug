@extends('layouts.master', ['title' => "$item->type Item"])

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
  {{-- AudioVisualItem Fields --}}
  <div class="row first detail-container">
    <div class="col-xs-6">
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Call Number
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->callNumber}}
        </div>
      </div>
      @if ($item->title)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Title
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->title}}
        </div>
      </div>
      @endif
      @if ($item->containerNote)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Container Note
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->containerNote}}
        </div>
      </div>
      @endif
      @if ($item->collection)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Collection
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->collection->name}}
        </div>
      </div>
      @endif
      @if ($item->format)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Format
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->format->name}}
        </div>
      </div>
      @endif
      @if ($item->recordingLocation)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Rec Location
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->recordingLocation}}
        </div>
      </div>
      @endif
      @if ($item->oclc)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          OCLC Id
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->oclc}}
        </div>
      </div>
      @endif
      @if ($item->itemYear)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Item Year
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->itemYear}}
        </div>
      </div>
      @endif
      @if ($item->itemDate)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Item Date
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->itemDate}}
        </div>
      </div>
      @endif
      @if ($item->speed)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Speed
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->speed}}
        </div>
      </div>
      @endif
      @if ($item->entryDate)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Entry Date
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->entryDate}}
        </div>
      </div>
      @endif
      {{-- End AudioVisualItem Fields --}}
    </div>
    <div class="col-xs-6">
      {{-- Begin Itemable Fields --}}
      @if (get_class($item->itemable) == 'Junebug\Models\AudioItem')
      <div class="row">
        <div class="col-xs-4 detail-label">
          Listening Copy
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->listeningCopyDisplay}}
        </div>
      </div>
      @if ($item->itemable->monoStereo)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Mono/Stereo
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->monoStereoDisplay}}
        </div>
      </div>
      @endif
      @if ($item->itemable->size)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Size
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->size}}
        </div>
      </div>
      @endif
      @if ($item->itemable->trackConfiguration)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Track Configuration
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->trackConfiguration}}
        </div>
      </div>
      @endif
      @if ($item->itemable->base)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Base
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->base}}
        </div>
      </div>
      @endif
      @endif
      {{-- End Itemable Fields --}}
      <div class="row">
        <div class="col-xs-4 detail-label">
          Created On
        </div>
        <div class="col-xs-8 detail-value">
          4/26/2016 by System
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 detail-label">
          Updated On
        </div>
        <div class="col-xs-8 detail-value">
          5/15/2016 by John Loy
        </div>
      </div>
    </div>
  </div>

  @include('shared._revisions', ['revisionable' => $item])

  <div class="row">
    <div class="col-xs-12">
      <hr class="after" />
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('items.edit', $item->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
      {!! Form::open(array('route' => array('items.destroy', $item->id), 'method' => 'delete', 'style' => 'display: inline;')) !!}
        <button class="btn btn-sm btn-secondary" type="submit" style="outline: none; float: right;" data-confirm="Are you sure you want to delete this item?"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></button>
      {!! Form::close() !!}
    </div>
  </div>

  @include('items._related')

</div>
@stop