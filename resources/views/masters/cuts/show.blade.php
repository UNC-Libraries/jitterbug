@extends('layouts.master', ['title' => 'Cut', 'section' => 'masters'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12"> 
      {!! Breadcrumbs::render('masters.cuts.show', $master, $cut) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>Cut Details</h6>
    </div>
  </div>
  <div class="row first detail-container">
    {{-- Left Column --}}
    <div class="col-xs-6">
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Call Number
        </div>
        <div class="col-xs-7 detail-value">
          {{$cut->callNumber}}
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
      @if ($cut->cutNumber)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Cut Number
        </div>
        <div class="col-xs-7 detail-value">
          {{$cut->cutNumber}}
        </div>
      </div>
      @endif
      @if ($cut->title)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Title
        </div>
        <div class="col-xs-7 detail-value">
          {{$cut->title}}
        </div>
      </div>
      @endif
      @if ($cut->performerComposer)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Performer Composer
        </div>
        <div class="col-xs-7 detail-value">
          {{$cut->performerComposer}}
        </div>
      </div>
      @endif
    </div>
    {{-- Right Column --}}
    <div class="col-xs-6">
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

  @include('shared._revisions', ['revisionable' => $cut])

  <div class="row">
    <div class="col-xs-12">
      <hr class="after" />
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('masters.cuts.edit', [$master->id, $cut->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
      <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target=".confirm-delete-modal" style="outline: none; float: right;"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></button>

      {!! Form::open(array('route' => array('masters.cuts.destroy', $master->id, $cut->id), 'method' => 'delete', 'style' => 'display: inline;')) !!}
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
              <strong>Yikes! Are you sure?</strong> @if (count($cut->transfer()) > 0 )This item has related transfers.@endif Do you want to delete just this cut, or do you want to delete this cut <strong>and all</strong> associated records? This cannot be undone.
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

  @include('masters.cuts._related')

</div>
@stop