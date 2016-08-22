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
  {{-- Transfer Fields --}}
  <div class="row first detail-container">
    <div class="col-xs-6">
      {{--
        In the past, there have been transfers without call numbers. In other
        words they were not linked to an AudioVisualItem. So we will check to
        make sure there is a call number.
       --}}
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
      {{-- End Transfer Fields --}}
    </div>
    <div class="col-xs-6">
      {{-- Begin Transferable Fields --}}

      @if (get_class($transfer->transferable) === 'Junebug\Models\AudioTransfer')
      @if ($transfer->transferable->stylus)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Stylus
        </div>
        <div class="col-xs-8 detail-value">
          {{$transfer->transferable->stylus}}
        </div>
      </div>
      @endif
      @if ($transfer->transferable->cartridge)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Cartridge
        </div>
        <div class="col-xs-8 detail-value">
          {{$transfer->transferable->cartridge}}
        </div>
      </div>
      @endif
      @if ($transfer->transferable->firstSound)
      <div class="row">
        <div class="col-xs-4 detail-label">
          First Sound
        </div>
        <div class="col-xs-8 detail-value">
          {{$transfer->transferable->firstSound}}
        </div>
      </div>
      @endif
      @endif
      @if (get_class($transfer->transferable) === 'Junebug\Models\FilmTransfer')

      @endif
      @if (get_class($transfer->transferable) === 'Junebug\Models\VideoTransfer')

      @endif
      {{-- End Transferable Fields --}}
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
              <strong>Be careful!</strong> @if ($transfer->cut) This transfer has a related cut. Do you want to delete just this transfer, or do you want to delete this transfer and the associated cut?@endif This cannot be undone.
            </div>
            <div class="modal-footer">
              <button name="deleteCommand" value="transfer" type="submit" class="btn btn-sm btn-warning" style="outline: none;"><i class="fa fa-trash" aria-hidden="true"></i> Delete Transfer Only</button>
              @if ($transfer->cut)
              <button name="deleteCommand" value="all" type="submit" class="btn btn-sm btn-danger" style="outline: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Delete Transfer and Cut</button>
              @endif
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