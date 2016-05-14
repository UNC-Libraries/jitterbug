@extends('layouts.master', ['title' => 'Audio Item'])

@section('content')
<div class="detail">
  <div class="row">
    <div class="col-xs-12 back">
      <a href="#"><i class="fa fa-caret-left" aria-hidden="true"></i> Items</a>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>Audio Item</h6>
    </div>
  </div>
  <div class="row first">
    <div class="col-xs-3 detail-label">
      Call Number
    </div>
    <div class="col-xs-9 detail-value">
      FS-1102
    </div>
  </div>
  <div class="row">
    <div class="col-xs-3 detail-label">
      Container Note
    </div>
    <div class="col-xs-9 detail-value">
      Oral History Interview:  Theresa Conley
    </div>
  </div>
  <div class="row">
    <div class="col-xs-3 detail-label">
      Format
    </div>
    <div class="col-xs-9 detail-value">
      Audiocassette
    </div>
  </div>
  <div class="row">
    <div class="col-xs-3 detail-label">
      Collection
    </div>
    <div class="col-xs-9 detail-value">
      Alvic, Phillis
    </div>
  </div>
  <div class="row">
    <div class="col-xs-3 detail-label">
      Speed
    </div>
    <div class="col-xs-9 detail-value">
      1.875 ips
    </div>
  </div>
  <div class="row">
    <div class="col-xs-3 detail-label">
      Listening Copy
    </div>
    <div class="col-xs-9 detail-value">
      No
    </div>
  </div>
  <div class="row">
    <div class="col-xs-3 detail-label">
      Mono/Stereo
    </div>
    <div class="col-xs-9 detail-value">
      No
    </div>
  </div>
  <div class="row">
    <div class="col-xs-3 detail-label">
      Base
    </div>
    <div class="col-xs-9 detail-value">
      Plastic/open reel
    </div>
  </div>
  <div class="row">
    <div class="col-xs-3 detail-label">
      Created On
    </div>
    <div class="col-xs-9 detail-value">
      4/26/2016 by System
    </div>
  </div>
  <div class="row last">
    <div class="col-xs-3 detail-label">
      Updated On
    </div>
    <div class="col-xs-9 detail-value">
      5/15/2016 by John Loy
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>Preservation Masters</h6>
    </div>
  </div>
  <div class="row first last">
    <div class="col-xs-12 col-fff">
      <table class="table table-sm table-hover">
        <thead>
          <tr>
            <th width="12%">#</th>
            <th width="20%">File Name</th>
            <th width="30%">File Location</th>
            <th width="15%">Department</th>
            <th width="16%">Duration</th>
            <th width="7%">Type</th>
          </tr>
        </thead>
        <tbody>
          <tr role="button" data-id="{{14365}}">
            <td>14365</td>
            <td></td>
            <td></td>
            <td>SFC</td>
            <td>45' 23"</td>
            <td>Audio</td>
          </tr> 
          <tr role="button" data-id="{{14366}}">
            <td>14366</td>
            <td></td>
            <td></td>
            <td>SFC</td>
            <td>9’ 19”</td>
            <td>Audio</td>
          </tr>                          
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>Cuts</h6>
    </div>
  </div>
  <div class="row first last">
    <div class="col-xs-12 col-fff">
      <table class="table table-sm table-hover">
        <thead>
          <tr>
            <th width="10%">PM #</th>
            <th width="15%">Cut Number</th>
            <th width="10%">Side</th>
            <th width="20%">Title</th>
            <th width="25%">Performer/Composer</th>
            <th width="20%">PM Start Time</th>
          </tr>
        </thead>
        <tbody>
          <tr role="button" data-id="{{14365}}">
            <td>14365</td>
            <td>1</td>
            <td></td>
            <td>SFC</td>
            <td>SFC</td>
            <td>45' 23"</td>
          </tr> 
          <tr role="button" data-id="{{14366}}">
            <td>14366</td>
            <td>2</td>
            <td></td>
            <td>SFC</td>
            <td>SFC</td>
            <td>9’ 19”</td>
          </tr>                          
        </tbody>
      </table>
    </div>
  </div>

</div>
@stop