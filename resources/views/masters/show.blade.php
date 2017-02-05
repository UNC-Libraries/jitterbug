@extends('layouts.master', ['title' => 'Preservation Master', 'section' => 'masters'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('masters.show', $master) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <h6>{{$master->type}} Master Details</h6>
    </div>
  </div>
  {{-- PreservationMaster fields --}}
  <div class="row first detail-container">
    <div class="mark @if ($master->marked()) marked @endif" role="button" data-markable-type="{{class_basename(get_class($master))}}" data-markable-id="{{$master->id}}">
      <div class="mark-tail"></div>
    </div>
    <div class="col-xs-6">
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          PM #
        </div>
        <div class="col-xs-7 detail-value">
          {{$master->id}}
        </div>
      </div>
      {{--
        In the past, there have been masters without call numbers. In other
        words they were not linked to an AudioVisualItem, so here we will
        check to make sure a call number is defined before we display it.
       --}}
      @if ($master->callNumber)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Call Number
        </div>
        <div class="col-xs-7 detail-value">
          @if ($master->item)
            <a href="{{route('items.show', $master->item->id)}}" class="detail-link">{{$master->callNumber}}</a>
          @else
            <span class="text-danger" title="Missing audio visual item">{{$master->callNumber}}&nbsp;<i class="fa fa-question" aria-hidden="true"></i></span>
          @endif
        </div>
      </div>
      @endif
      @if ($master->fileName)
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
      @if ($master->fileSizeInBytes)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          File Size (bytes)
        </div>
        <div class="col-xs-7 detail-value">
          {{$master->fileSizeInBytes}}
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
      @if ($master->reproductionMachine)
      <div class="row">
        <div class="col-xs-4 col-xs-offset-1 detail-label">
          Repro Machine
        </div>
        <div class="col-xs-7 detail-value">
          {{$master->reproductionMachine->name}}
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
    </div>
    <div class="col-xs-6">
      @if ($master->fileFormat)
      <div class="row">
        <div class="col-xs-4 detail-label">
          File Format
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->fileFormat}}
        </div>
      </div>
      @endif
      @if ($master->fileCodec)
      <div class="row">
        <div class="col-xs-4 detail-label">
          File Codec
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->fileCodec}}
        </div>
      </div>
      @endif
      {{-- End PreservationMaster fields --}}
      
      {{-- Begin subclass fields --}}

      @if (get_class($master->subclass) === 'Jitterbug\Models\AudioMaster')
      @if ($master->subclass->samplingRate)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Sampling Rate
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->subclass->samplingRate->name}}
        </div>
      </div>
      @endif
      @if ($master->subclass->tapeBrand)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Tape Brand
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->subclass->tapeBrand->name}}
        </div>
      </div>
      @endif
      @if ($master->subclass->pmSpeed)
      <div class="row">
        <div class="col-xs-4 detail-label">
          PM Speed
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->subclass->pmSpeed->name}}
        </div>
      </div>
      @endif
      @if ($master->subclass->testTones)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Test Tones
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->subclass->testTones}}
        </div>
      </div>
      @endif
      @endif
      @if (get_class($master->subclass) === 'Jitterbug\Models\FilmMaster')
      @if ($master->subclass->frameSize)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Frame Size
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->subclass->frameSize}}
        </div>
      </div>
      @endif
      @if ($master->subclass->aspectRatio)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Aspect Ratio
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->subclass->aspectRatio}}
        </div>
      </div>
      @endif
      @endif
      @if (get_class($master->subclass) === 'Jitterbug\Models\VideoMaster')
      @if ($master->subclass->frameSize)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Frame Size
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->subclass->frameSize}}
        </div>
      </div>
      @endif
      @if ($master->subclass->aspectRatio)
      <div class="row">
        <div class="col-xs-4 detail-label">
          Aspect Ratio
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->subclass->aspectRatio}}
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
          {{$master->createdOnDisplay}}
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 detail-label">
          Updated On
        </div>
        <div class="col-xs-8 detail-value">
          {{$master->updatedOnDisplay}}
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
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('masters.edit', $master->id) }}" style="margin-right: .3rem;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('transfers.create', array('masterId' => $master->id)) }}"><i class="fa fa-plus" aria-hidden="true"></i> Add Transfer</a>
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
              <strong>Yikes! Are you sure?</strong> 
              @if (count($master->cuts) > 0 && count($master->transfers) > 0)
                This master has related transfers and cuts.
              @elseif (count($master->cuts) > 0 && count($master->transfers) === 0) 
                This master has related cuts.
              @elseif (count($master->cuts) === 0 && count($master->transfers) > 0) 
                This master has related transfers.
              @endif
              Do you want to delete just this master, or do you want to delete this master <strong>and all</strong> associated records? This cannot be undone.
            </div>
            <div class="modal-footer">
              <button name="deleteCommand" value="all" type="submit" class="btn btn-sm btn-danger" style="outline: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Delete All</button>
              <button name="deleteCommand" value="master" type="submit" class="btn btn-sm btn-warning" style="outline: none;"><i class="fa fa-trash" aria-hidden="true"></i> Delete Master Only</button>
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