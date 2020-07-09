@extends('layouts.master', ['title' => 'Audio Visual Item', 'section' => 'items'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('items.show', $item) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <h6>{{$item->type}} Item Details</h6>
    </div>
  </div>
  {{-- AudioVisualItem fields --}}
  <div class="row first detail-container">
    <div class="mark @if ($item->marked()) marked @endif" role="button" data-markable-type="{{class_basename(get_class($item))}}" data-markable-id="{{$item->id}}">
      <div class="mark-tail"></div>
    </div>
    <div class="col-xs-6">
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Call Number
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->call_number}}
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
      @if ($item->container_note)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Container Note
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->container_note}}
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
      @if ($item->accession_number)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Accession Number
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->accession_number}}
        </div>
      </div>
      @endif
      @if ($item->legacy)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Legacy Id
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->legacy}}
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
      @if ($item->reel_tape_number)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Reel/Tape Number
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->reel_tape_number}}
        </div>
      </div>
      @endif
      @if ($item->recording_location)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Recording Location
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->recording_location}}
        </div>
      </div>
      @endif
      @if ($item->physical_location)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Physical Location
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->physical_location}}
        </div>
      </div>
      @endif
      @if ($item->access_restrictions)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Access Restrictions
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->access_restrictions}}
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
      @if ($item->item_year)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Item Year
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->item_year}}
        </div>
      </div>
      @endif
      @if ($item->item_date)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Item Date
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->item_date}}
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
      @if ($item->entry_date)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Entry Date
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->entry_date}}
        </div>
      </div>
      @endif
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Blank?
        </div>
        <div class="col-xs-7 detail-value">
          {{$item->blank_display}}
        </div>
      </div>
      {{-- End AudioVisualItem fields --}}
    </div>
    <div class="col-xs-6">
      {{-- Begin subclass fields --}}
      @if (get_class($item->subclass) === 'Jitterbug\Models\AudioItem')
      <div class="row">
        <div class="col-xs-4 detail-label">
          Listening Copy
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->listening_copy_display}}
        </div>
      </div>
      @if ($item->subclass->mono_stereo)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Mono/Stereo
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->mono_stereo_display}}
        </div>
      </div>
      @endif
      @if ($item->subclass->size)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Size
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->size}}
        </div>
      </div>
      @endif
      @if ($item->subclass->track_configuration)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Track Config
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->track_configuration}}
        </div>
      </div>
      @endif
      @if ($item->subclass->base)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Base
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->base}}
        </div>
      </div>
      @endif
      @if ($item->subclass->content_description)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Content Description
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->content_description}}
        </div>
      </div>
      @endif
      @endif
      @if (get_class($item->subclass) === 'Jitterbug\Models\FilmItem')
      @if ($item->subclass->element)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Element
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->element}}
        </div>
      </div>
      @endif
      @if ($item->subclass->base)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Base
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->base}}
        </div>
      </div>
      @endif
      @if ($item->subclass->color)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Color
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->color}}
        </div>
      </div>
      @endif
      @if ($item->subclass->sound_type)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Sound Type
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->sound_type}}
        </div>
      </div>
      @endif
      @if ($item->subclass->length_in_feet)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Length in Feet
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->length_in_feet}}
        </div>
      </div>
      @endif
      @if ($item->subclass->film_stock)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Film Stock
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->film_stock}}
        </div>
      </div>
      @endif
      @if ($item->subclass->edge_code)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Edge Code
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->edge_code}}
        </div>
      </div>
      @endif
      @if ($item->subclass->shrinkage_percent)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Shrinkage Percent
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->shrinkage_percent}}
        </div>
      </div>
      @endif
      @if ($item->subclass->can_number)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Can Number
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->can_number}}
        </div>
      </div>
      @endif
      @if ($item->subclass->condition)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Condition
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->condition}}
        </div>
      </div>
      @endif
      @if ($item->subclass->content_description)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Content Description
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->content_description}}
        </div>
      </div>
      @endif
      @endif
      @if (get_class($item->subclass) === 'Jitterbug\Models\VideoItem')
      @if ($item->subclass->mono_stereo_display)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Mono/Stereo
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->mono_stereo_display}}
        </div>
      </div>
      @endif
      @if ($item->subclass->element)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Element
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->element}}
        </div>
      </div>
      @endif
      @if ($item->subclass->color)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Color
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->color}}
        </div>
      </div>
      @endif
      @if ($item->subclass->recording_standard)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Recording Standard
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->recording_standard}}
        </div>
      </div>
      @endif
      @if ($item->subclass->content_description)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Content Description
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->subclass->content_description}}
        </div>
      </div>
      @endif
      @endif
      {{-- End subclass fields --}}
      <div class="row">
        <div class="col-xs-4 detail-label">
          Created On
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->createdOnDisplay}}
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 detail-label">
          Updated On
        </div>
        <div class="col-xs-8 detail-value">
          {{$item->updatedOnDisplay}}
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
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('masters.create', array('itemId' => $item->id)) }}"><i class="fa fa-plus" aria-hidden="true"></i> Add Master</a>
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
              <strong>Yikes! Are you sure?</strong>
              @if (count($item->preservationMasters) > 0 && count($item->cuts) > 0)
                This item has related preservation masters and cuts.
              @elseif (count($item->preservationMasters) > 0) 
                This item has related preservation masters.
              @endif
              Do you want to delete just this item, or do you want to delete this item <strong>and all</strong> associated records? This cannot be undone.
            </div>
            <div class="modal-footer">
              <button name="deleteCommand" value="all" type="submit" class="btn btn-sm btn-danger" style="outline: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Delete All</button>
              <button name="deleteCommand" value="item" type="submit" class="btn btn-sm btn-warning" style="outline: none;"><i class="fa fa-trash" aria-hidden="true"></i> Delete Item Only</button>
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