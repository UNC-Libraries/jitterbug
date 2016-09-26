@extends('layouts.master', ['title' => 'Audio Visual Item', 'section' => 'items'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('items.show', $item) !!}
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
      @if (get_class($item->itemable) === 'Junebug\Models\AudioItem')
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
          Track Config
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
      @if ($item->itemable->contentDescription)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Content Description
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->contentDescription}}
        </div>
      </div>
      @endif
      @endif
      @if (get_class($item->itemable) === 'Junebug\Models\FilmItem')
      @if ($item->itemable->element)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Element
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->element}}
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
      @if ($item->itemable->color)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Color
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->color}}
        </div>
      </div>
      @endif
      @if ($item->itemable->soundType)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Sound Type
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->soundType}}
        </div>
      </div>
      @endif
      @if ($item->itemable->lengthInFeet)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Length in Feet
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->lengthInFeet}}
        </div>
      </div>
      @endif
      @if ($item->itemable->filmStock)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Film Stock
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->filmStock}}
        </div>
      </div>
      @endif
      @if ($item->itemable->edgeCode)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Edge Code
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->edgeCode}}
        </div>
      </div>
      @endif
      @if ($item->itemable->shrinkagePercent)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Shrinkage Percent
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->shrinkagePercent}}
        </div>
      </div>
      @endif
      @if ($item->itemable->canNumber)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Can Number
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->canNumber}}
        </div>
      </div>
      @endif
      @if ($item->itemable->contentDescription)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Content Description
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->contentDescription}}
        </div>
      </div>
      @endif
      @endif
      @if (get_class($item->itemable) === 'Junebug\Models\VideoItem')
      @if ($item->itemable->monoStereoDisplay)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Mono/Stereo
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->monoStereoDisplay}}
        </div>
      </div>
      @endif
      @if ($item->itemable->element)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Element
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->element}}
        </div>
      </div>
      @endif
      @if ($item->itemable->color)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Color
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->color}}
        </div>
      </div>
      @endif
      @if ($item->itemable->recordingStandard)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Recording Standard
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->recordingStandard}}
        </div>
      </div>
      @endif
      @if ($item->itemable->contentDescription)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Content Description
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->itemable->contentDescription}}
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
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('items.edit', $item->id) }}" style="margin-right: .3rem;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('masters.create', array('item' => $item->id)) }}"><i class="fa fa-plus" aria-hidden="true"></i> Add Master</a>
      <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target=".confirm-delete-modal" style="outline: none; float: right;"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></button>

      {!! Form::open(array('route' => array('items.destroy', $item->id), 'method' => 'delete', 'style' => 'display: inline;')) !!}
      <div class="modal fade confirm-delete-modal" tabindex="-1" role="dialog" aria-labelledby="confirmDelete" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 id="confirmDelete" class="modal-title">Confirm Delete</h4>
            </div>
            <div class="modal-body">
              <strong>Yikes! Are you sure?</strong> @if (count($item->preservationMasters()) > 0 )This item has related preservation masters and transfers.@endif Do you want to delete just this item, or do you want to delete this item <strong>and all</strong> associated records? This cannot be undone.
            </div>
            <div class="modal-footer">
              <button name="deleteCommand" value="item" type="submit" class="btn btn-sm btn-warning" style="outline: none;"><i class="fa fa-trash" aria-hidden="true"></i> Delete Item Only</button>
              <button name="deleteCommand" value="all" type="submit" class="btn btn-sm btn-danger" style="outline: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Delete All</button>
            </div>

          </div>
        </div>
      </div>
      {!! Form::close() !!}

    </div>
  </div>

  @include('items._related')

</div>
@stop