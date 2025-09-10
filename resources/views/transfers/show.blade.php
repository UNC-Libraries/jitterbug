@extends('layouts.main', ['title' => 'Transfer', 'section' => 'transfers'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-sm-12">
      {!! Breadcrumbs::render('transfers.show', $transfer) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <h6>{{$transfer->type}} Transfer Details</h6>
    </div>
  </div>
  {{-- Transfer fields --}}
  <div class="row first detail-container">
    <div class="mark @if ($transfer->marked()) marked @endif" role="button" data-markable-type="{{class_basename(get_class($transfer))}}" data-markable-id="{{$transfer->id}}">
      <div class="mark-tail"></div>
    </div>
    <div class="col-sm-6">
      {{--
        In the past, there have been transfers without call numbers. In other
        words they were not linked to an AudioVisualItem. So we will check to
        make sure there is a call number.
       --}}
      @if ($transfer->preservation_instance_id)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          PM #
        </div>
        <div class="col-sm-7 detail-value">
          @if ($transfer->preservationInstance)
            <a href="{{route('instances.show', $transfer->preservationInstance->id)}}" class="detail-link">{{$transfer->preservation_instance_id}}</a>
          @else
            <span class="text-danger" title="Missing preservation instance">{{$transfer->preservation_instance_id}}&nbsp;<i class="fa fa-question" aria-hidden="true"></i></span>
          @endif
        </div>
      </div>
      @endif
      @if ($transfer->call_number)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Call Number
        </div>
        <div class="col-sm-7 detail-value">
          @if ($transfer->item)
            <a href="{{route('items.show', $transfer->item->id)}}" class="detail-link">{{$transfer->call_number}}</a>
          @else
            <span class="text-danger" title="Missing audio visual item">{{$transfer->call_number}}&nbsp;<i class="fa fa-question" aria-hidden="true"></i></span>
          @endif
        </div>
      </div>
      @endif
      @if ($transfer->transfer_date)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Transfer Date
        </div>
        <div class="col-sm-7 detail-value">
          {{$transfer->transfer_date}}
        </div>
      </div>
      @endif
      @if ($transfer->engineer)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Engineer
        </div>
        <div class="col-sm-7 detail-value">
          {{$transfer->engineer_name}}
        </div>
      </div>
      @endif
      @if ($transfer->vendor)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Vendor
        </div>
        <div class="col-sm-7 detail-value">
          {{$transfer->vendor->name}}
        </div>
      </div>
      @endif
      @if ($transfer->playbackMachine)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Playback Machine
        </div>
        <div class="col-sm-7 detail-value">
          {{$transfer->playbackMachine->name}}
        </div>
      </div>
      @endif
      @if ($transfer->transfer_note)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Transfer Note
        </div>
        <div class="col-sm-7 detail-value">
          {{$transfer->transfer_note}}
        </div>
      </div>
      @endif
      @if ($transfer->condition_note)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Condition Note
        </div>
        <div class="col-sm-7 detail-value">
          {{$transfer->condition_note}}
        </div>
      </div>
      @endif
      {{-- End Transfer fields --}}
    </div>
    <div class="col-sm-6">
      {{-- Begin subclass fields --}}

      @if (get_class($transfer->subclass) === 'Jitterbug\Models\AudioTransfer')
      @if ($transfer->subclass->stylus)
      <div class="row">
        <div class="col-sm-4 detail-label">
          Stylus
        </div>
        <div class="col-sm-8 detail-value">
          {{$transfer->subclass->stylus}}
        </div>
      </div>
      @endif
      @if ($transfer->subclass->cartridge)
      <div class="row">
        <div class="col-sm-4 detail-label">
          Cartridge
        </div>
        <div class="col-sm-8 detail-value">
          {{$transfer->subclass->cartridge}}
        </div>
      </div>
      @endif
      @if ($transfer->subclass->first_sound)
      <div class="row">
        <div class="col-sm-4 detail-label">
          First Sound
        </div>
        <div class="col-sm-8 detail-value">
          {{$transfer->subclass->first_sound}}
        </div>
      </div>
      @endif
      @endif
      @if (get_class($transfer->subclass) === 'Jitterbug\Models\FilmTransfer')
        {{-- There are currently no type specific fields for film transfers --}}
      @endif
      @if (get_class($transfer->subclass) === 'Jitterbug\Models\VideoTransfer')
      @if ($transfer->subclass->time_base_corrector)
      <div class="row">
        <div class="col-sm-4 detail-label">
          Time Base Corrector
        </div>
        <div class="col-sm-8 detail-value">
          {{$transfer->subclass->time_base_corrector}}
        </div>
      </div>
      @endif
      @if ($transfer->subclass->ad_converter)
      <div class="row">
        <div class="col-sm-4 detail-label">
          A/D Converter
        </div>
        <div class="col-sm-8 detail-value">
          {{$transfer->subclass->ad_converter}}
        </div>
      </div>
      @endif
      @endif
      {{-- End subclass fields --}}
      <div class="row">
        <div class="col-sm-4 detail-label">
          Created On
        </div>
        <div class="col-sm-8 detail-value">
          {{$transfer->createdOnDisplay}}
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4 detail-label">
          Updated On
        </div>
        <div class="col-sm-8 detail-value">
          {{$transfer->updatedOnDisplay}}
        </div>
      </div>
    </div>
  </div>

  @include('shared._revisions', ['revisionable' => $transfer])

  <div class="row">
    <div class="col-sm-12">
      <hr class="after" />
    </div>
  </div>
  <div class="row last">
    <div class="col-sm-12 actions">
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('transfers.edit', $transfer->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
      @if ($transfer->cut === null && $transfer->type === 'Audio') 
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('cuts.create', array('instanceId' => $transfer->preservationInstance->id, 'transferId' => $transfer->id)) }}"><i class="fa fa-plus" aria-hidden="true"></i> Add Cut</a>
      @endif
      <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target=".confirm-delete-modal" style="outline: none; float: right;"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></button>

      {{ html()->form('DELETE', route('transfers.destroy', [$transfer->id]))->style('display: inline;')->open() }}
      <div class="modal fade confirm-delete-modal" tabindex="-1" role="dialog" aria-labelledby="confirmDelete" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
      {{ html()->form()->close() }}

    </div>
  </div>

  @include('transfers._related')

</div>
@stop