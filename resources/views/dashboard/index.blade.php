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
          <div id="item-chart" class="chart" data-counts="{{$itemCounts->counts()}}"></div>
          <h1>{{$itemCounts->total()}}</h1>
          <p>Audio Visual Items</p>
        </div>
        <div class="col-xs-4 centered">
          <div id="master-chart" class="chart" data-counts="{{$masterCounts->counts()}}"></div>
          <h1>{{$masterCounts->total()}}</h1>
          <p>Preservation Masters</p>
        </div>
        <div class="col-xs-4 centered">
          <div id="transfer-chart" class="chart" data-counts="{{$transferCounts->counts()}}"></div>
          <h1>{{$transferCounts->total()}}</h1>
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
              @foreach($activities as $activity)

              @if ($activity->batch)
              <li><span class="user">{{$activity->user}}</span> <span class="action">{{$activity->action}}</span> {{$activity->objectArticle()}} <span class="object">{{$activity->object()}}</span> - <span class="timestamp">{{$activity->timestamp}}</span></li>
              @endif

              @if ($activity->field === null && $activity->numFields === null && !$activity->batch)
              <li @if ($activity->objectExists()) role="button" data-object-type="{{$activity->objectType()}}" data-object-id="{{$activity->objectId()}}" @endif><span class="user">{{$activity->user}}</span> <span class="action">{{$activity->action}}</span> {{$activity->objectArticle()}} <span class="object">{{$activity->object()}}</span> @if (!$activity->objectIsItem()) for {{$activity->itemType}} item {{$activity->itemCallNumber}} @else {{$activity->itemCallNumber}} @endif - <span class="timestamp">{{$activity->timestamp}}</span></li>
              @endif

              @if ($activity->field !== null)
              <li @if ($activity->objectExists()) role="button" data-object-type="{{$activity->objectType()}}" data-object-id="{{$activity->objectId()}}" @endif><span class="user">{{$activity->user}}</span> <span class="action">{{$activity->action}}</span> the <span class="field">{{$activity->field}}</span> field of {{$activity->objectArticle()}} <span class="object">{{$activity->object()}}</span> @if (!$activity->objectIsItem()) for {{$activity->itemType}} item {{$activity->itemCallNumber}} @else {{$activity->itemCallNumber}} @endif - <span class="timestamp">{{$activity->timestamp}}</span></li>
              @endif

              @if ($activity->numFields !== null)
              <li @if ($activity->objectExists()) role="button" data-object-type="{{$activity->objectType()}}" data-object-id="{{$activity->objectId()}}" @endif><span class="user">{{$activity->user}}</span> <span class="action">{{$activity->action}}</span> {{$activity->numFields}} fields of {{$activity->objectArticle()}} <span class="object">{{$activity->object()}}</span> @if (!$activity->objectIsItem()) for {{$activity->itemType}} item {{$activity->itemCallNumber}} @else {{$activity->itemCallNumber}} @endif - <span class="timestamp">{{$activity->timestamp}}</span></li>
              @endif

              @endforeach
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
              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" data-toggle="dropdown" aria-hidden="true"></i>&nbsp; Erica Titkeme...</button>
              <div id="user-dropdown" class="dropdown-menu dropdown-menu-right dropdown-scrollable">
                <a class="dropdown-item" href="#">Erica Titkemeyer</a>
                <a class="dropdown-item" href="#">John Loy</a>
                <a class="dropdown-item" href="#">Brian Paulson</a>
                <a class="dropdown-item" href="#">Gerals Schoenherr</a>
              </div>
            </div>

{{--
            <div style="margin-top: .3rem; float: right; width: 200px;">
              <select class="form-control form-control-sm">
                <option value="volvo">Andrew Shirk</option>
                <option value="volvo">Mr. Longname Johnson III of Three</option>
                <option value="saab">Erica Titkemeyer</option>
                <option value="mercedes">John Loy</option>
                <option value="audi">Brian Paulson</option>
              </select>
            </div>
--}}
          </div>
      
          <div class="marks">
            <ol>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10478 - <span class="timestamp">10 days ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10479 - <span class="timestamp">10 days ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10480 - <span class="timestamp">10 days ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10481 - <span class="timestamp">10 days ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Master 27021 - <span class="timestamp">11 days ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Master 27021 - <span class="timestamp">11 days ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Transfer 58732 - <span class="timestamp">1 week ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Transfer 58733 - <span class="timestamp">1 week ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>

              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10478 - <span class="timestamp">1 month ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10479 - <span class="timestamp">1 month ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10480 - <span class="timestamp">1 month ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Item FS-10481 - <span class="timestamp">1 month ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Master 27021 - <span class="timestamp">2 months ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Master 27021 - <span class="timestamp">2 months ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Transfer 58732 - <span class="timestamp">2 months ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
              <li role="button" data-object-type="item" data-object-id="12002">Audio Transfer 58733 - <span class="timestamp">2 months ago</span><a href="#" role="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></li>
            </ol>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@stop