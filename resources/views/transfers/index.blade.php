@extends('layouts.master', ['title' => 'Transfers', 'section' => 'transfers'])

@section('content')
<div class="row">
  <div id="filter-panel" class="col-md-3 panel">
    @include('shared._filter-list', ['name' => 'type', 'filters' => $types])
    @include('shared._filter-list', ['name' => 'collection', 'filters' => $collections, 'style' => 'height: 268px;'])
    @include('shared._filter-list', ['name' => 'format', 'filters' => $formats, 'style' => 'height: 250px;'])
  </div>
  <div id="data-panel" class="col-md-9 panel">
    <div class="top-controls">
      <div style="float: left;">
        <a id="transfers-new" class="btn btn-sm btn-secondary" style="margin-right: 5px;" href="{{ route('transfers.create') }}" role="button"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
        <div class="btn-group">
          <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cubes" data-toggle="dropdown" aria-hidden="true"></i> Batch</button>
          <div class="dropdown-menu">
            <a id="transfers-batch-edit" class="dropdown-item" href="#">Edit</a>
            <a id="transfers-batch-export" class="dropdown-item" href="#">Export</a>
            <a id="transfers-batch-delete" class="dropdown-item" href="#">Delete</a>
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