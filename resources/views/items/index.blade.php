@extends('layouts.master', ['title' => 'Audio Visual Items', 'section' => 'items'])

@section('content')
<div class="row">
  <div id="filter-panel" class="col-xs-3 panel">
    @include('shared._filter-list', ['name' => 'type', 'filters' => $types])
    @include('shared._filter-list', ['name' => 'collection', 'filters' => $collections, 'style' => 'height: 268px;'])
    @include('shared._filter-list', ['name' => 'format', 'filters' => $formats, 'style' => 'height: 250px;'])
  </div>
  <div id="data-panel" class="col-xs-9 panel">
    <div class="top-controls">
      <div style="float: left;">
        <a id="items-new" class="btn btn-sm btn-secondary" style="margin-right: 5px;" href="{{ route('items.create') }}" role="button"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
        <div class="btn-group">
          <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cubes" data-toggle="dropdown" aria-hidden="true"></i> Batch</button>
          <div id="items-batch-dropdown" class="dropdown-menu">
            <a id="items-batch-edit" class="dropdown-item" href="#" data-max-edit-limit="{{$maxEditLimit}}">Edit</a>
            <a id="items-batch-export" class="dropdown-item" href="#">Export</a>
            <a id="items-batch-mark" class="dropdown-item" href="#">Mark</a>
            <a id="items-batch-unmark" class="dropdown-item" href="#">Unmark</a>
            <a id="items-batch-delete" class="dropdown-item" href="#">Delete</a>
            <div class="dropdown-divider"></div>
            <a id="items-batch-items-import" class="dropdown-item" href="#">Items Import</a>
          </div>
        </div>
      </div>

      @include('shared._data-export-modal', ['route' => 'items.batch.export.build', 'title' => 'Export Audio Visual Items'])

      {!! Form::open(array('route' => array('items.batch.destroy'), 'method' => 'delete', 'id' => 'batch-delete-form', 'style' => 'display: inline;')) !!}
      <div id="confirm-batch-delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmDelete" aria-hidden="true">
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
              You are about to delete multiple items at once. You may choose to delete only the selected items or delete the selected items and all associated preservation masters and transfers. This cannot be undone.
            </div>
            <div class="modal-footer">
              {!! Form::hidden('ids') !!}
              {!! Form::hidden('deleteCommand') !!}
              <button name="deleteCommand" value="all" type="submit" class="btn btn-sm btn-danger" style="outline: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Delete All</button>
              <button name="deleteCommand" value="item" type="submit" class="btn btn-sm btn-warning" style="outline: none;"><i class="fa fa-trash" aria-hidden="true"></i> Delete Items Only</button>
            </div>

          </div>
        </div>
      </div>
      {!! Form::close() !!}

      @include('shared._data-import-modal', ['section' => 'items', 'type' => 'items'])

      <div class="search-container">
        <div class="input-group">
          <span class="input-group-addon search-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
          <input id="search" class="form-control form-control-sm" type="text" placeholder="Search" autocomplete="off">
          <span class="input-group-addon clear-addon"><a href="#" class="clear-search"><i class="fa fa-times-circle" aria-hidden="true" style="display: none;"></i></a></span>
        </div>
      </div>
    </div>
    <div id="data-container">
      <table id="data" class="table"></table>
    </div>
  </div>
</div>
@stop