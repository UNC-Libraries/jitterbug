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
            <div class="dropdown-divider"></div>
            <a id="transfers-batch-audio-import" class="dropdown-item" href="#">Audio Import</a>
            <a id="transfers-batch-vendor-import" class="dropdown-item" href="#">Vendor Import</a>
          </div>
        </div>
      </div>

      @include('shared._data-export-modal', ['route' => 'transfers.batch.export.build', 'title' => 'Export Transfers'])

      {!! Form::open(array('route' => array('transfers.batch.destroy'), 'method' => 'delete', 'id' => 'batch-delete-form', 'style' => 'display: inline;')) !!}
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
              You are about to delete multiple transfers at once. This will also delete any associated cuts. This cannot be undone.
            </div>
            <div class="modal-footer">
              {!! Form::hidden('ids') !!}
              <button name="deleteCommand" value="all" type="submit" class="btn btn-sm btn-danger" style="outline: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Delete Transfers</button>
            </div>

          </div>
        </div>
      </div>
      {!! Form::close() !!}

      <div id="audio-import-modal" class="modal fade" tabindex="-1" role="dialog">
        <div id="audio-import-dialog" class="modal-dialog modal-sm">
          <div id="audio-import-dialog-content" class="modal-content">

            <div id="audio-import-step-1">
              {!! Form::open(array('route' => 'transfers.audio.import.upload', 'files' => true, 'id' => 'audio-upload-form')) !!}
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Audio Import - Step 1 of 3</h4>
              </div>
              <div class="modal-body import-modal-body">
                <div class="file-select-label">File to Import (.csv, UTF-8, quoted text)</div>
                <div class="input-group">
                  <span class="input-group-btn">
                    <label class="btn btn-sm btn-secondary btn-file-select">Browse<input id="audio-import-file" name="audio-import-file" type="file" style="display: none;">
                    </label>
                  </span>
                  <input id="audio-import-filename" type="text" class="form-control form-control-sm" placeholder="No file selected" style="background-color: #fff" readonly>
                </div>
                <div id="audio-upload-form-error" class="text-danger upload-form-error"></div>
              </div>
              <div class="modal-footer">
                <button name="upload" type="submit" class="btn btn-sm btn-secondary" style="outline: none;"><i class="fa fa-upload" aria-hidden="true"></i> Upload and Continue</button>
                <i id="audio-upload-spinner" class="fa fa-spinner fa-pulse import-spinner" style="display: none;"></i>
              </div>
              {!! Form::close() !!}
            </div>

            <div id="audio-import-step-2" style="display: none;">
              {!! Form::open(array('route' => 'transfers.audio.import.execute', 'id' => 'audio-import-form')) !!}
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Audio Import - Step 2 of 3</h4>
              </div>
              <div class="modal-body import-modal-body">
                <div id="audio-upload-data-container"></div>
              </div>
              <div class="modal-footer">
                <div class="success-actions">
                  <button name="import" type="submit" class="btn btn-sm btn-primary" style="outline: none; margin-right: .5rem"><i class="fa fa-bolt" aria-hidden="true"></i> Proceed with Import</button><a class="reset" href="#">or Start Over</a><i id="audio-import-spinner" class="fa fa-spinner fa-pulse import-spinner" style="display: none;"></i>
                </div>
                <div class="failure-actions" style="display: none;">
                  <button type="submit" class="btn btn-sm btn-secondary reset" style="outline: none;"> Start Over</button>
                </div>
              </div>
              {!! Form::close() !!}
            </div>

            <div id="audio-import-step-3" style="display: none;">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Audio Import - Step 3 of 3</h4>
              </div>
              <div class="modal-body import-modal-body">
                <div id="audio-import-result-container"></div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-secondary reset" style="outline: none;"> Start Over</button>
              </div>
            </div>

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