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

              {{-- Batch operations --}}
              @if ($activity->batch)
              <li><span class="user">{{$activity->user}}</span> <span class="action">{{$activity->action}}</span> {{$activity->objectArticle()}} <span class="object">{{$activity->object()}}</span> - <span class="timestamp">{{$activity->timeAgo}}</span></li>
              @endif

              {{-- A create or delete operation --}}
              @if ($activity->field === null && $activity->numFields === null && !$activity->batch)
              <li @if ($activity->objectExists()) role="button" data-object-type="{{$activity->objectType()}}" data-object-id="{{$activity->objectId()}}" @endif><span class="user">{{$activity->user}}</span> <span class="action">{{$activity->action}}</span> {{$activity->objectArticle()}} <span class="object">{{$activity->object()}}</span> @if (!$activity->objectIsItem()) for {{$activity->itemType}} item {{$activity->itemCallNumber}} @else {{$activity->itemCallNumber}} @endif - <span class="timestamp">{{$activity->timeAgo}}</span></li>
              @endif

              {{-- An update operation where there have been no more than a few fields updated on the object --}}
              @if ($activity->field !== null)
              <li @if ($activity->objectExists()) role="button" data-object-type="{{$activity->objectType()}}" data-object-id="{{$activity->objectId()}}" @endif><span class="user">{{$activity->user}}</span> <span class="action">{{$activity->action}}</span> the <span class="field">{{$activity->field}}</span> field of {{$activity->objectArticle()}} <span class="object">{{$activity->object()}}</span> @if (!$activity->objectIsItem()) for {{$activity->itemType}} item {{$activity->itemCallNumber}} @else {{$activity->itemCallNumber}} @endif - <span class="timestamp">{{$activity->timeAgo}}</span></li>
              @endif

              {{-- An update operation where there have been many fields updated on the object --}}
              @if ($activity->numFields !== null)
              <li @if ($activity->objectExists()) role="button" data-object-type="{{$activity->objectType()}}" data-object-id="{{$activity->objectId()}}" @endif><span class="user">{{$activity->user}}</span> <span class="action">{{$activity->action}}</span> {{$activity->numFields}} fields of {{$activity->objectArticle()}} <span class="object">{{$activity->object()}}</span> @if (!$activity->objectIsItem()) for {{$activity->itemType}} item {{$activity->itemCallNumber}} @else {{$activity->itemCallNumber}} @endif - <span class="timestamp">{{$activity->timeAgo}}</span></li>
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
            <div id="marks-filters" class="btn-group" data-toggle="buttons">
              <label class="btn btn-sm btn-secondary" data-filter='all' title="Show all marks">
                <input type="radio" name="marks-filter" value="all" checked="checked"><i class="fa fa-bookmark" aria-hidden="true"></i>
              </label>
              <label class="btn btn-sm btn-secondary" data-filter='item' title="Show item marks">
                <input type="radio" name="marks-filter" value="item"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i>
              </label>
              <label class="btn btn-sm btn-secondary" data-filter='master' title="Show master marks">
                <input type="radio" name="marks-filter" value="master"><i class="fa fa-database fa-fw" aria-hidden="true"></i>
              </label>
              <label class="btn btn-sm btn-secondary" data-filter='transfer' title="Show transfer marks">
                <input type="radio" name="marks-filter" value="transfer"><i class="fa fa-exchange fa-fw" aria-hidden="true"></i>
              </label>
            </div>

            <div class="btn-group" style="margin-top: .3rem; float: right;">
              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" data-toggle="dropdown" aria-hidden="true"></i>&nbsp; <span id="selected-marks-user">{{str_limit($currentUser->fullName(), 13)}}</span></button>
              <div id="user-dropdown" class="dropdown-menu dropdown-menu-right dropdown-scrollable">
                @foreach ($marksUsers as $user)
                <a class="dropdown-item marks-user @if ($currentUser->id === $user->id) current-user @endif" href="#" data-user-id="{{$user->id}}">{{$user->fullName()}}</a>
                @endforeach
              </div>
            </div>
          </div>
      
          <div class="marks">
            <ol>
              <li class="no-marks"></li>
            </ol>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@stop