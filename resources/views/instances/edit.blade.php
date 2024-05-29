@extends('layouts.main', ['title' => 'Edit Preservation Instance', 'section' => 'instances'])

@section('content')
<div id="detail">
  <div class="row">
    <div class="col-xs-12">
      {!! Breadcrumbs::render('instances.edit', $instance) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      @if ($instance->batch())
        <h6>{{$instance->type}} Preservation Instance Details (editing {{$instance->count()}} instances)</h6>
      @else
        <h6>{{$instance->type}} Preservation Instance Details</h6>
      @endif
    </div>
  </div>

  @if ($instance->batch())
    {{ html()->modelForm($instance, 'PUT', route('instances.batch.update', ))->open() }}
    {{ html()->hidden('ids') }}
    {{ html()->hidden('subclass_type') }}
  @else
    {{ html()->modelForm($instance, 'PUT', route('instances.update', [$instance->id]))->open() }}
    {{ html()->hidden('id') }}
    {{ html()->hidden('subclass_type') }}
    {{ html()->hidden('subclass_id') }}
  @endif

  <div class="row first detail-container">
    <div class="col-xs-6">
      @include('instances._form-common')
    </div>
    <div class="col-xs-6">
      {{-- Begin subclass fields --}}
      @if (get_class($instance->subclass) === 'Jitterbug\Models\AudioInstance')
        @include('instances._form-audio')
      @endif
      @if (get_class($instance->subclass) === 'Jitterbug\Models\FilmInstance')
        @include('instances._form-film')
      @endif
      @if (get_class($instance->subclass) === 'Jitterbug\Models\VideoInstance')
        @include('instances._form-video')
      @endif
      {{-- End subclass fields --}}
      @if (!$instance->batch())
      <div class="row">
        <div class="col-xs-4 detail-label">
          Created On
        </div>
        <div class="col-xs-8 detail-value">
          {{$instance->createdOnDisplay}}
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 detail-label">
          Updated On
        </div>
        <div class="col-xs-8 detail-value">
          {{$instance->updatedOnDisplay}}
        </div>
      </div>
      @endif
    </div>
  </div>
  
  @if (!$instance->batch())
    @include('shared._revisions', ['revisionable' => $instance])
  @endif

  <div class="row">
    <div class="col-xs-12">
      <hr class="after"/>
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-12 actions">
      <button class="btn btn-sm btn-primary" type="submit" style="outline: none;"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
      @if (!$instance->batch())
        <a class="" href="{{ route('instances.show', $instance->id) }}">or Cancel</a>
      @else
        <a class="" href="{{ route('instances.index') }}">or Cancel</a>
      @endif
    </div>
  </div>

  {{ html()->closeModelForm() }}

  @if (!$instance->batch())
    @include('instances._related')
  @endif

</div>
@stop