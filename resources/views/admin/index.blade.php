@extends('layouts.main', ['title' => 'Admin', 'section' => 'admin'])

@section('content')
<div class="row">
  <div id="table-panel" class="col-sm-3 panel">
    <h6>User Administration</h6>
    <ul class="table-list">
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="users">
            Users
          </label>
        </div>
      </li>
    </ul>
    <h6>Reference Tables</h6>
    <ul class="table-list">
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="collections">
            Collections
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="collection_types">
            Collection Types
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="departments">
            Departments
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="formats">
            Formats
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="playback_machines">
            Playback Machines
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="pm_speeds">
            PM Speeds
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="prefixes">
            Prefixes
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="projects">
            Projects
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="reproduction_machines">
            Reproduction Machines
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="sampling_rates">
            Sampling Rates
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="tape_brands">
            Tape Brands
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="vendors">
            Vendors
          </label>
        </div>
      </li>
    </ul>
  </div>
  <div id="record-panel" class="col-sm-9 panel">
    <div id="record-container">
      <div id="table-container">
        {{-- Need this empty table here for initial rendering of the page to avoid a twitch --}}
        <table style="margin-top: .75rem;" class="table table-sm table-hover"></table>
      </div>
    </div>
  </div>
</div>
@stop