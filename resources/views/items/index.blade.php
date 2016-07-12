@extends('layouts.master', ['title' => 'Audio Visual Items'])

@section('content')
<div class="row">
  <div id="filter-panel" class="col-md-3 panel">
    <h6>Type</h6>
    <ul id="type-filters" class="filter-list">
      <li>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="0">
            Any
          </label>

        </div>
      </li>
      @foreach ($types as $type)
      <li>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="{{ $type->id }}">
            {{ $type->name }}&nbsp;<span class="filter-count">({{ $type->count }})</span>
          </label>
        </div>
      </li>
      @endforeach
    </ul>

    <h6>Collection</h6>
    <ul id="collection-filters" class="filter-list" style="height: 268px; overflow-y: scroll; overflow-x: hidden;">
      <li>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="0">
            Any
          </label>
        </div>
      </li>
      @foreach ($collections as $collection)
      <li>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="{{ $collection->id }}">
            {{ $collection->name }}&nbsp;<span class="filter-count">({{ $collection->count }})</span>
          </label>
        </div>
      </li>
      @endforeach
    </ul>

    <h6>Format</h6>
    <ul id="format-filters" class="filter-list" style="height: 250px; overflow-y: scroll; overflow-x: hidden;">
      <li class="">
        <div class="checkbox">
          <label>
            <input type="checkbox" value="0">
            Any
          </label>
        </div>
      </li>
      @foreach ($formats as $format)
      <li>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="{{ $format->id }}">
            {{ $format->name }}&nbsp;<span class="filter-count">({{ $format->count }})</span>
          </label>
        </div>
      </li>
      @endforeach
    </ul>

  </div>
  <div id="data-panel" class="col-md-9 panel">
    <div class="top-controls">
      <div style="float: left;">
        <a id="items-new" class="btn btn-sm btn-secondary" style="margin-right: 5px;" href="{{ route('items.create') }}" role="button"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
        <div class="btn-group">
          <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cubes" data-toggle="dropdown" aria-hidden="true"></i> Batch</button>
          <div class="dropdown-menu">
            <a id="items-batch-edit" class="dropdown-item" href="#">Edit</a>
            <a id="items-batch-export" class="dropdown-item" href="#">Export</a>
            <a id="items-batch-delete" class="dropdown-item" href="#">Delete</a>
          </div>
        </div>
      </div>
      <div class="search-container">
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
          <input id="search" class="form-control form-control-sm" type="text" placeholder="Search" autocomplete="off">
        </div>
      </div>
    </div>
    <div id="data-container">
      <table id="data" class="table"></table>
    </div>
  </div>
</div>
@stop