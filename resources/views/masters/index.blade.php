@extends('layouts.master', ['title' => 'Preservation Masters', 'section' => 'masters'])

@section('content')
<div class="row">
  <div id="filter-panel" class="col-md-3 panel">
    @include('shared._filter-list', ['name' => 'type', 'filters' => $types])
    @include('shared._filter-list', ['name' => 'collection', 'filters' => $collections, 'style' => 'height: 185px;'])
    @include('shared._filter-list', ['name' => 'format', 'filters' => $formats, 'style' => 'height: 165px;'])
    @include('shared._filter-list', ['name' => 'department', 'filters' => $departments, 'style' => 'height: 135px;'])
  </div>
  <div id="data-panel" class="col-md-9 panel">
    <div class="top-controls">
      <div style="float: left;">
        <a id="masters-new" class="btn btn-sm btn-secondary" style="margin-right: 5px;" href="{{ route('masters.create') }}" role="button"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
        <div class="btn-group">
          <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cubes" data-toggle="dropdown" aria-hidden="true"></i> Batch</button>
          <div class="dropdown-menu">
            <a id="masters-batch-edit" class="dropdown-item" href="#">Edit</a>
            <a id="masters-batch-export" class="dropdown-item" href="#">Export</a>
            <a id="masters-batch-delete" class="dropdown-item" href="#">Delete</a>
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