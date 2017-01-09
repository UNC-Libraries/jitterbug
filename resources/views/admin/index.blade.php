@extends('layouts.master', ['title' => 'Admin', 'section' => 'admin'])

@section('content')
<div class="row">
  <div id="table-panel" class="col-xs-3 panel">
    <h6>User Administration</h6>
    <ul class="table-list">
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="users" checked="checked">
            Users
          </label>
        </div>
      </li>
    </ul>
    <h6>Reference Tables</h6>
    <ul class="table-list" style="height: 650px">
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
            <input type="radio" name="table" value="formats">
            Formats
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
            <input type="radio" name="table" value="vendors">
            Vendors
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
            <input type="radio" name="table" value="playback-machines">
            Playback Machines
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="reproduction-machines">
            Reproduction Machines
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="sampling-rates">
            Sampling Rates
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="pm-speeds">
            PM Speeds
          </label>
        </div>
      </li>
      <li>
        <div class="radio">
          <label>
            <input type="radio" name="table" value="tape-brands">
            Tape Brands
          </label>
        </div>
      </li>
    </ul>
  </div>
  <div id="record-panel" class="col-xs-9 panel">
    <div id="record-container">
      <table id="records" style="margin-top: 1rem;" class="table table-sm table-hover">
        <thead>
          <tr>
            <th width="7%">ID</th>
            <th width="20%">Username</th>
            <th width="20%">First Name</th>
            <th width="20%">Last Name</th>
            <th width="21%">Signed In</th>
            <th width="12%">Admin</th>
          </tr>
        </thead>
        <tbody>
          <tr role="button" data-id="2">
            <td>2</td>
            <td>ashirk</td>
            <td>Andrew</td>
            <td>Shirk</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="ashirk" type="checkbox" checked="checked"></td>
          </tr>
          <tr role="button" data-id="3">
            <td>3</td>
            <td>alliekw</td>
            <td>Allison</td>
            <td>Whalen</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="alliekw" type="checkbox"></td>
          </tr>
          <tr role="button" data-id="4">
            <td>4</td>
            <td>annewell</td>
            <td>Anne</td>
            <td>Wells</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="annewell" type="checkbox"></td>
          </tr>
          <tr role="button" data-id="5">
            <td>5</td>
            <td>bpaulson</td>
            <td>Brian</td>
            <td>Paulson</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="bpaulson" type="checkbox"></td>
          </tr>
          <tr role="button" data-id="6">
            <td>6</td>
            <td>ebrassell</td>
            <td>Emily</td>
            <td>Brassell</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="ebrassell" type="checkbox"></td>
          </tr>
          <tr role="button" data-id="7">
            <td>7</td>
            <td>etitkem</td>
            <td>Erica</td>
            <td>Titkemeyer</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="etitkem" type="checkbox" checked="checked"></td>
          </tr>
          <tr role="button" data-id="8">
            <td>8</td>
            <td>harmana</td>
            <td>Asia</td>
            <td>Harman</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="harmana" type="checkbox"></td>
          </tr>
          <tr role="button" data-id="9">
            <td>9</td>
            <td>jloy</td>
            <td>John</td>
            <td>Loy</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="jloy" type="checkbox"></td>
          </tr>
          <tr role="button" data-id="10">
            <td>10</td>
            <td>jparis</td>
            <td>Jan</td>
            <td>Paris</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="jparis" type="checkbox"></td>
          </tr>
          <tr role="button" data-id="11">
            <td>11</td>
            <td>sanmarrb</td>
            <td>Brad</td>
            <td>San Martin</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="sanmarrb" type="checkbox"></td>
          </tr>
          <tr role="button" data-id="12">
            <td>12</td>
            <td>segedy</td>
            <td>Steve</td>
            <td>Segedy</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="segedy" type="checkbox"></td>
          </tr>
          <tr role="button" data-id="13">
            <td>13</td>
            <td>smithers</td>
            <td>Aaron</td>
            <td>Smithers</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="smithers" type="checkbox"></td>
          </tr>
          <tr role="button" data-id="14">
            <td>14</td>
            <td>smweiss</td>
            <td>Steven</td>
            <td>Weiss</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="smweiss" type="checkbox"></td>
          </tr>
          <tr role="button" data-id="15">
            <td>15</td>
            <td>tshearer</td>
            <td>Timothy</td>
            <td>Shearer</td>
            <td>2016-12-05 16:59:18</td>
            <td><input data-username="tshearer" type="checkbox"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@stop