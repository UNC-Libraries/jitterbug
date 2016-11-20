@extends('layouts.master', ['title' => 'Dashboard', 'section' => 'dashboard'])

@section('content')
<div id="dashboard">
  <div class="row">
    <div class="col-xs-12">
      <h6>Overview</h6>
    </div>
  </div>
  <div class="row overview">
    <div class="col-xs-12">
      <div class="row">
        <div class="col-xs-4 centered">
          <h1>104,873</h1>
          <p>Audio Visual Items</p>
        </div>
        <div class="col-xs-4 centered">
          <h1>26,935</h1>
          <p>Preservation Masters</p>
        </div>
        <div class="col-xs-4 centered">
          <h1>58,102</h1>
          <p>Transfers</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-6">
      <h6>Recent Activity</h6>
      <div class="dashboard-module">
        <div class="recent-activity-module">
          <div class="recent-activity">
            <ol>
              <li role="button" data-object-type="item" data-object-id="12002"><span class="user">Andrew Shirk</span> <span class="action">updated</span> the <span class="field">recording location</span> of <span class="object-type">audio item</span> <span class="object-id">FT-3992</span> - <span class="timestamp">5 minutes ago</span></li>
              <li role="button"><span class="user">Andrew Shirk</span> <span class="action">updated</span> the <span class="field">collection</span> of <span class="object-type">audio item</span> <span class="object-id">FT-3992</span> - <span class="timestamp">5 minutes ago</span></li>
              <li role="button"><span class="user">Erica Titkemeyer</span> <span class="action">created</span> <span class="object-type">video item</span> <span class="object-id">VT-10094</span> - <span class="timestamp">20 minutes ago</span></li>
              <li role="button"><span class="user">Erica Titkemeyer</span> <span class="action">created</span> <span class="object-type">video item</span> <span class="object-id">VT-10095</span> - <span class="timestamp">25 minutes ago</span></li>
              <li role="button"><span class="user">John Loy</span> <span class="action">created</span> a <span class="object-type">video transfer</span> for item <span class="object-id">BC-4959</span> - <span class="timestamp">1 day ago</span></li>

              <li role="button"><span class="user">Andrew Shirk</span> <span class="action">updated</span> the <span class="field">recording location</span> of <span class="object-type">audio item</span> <span class="object-id">FT-3992</span> - <span class="timestamp">1 day ago</span></li>
              <li role="button"><span class="user">Andrew Shirk</span> <span class="action">updated</span> the <span class="field">collection</span> of <span class="object-type">audio item</span> <span class="object-id">FT-3992</span> - <span class="timestamp">1 day ago</span></li>
              <li role="button"><span class="user">Erica Titkemeyer</span> <span class="action">created</span> <span class="object-type">video item</span> <span class="object-id">VT-10094</span> - <span class="timestamp">2 days ago</span></li>
              <li role="button"><span class="user">Erica Titkemeyer</span> <span class="action">created</span> <span class="object-type">video item</span> <span class="object-id">VT-10095</span> - <span class="timestamp">2 days ago</span></li>
              <li role="button"><span class="user">John Loy</span> <span class="action">created</span> a <span class="object-type">video transfer</span> for item <span class="object-id">BC-4959</span> - <span class="timestamp">3 days ago</span></li>

              <li role="button"><span class="user">Andrew Shirk</span> <span class="action">updated</span> the <span class="field">recording location</span> of <span class="object-type">audio item</span> <span class="object-id">FT-3992</span> - <span class="timestamp">5 minutes ago</span></li>
              <li role="button"><span class="user">Andrew Shirk</span> <span class="action">updated</span> the <span class="field">collection</span> of <span class="object-type">audio item</span> <span class="object-id">FT-3992</span> - <span class="timestamp">5 minutes ago</span></li>
              <li role="button"><span class="user">Erica Titkemeyer</span> <span class="action">created</span> <span class="object-type">video item</span> <span class="object-id">VT-10094</span> - <span class="timestamp">20 minutes ago</span></li>
              <li role="button"><span class="user">Erica Titkemeyer</span> <span class="action">created</span> <span class="object-type">video item</span> <span class="object-id">VT-10095</span> - <span class="timestamp">25 minutes ago</span></li>
              <li role="button"><span class="user">John Loy</span> <span class="action">created</span> a <span class="object-type">video transfer</span> for item <span class="object-id">BC-4959</span> - <span class="timestamp">1 day ago</span></li>
              <li role="button"><span class="user">Andrew Shirk</span> <span class="action">updated</span> the <span class="field">recording location</span> of <span class="object-type">audio item</span> <span class="object-id">FT-3992</span> - <span class="timestamp">1 day ago</span></li>
              <li role="button"><span class="user">Andrew Shirk</span> <span class="action">updated</span> the <span class="field">collection</span> of <span class="object-type">audio item</span> <span class="object-id">FT-3992</span> - <span class="timestamp">1 day ago</span></li>
              <li role="button"><span class="user">Erica Titkemeyer</span> <span class="action">created</span> <span class="object-type">video item</span> <span class="object-id">VT-10094</span> - <span class="timestamp">2 days ago</span></li>
              <li role="button"><span class="user">Erica Titkemeyer</span> <span class="action">created</span> <span class="object-type">video item</span> <span class="object-id">VT-10095</span> - <span class="timestamp">2 days ago</span></li>
              <li role="button"><span class="user">John Loy</span> <span class="action">created</span> a <span class="object-type">video transfer</span> for item <span class="object-id">BC-4959</span> - <span class="timestamp">3 days ago</span></li>

            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-6">
      <h6>Marks</h6>
      <div class="dashboard-module">
        <div class="marks-module">
          <div class="marks-controls">
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-sm btn-secondary active">
                <input type="radio" name="options" id="option1" autocomplete="off"><i class="fa fa-bookmark" aria-hidden="true"></i>
              </label>
              <label class="btn btn-sm btn-secondary">
                <input type="radio" name="options" id="option2" autocomplete="off"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i>
              </label>
              <label class="btn btn-sm btn-secondary">
                <input type="radio" name="options" id="option3" autocomplete="off"><i class="fa fa-database fa-fw" aria-hidden="true"></i>
              </label>
              <label class="btn btn-sm btn-secondary">
                <input type="radio" name="options" id="option3" autocomplete="off"><i class="fa fa-exchange fa-fw" aria-hidden="true"></i>
              </label>
            </div>

            <div class="btn-group" style="margin-top: .3rem; float: right;">
              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" data-toggle="dropdown" aria-hidden="true"></i>&nbsp; Andrew Shirk</button>
              <div id="user-dropdown" class="dropdown-menu dropdown-menu-right dropdown-scrollable">
                <a class="dropdown-item" href="#">Erica Titkemeyer</a>
                <a class="dropdown-item" href="#">John Loy</a>
                <a class="dropdown-item" href="#">Brian Paulson</a>
              </div>
            </div>

            {{--
            <div style="margin-top: .3rem; float: right; width: 200px;">
              <select class="form-control form-control-sm">
                <option value="volvo">Andrew Shirk</option>
                <option value="saab">Erica Titkemeyer</option>
                <option value="mercedes">John Loy</option>
                <option value="audi">Brian Paulson</option>
              </select>
            </div>
            --}}
          </div>
          <div class="marks">
            <ol>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10478 - <span class="timestamp">10 days ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10479 - <span class="timestamp">10 days ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10480 - <span class="timestamp">10 days ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10481 - <span class="timestamp">10 days ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Master 27021 - <span class="timestamp">11 days ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Master 27021 - <span class="timestamp">11 days ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Transfer 58732 - <span class="timestamp">1 week ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Transfer 58733 - <span class="timestamp">1 week ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>

              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10478 - <span class="timestamp">1 month ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10479 - <span class="timestamp">1 month ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10480 - <span class="timestamp">1 month ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10481 - <span class="timestamp">1 month ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Master 27021 - <span class="timestamp">2 months ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Master 27021 - <span class="timestamp">2 months ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Transfer 58732 - <span class="timestamp">2 months ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Transfer 58733 - <span class="timestamp">2 months ago</span><a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop