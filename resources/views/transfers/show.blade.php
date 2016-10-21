@extends('layouts.master', ['title' => 'Transfer', 'section' => 'transfers'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('transfers.show', $transfer) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>{{$transfer->type}} Transfer Details</h6>
    </div>
  </div>
  {{-- Transfer fields --}}
  <div class="row first detail-container">
    <div class="col-xs-6">
      {{--
        In the past, there have been transfers without call numbers. In other
        words they were not linked to an AudioVisualItem. So we will check to
        make sure there is a call number.
       --}}
      @if ($transfer->preservationMasterId)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          PM #
        </div>
        <div class="col-xs-7 detail-value">
          {{$transfer->preservationMasterId}}
        </div>
      </div>
      @endif
      @if ($transfer->callNumber)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Call Number
        </div>
        <div class="col-xs-7 detail-value">
          {{$transfer->callNumber}}
        </div>
      </div>
      @endif
      @if ($transfer->transferDate)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Transfer Date
        </div>
        <div class="col-xs-7 detail-value">
          {{$transfer->transferDate}}
        </div>
      </div>
      @endif
      @if ($transfer->engineer)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Engineer
        </div>
        <div class="col-xs-7 detail-value">
          {{$transfer->engineerName}}
        </div>
      </div>
      @endif
      @if ($transfer->vendor)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Vendor
        </div>
        <div class="col-xs-7 detail-value">
          {{$transfer->vendor->name}}
        </div>
      </div>
      @endif
      @if ($transfer->playbackMachine)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Playback Machine
        </div>
        <div class="col-xs-7 detail-value">
          {{$transfer->playbackMachine->name}}
        </div>
      </div>
      @endif
      @if ($transfer->transferNote)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Transfer Note
        </div>
        <div class="col-xs-7 detail-value">
          {{$transfer->transferNote}}
        </div>
      </div>
      @endif
      @if ($transfer->conditionNote)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Condition Note
        </div>
        <div class="col-xs-7 detail-value">
          {{$transfer->conditionNote}}
        </div>
      </div>
      @endif
      {{-- End Transfer fields --}}
    </div>
    <div class="col-xs-6">
      {{-- Begin subclass fields --}}

      @if (get_class($transfer->subclass) === 'Junebug\Models\AudioTransfer')
      @if ($transfer->subclass->stylus)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Stylus
        </div>
        <div class="col-xs-8 detail-value">
          {{$transfer->subclass->stylus}}
        </div>
      </div>
      @endif
      @if ($transfer->subclass->cartridge)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Cartridge
        </div>
        <div class="col-xs-8 detail-value">
          {{$transfer->subclass->cartridge}}
        </div>
      </div>
      @endif
      @if ($transfer->subclass->firstSound)
      <div class="row">
        <div class="col-xs-4 detail-label">
          First Sound
        </div>
        <div class="col-xs-8 detail-value">
          {{$transfer->subclass->firstSound}}
        </div>
      </div>
      @endif
      @endif
      @if (get_class($transfer->subclass) === 'Junebug\Models\FilmTransfer')
        {{-- There are currently no type specific fields for film transfers --}}
      @endif
      @if (get_class($transfer->subclass) === 'Junebug\Models\VideoTransfer')
      @if ($transfer->subclass->timeBaseCorrector)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Time Base Corrector
        </div>
        <div class="col-xs-8 detail-value">
          {{$transfer->subclass->timeBaseCorrector}}
        </div>
      </div>
      @endif
      @if ($transfer->subclass->adConverter)
      <div class="row">
        <div class="col-xs-4 detail-label">
          A/D Converter
        </div>
        <div class="col-xs-8 detail-value">
          {{$transfer->subclass->adConverter}}
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
    </div>
  </div>

  @include('shared._revisions', ['revisionable' => $transfer])

  <div class="row">
    <div class="col-xs-12">
      <hr class="after" />
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('transfers.edit', $transfer->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
      <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target=".confirm-delete-modal" style="outline: none; float: right;"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></button>

      {!! Form::open(array('route' => array('transfers.destroy', $transfer->id), 'method' => 'delete', 'style' => 'display: inline;')) !!}
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
              <strong>Be careful!</strong> @if ($transfer->cut) This transfer has a related cut, which will also be deleted.@endif This cannot be undone.
            </div>
            <div class="modal-footer">
              <button name="deleteCommand" value="all" type="submit" class="btn btn-sm btn-danger" style="outline: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Delete</button>
            </div>

          </div>
        </div>
      </div>
      {!! Form::close() !!}

    </div>
  </div>

  @include('transfers._related')

</div>
@stop