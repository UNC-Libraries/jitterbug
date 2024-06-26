@extends('layouts.main', ['title' => 'Cut', 'section' => 'instances'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12"> 
      {!! Breadcrumbs::render('instances.cuts.show', $instance, $cut) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <h6>Cut Details</h6>
    </div>
  </div>
  <div class="row first detail-container">
    {{-- Left Column --}}
    <div class="col-xs-6">
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          PM #
        </div>
        <div class="col-xs-7 detail-value">
          @if ($cut->preservationInstance)
            <a href="{{route('instances.show', $cut->preservationInstance->id)}}" class="detail-link">{{$cut->preservation_instance_id}}</a>
          @else
            <span class="text-danger" title="Missing preservation instance">{{$cut->preservation_instance_id}}&nbsp;<i class="fa fa-question" aria-hidden="true"></i></span>
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Call Number
        </div>
        <div class="col-xs-7 detail-value">
          @if ($cut->item)
            <a href="{{route('items.show', $cut->item->id)}}" class="detail-link">{{$cut->call_number}}</a>
          @else
            <span class="text-danger" title="Missing audio visual item">{{$cut->call_number}}&nbsp;<i class="fa fa-question" aria-hidden="true"></i></span>
          @endif
        </div>
      </div>
      @if ($cut->side)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Side
        </div>
        <div class="col-xs-7 detail-value">
          {{$cut->side}}
        </div>
      </div>
      @endif
      @if ($cut->cut_number)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Cut Number
        </div>
        <div class="col-xs-7 detail-value">
          {{$cut->cut_number}}
        </div>
      </div>
      @endif
    </div>
    {{-- Right Column --}}
    <div class="col-xs-6">
      @if ($cut->title)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Title
        </div>
        <div class="col-xs-8 detail-value">
          {{$cut->title}}
        </div>
      </div>
      @endif
      @if ($cut->performer_composer)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Performer Composer
        </div>
        <div class="col-xs-8 detail-value">
          {{$cut->performer_composer}}
        </div>
      </div>
      @endif
      @if ($cut->pm_start_time)
      <div class="row">
        <div class="col-xs-4 detail-label">
          PM Start Time
        </div>
        <div class="col-xs-8 detail-value">
          {{$cut->pm_start_time}}
        </div>
      </div>
      @endif
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
      <hr class="after" />
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('cuts.edit', $cut->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
      <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target=".confirm-delete-modal" style="outline: none; float: right;"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></button>

      {{ html()->form('DELETE', route('cuts.destroy', [$cut->id]))->style('display: inline;')->open() }}
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
              <strong>Are you sure?</strong> This cut has a related transfer. Do you want to delete just this cut, or do you want to delete this cut and the associated transfer? This cannot be undone.
            </div>
            <div class="modal-footer">
              <button name="deleteCommand" value="cut" type="submit" class="btn btn-sm btn-warning" style="outline: none;"><i class="fa fa-trash" aria-hidden="true"></i> Delete Cut Only</button>
              <button name="deleteCommand" value="all" type="submit" class="btn btn-sm btn-danger" style="outline: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Delete All</button>
            </div>

          </div>
        </div>
      </div>
      {{ html()->form()->close() }}

    </div>
  </div>

  @include('instances.cuts._related')

</div>
@stop