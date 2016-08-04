@extends('layouts.master', ['title' => 'Preservation Master', 'section' => 'masters'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('masters.show', $master) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>{{$master->type}} Preservation Master Details</h6>
    </div>
  </div>
  {{-- Preservation Master Fields --}}
  <div class="row first detail-container">
    <div class="col-xs-6">
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          ID
        </div>
        <div class="col-xs-7 detail-value">
          {{$master->id}}
        </div>
      </div>
      @if ($master->callNumber)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Call Number
        </div>
        <div class="col-xs-7 detail-value">
          {{$master->callNumber}}
        </div>
      </div>
      @endif
      @if ($master->fileNmae)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          File Name
        </div>
        <div class="col-xs-7 detail-value">
          {{$master->fileName}}
        </div>
      </div>
      @endif
      @if ($master->fileLocation)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          File Location
        </div>
        <div class="col-xs-7 detail-value">
          {{$master->fileLocation}}
        </div>
      </div>
      @endif
      @if ($master->checksum)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Checksum
        </div>
        <div class="col-xs-7 detail-value">
          {{$master->checksum}}
        </div>
      </div>
      @endif
      @if ($master->accessFileLocation)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Access File Location
        </div>
        <div class="col-xs-7 detail-value">
          {{$master->accessFileLocation}}
        </div>
      </div>
      @endif
      @if ($master->project)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Project
        </div>
        <div class="col-xs-7 detail-value">
          {{$master->project->name}}
        </div>
      </div>
      @endif
      @if ($master->department)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Department
        </div>
        <div class="col-xs-7 detail-value">
          {{$master->department->name}}
        </div>
      </div>
      @endif
      @if ($master->duration)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Duration
        </div>
        <div class="col-xs-7 detail-value">
          {{$master->duration}}
        </div>
      </div>
      @endif
      {{-- End PreservationMaster Fields --}}
    </div>
    <div class="col-xs-6">
      {{-- Begin Masterable Fields --}}

      @if (get_class($master->masterable) === 'Junebug\Models\AudioPreservationMaster')
      @if ($master->masterable->tapeBrand)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Tape Brand
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->masterable->tapeBrand->name}}
        </div>
      </div>
      @endif
      @if ($master->masterable->pmSpeed)
      <div class="row">
        <div class="col-xs-4 detail-label">
          PM Speed
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->masterable->pmSpeed->name}}
        </div>
      </div>
      @endif
      @if ($master->masterable->samplingRate)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Sampling Rate
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->masterable->samplingRate->name}}
        </div>
      </div>
      @endif
      @if ($master->masterable->testTones)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Test Tones
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->masterable->testTones}}
        </div>
      </div>
      @endif
      @endif
      @if (get_class($master->masterable) === 'Junebug\Models\FilmPreservationMasters')

      @endif
      @if (get_class($master->masterable) === 'Junebug\Models\VideoPreservationMasters')

      @endif
      {{-- End Masterable Fields --}}
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

  @include('shared._revisions', ['revisionable' => $master])

  <div class="row">
    <div class="col-xs-12">
      <hr class="after" />
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('masters.edit', $master->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
      <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target=".confirm-delete-modal" style="outline: none; float: right;"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></button>

      {!! Form::open(array('route' => array('masters.destroy', $master->id), 'method' => 'delete', 'style' => 'display: inline;')) !!}
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
              <strong>Yikes! Are you sure?</strong> @if (count($master->cuts()) > 0 )This master has related cuts and possibly other related records.@endif Do you want to delete just this master, or do you want to delete this master <strong>and all</strong> associated records? This cannot be undone.
            </div>
            <div class="modal-footer">
              <button name="deleteCommand" value="master" type="submit" class="btn btn-sm btn-warning" style="outline: none;"><i class="fa fa-trash" aria-hidden="true"></i> Delete Master Only</button>
              <button name="deleteCommand" value="all" type="submit" class="btn btn-sm btn-danger" style="outline: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Delete All</button>
            </div>

          </div>
        </div>
      </div>
      {!! Form::close() !!}

    </div>
  </div>

  @include('masters._related')

</div>
@stop