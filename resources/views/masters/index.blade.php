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

      {!! Form::open(array('route' => array('masters.batch.destroy'), 'method' => 'delete', 'id' => 'batch-delete-form', 'style' => 'display: inline;')) !!}
      <div class="modal fade confirm-batch-delete-modal" tabindex="-1" role="dialog" aria-labelledby="confirmDelete" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 id="confirmDelete" class="modal-title">Confirm Delete</h4>
            </div>
            <div class="modal-body">
              <strong>Be careful!</strong>
              You are about to delete multiple masters at once. You may choose to delete only the selected masters or delete the selected masters and all associated cuts and transfers. This cannot be undone.
            </div>
            <div class="modal-footer">
              {!! Form::hidden('ids') !!}
              <button name="deleteCommand" value="master" type="submit" class="btn btn-sm btn-warning" style="outline: none;"><i class="fa fa-trash" aria-hidden="true"></i> Delete Masters Only</button>
              <button name="deleteCommand" value="all" type="submit" class="btn btn-sm btn-danger" style="outline: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Delete All</button>
            </div>

          </div>
        </div>
      </div>
      {!! Form::close() !!}

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