@extends('layouts.main', ['title' => 'Preservation Instance', 'section' => 'instances'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-sm-12">
      {!! Breadcrumbs::render('instances.show', $instance) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <h6>{{$instance->type}} Preservation Instance Details</h6>
    </div>
  </div>
  {{-- PreservationInstance fields --}}
  <div class="row first detail-container">
    <div class="mark @if ($instance->marked()) marked @endif" role="button" data-markable-type="{{class_basename(get_class($instance))}}" data-markable-id="{{$instance->id}}">
      <div class="mark-tail"></div>
    </div>
    <div class="col-sm-6">
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          PM #
        </div>
        <div class="col-sm-7 detail-value">
          {{$instance->id}}
        </div>
      </div>
      {{--
        In the past, there have been instances without call numbers. In other
        words they were not linked to an AudioVisualItem, so here we will
        check to make sure a call number is defined before we display it.
       --}}
      @if ($instance->call_number)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Call Number
        </div>
        <div class="col-sm-7 detail-value">
          @if ($instance->item)
            <a href="{{route('items.show', $instance->item->id)}}" class="detail-link">{{$instance->call_number}}</a>
          @else
            <span class="text-danger" title="Missing audio visual item">{{$instance->call_number}}&nbsp;<i class="fa fa-question" aria-hidden="true"></i></span>
          @endif
        </div>
      </div>
      @endif
      @if ($instance->file_name)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          File Name
        </div>
        <div class="col-sm-7 detail-value">
          {{$instance->file_name}}
        </div>
      </div>
      @endif
      @if ($instance->file_location)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          File Location
        </div>
        <div class="col-sm-7 detail-value">
          {{$instance->file_location}}
        </div>
      </div>
      @endif
      @if ($instance->file_size_in_bytes)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          File Size (bytes)
        </div>
        <div class="col-sm-7 detail-value">
          {{$instance->file_size_in_bytes}}
        </div>
      </div>
      @endif
      @if ($instance->duration)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Duration
        </div>
        <div class="col-sm-7 detail-value">
          {{$instance->duration}}
        </div>
      </div>
      @endif
      @if ($instance->checksum)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Checksum
        </div>
        <div class="col-sm-7 detail-value">
          {{$instance->checksum}}
        </div>
      </div>
      @endif
      @if ($instance->access_file_location)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Access File Location
        </div>
        <div class="col-sm-7 detail-value">
          {{$instance->access_file_location}}
        </div>
      </div>
      @endif
      @if ($instance->reproductionMachine)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Repro Machine
        </div>
        <div class="col-sm-7 detail-value">
          {{$instance->reproductionMachine->name}}
        </div>
      </div>
      @endif
      @if ($instance->project)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Project
        </div>
        <div class="col-sm-7 detail-value">
          {{$instance->project->name}}
        </div>
      </div>
      @endif
      @if ($instance->department)
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1 detail-label">
          Department
        </div>
        <div class="col-sm-7 detail-value">
          {{$instance->department->name}}
        </div>
      </div>
      @endif
    </div>
    <div class="col-sm-6">
      @if ($instance->file_format)
      <div class="row">
        <div class="col-sm-4 detail-label">
          File Format
        </div>
        <div class="col-sm-8 detail-value">
          {{$instance->file_format}}
        </div>
      </div>
      @endif
      @if ($instance->file_codec)
      <div class="row">
        <div class="col-sm-4 detail-label">
          File Codec
        </div>
        <div class="col-sm-8 detail-value">
          {{$instance->file_codec}}
        </div>
      </div>
      @endif
      {{-- End PreservationInstance fields --}}
      
      {{-- Begin subclass fields --}}

      @if (get_class($instance->subclass) === 'Jitterbug\Models\AudioInstance')
      @if ($instance->subclass->samplingRate)
      <div class="row">
        <div class="col-sm-4 detail-label">
          Sampling Rate
        </div>
        <div class="col-sm-8 detail-value">
          {{$instance->subclass->samplingRate->name}}
        </div>
      </div>
      @endif
      @if ($instance->subclass->tapeBrand)
      <div class="row">
        <div class="col-sm-4 detail-label">
          Tape Brand
        </div>
        <div class="col-sm-8 detail-value">
          {{$instance->subclass->tapeBrand->name}}
        </div>
      </div>
      @endif
      @if ($instance->subclass->pmSpeed)
      <div class="row">
        <div class="col-sm-4 detail-label">
          PM Speed
        </div>
        <div class="col-sm-8 detail-value">
          {{$instance->subclass->pmSpeed->name}}
        </div>
      </div>
      @endif
      @if ($instance->subclass->test_tones)
      <div class="row">
        <div class="col-sm-4 detail-label">
          Test Tones
        </div>
        <div class="col-sm-8 detail-value">
          {{$instance->subclass->test_tones}}
        </div>
      </div>
      @endif
      @endif
      @if (get_class($instance->subclass) === 'Jitterbug\Models\FilmInstance')
      @if ($instance->subclass->frame_size)
      <div class="row">
        <div class="col-sm-4 detail-label">
          Frame Size
        </div>
        <div class="col-sm-8 detail-value">
          {{$instance->subclass->frame_size}}
        </div>
      </div>
      @endif
      @if ($instance->subclass->aspect_ratio)
      <div class="row">
        <div class="col-sm-4 detail-label">
          Aspect Ratio
        </div>
        <div class="col-sm-8 detail-value">
          {{$instance->subclass->aspect_ratio}}
        </div>
      </div>
      @endif
      @endif
      @if (get_class($instance->subclass) === 'Jitterbug\Models\VideoInstance')
      @if ($instance->subclass->frame_size)
      <div class="row">
        <div class="col-sm-4 detail-label">
          Frame Size
        </div>
        <div class="col-sm-8 detail-value">
          {{$instance->subclass->frame_size}}
        </div>
      </div>
      @endif
      @if ($instance->subclass->aspect_ratio)
      <div class="row">
        <div class="col-sm-4 detail-label">
          Aspect Ratio
        </div>
        <div class="col-sm-8 detail-value">
          {{$instance->subclass->aspect_ratio}}
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
          {{$instance->createdOnDisplay}}
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4 detail-label">
          Updated On
        </div>
        <div class="col-sm-8 detail-value">
          {{$instance->updatedOnDisplay}}
        </div>
      </div>
    </div>
  </div>

  @include('shared._revisions', ['revisionable' => $instance])

  <div class="row">
    <div class="col-sm-12">
      <hr class="after" />
    </div>
  </div>
  <div class="row last">
    <div class="col-sm-12 actions">
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('instances.edit', $instance->id) }}" style="margin-right: .3rem;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
      <a class="btn btn-sm btn-secondary" role="button" href="{{ route('transfers.create', array('instanceId' => $instance->id)) }}"><i class="fa fa-plus" aria-hidden="true"></i> Add Transfer</a>
      <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target=".confirm-delete-modal" style="outline: none; float: right;"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></button>

      {{ html()->form('DELETE', route('instances.destroy', [$instance->id]))->style('display: inline;')->open() }}
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
              @if (count($instance->cuts) > 0 && count($instance->transfers) > 0)
                This preservation instance has related transfers and cuts.
              @elseif (count($instance->cuts) > 0 && count($instance->transfers) === 0)
                This preservation instance has related cuts.
              @elseif (count($instance->cuts) === 0 && count($instance->transfers) > 0)
                This preservation instance has related transfers.
              @endif
              Do you want to delete just this instance, or do you want to delete this preservation instance <strong>and all</strong> associated records? This cannot be undone.
            </div>
            <div class="modal-footer">
              <button name="deleteCommand" value="all" type="submit" class="btn btn-sm btn-danger" style="outline: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Delete All</button>
              <button name="deleteCommand" value="instance" type="submit" class="btn btn-sm btn-warning" style="outline: none;"><i class="fa fa-trash" aria-hidden="true"></i> Delete Preservation Instance Only</button>
            </div>

          </div>
        </div>
      </div>
      {{ html()->form()->close() }}

    </div>
  </div>

  @include('instances._related')

</div>
@stop