@extends('layouts.main', ['title' => 'Format', 'section' => 'formats'])

@section('content')
  <div id="data-panel">
    <div class="row">
      <div class="col-sm-12 m-t-1">
        <span class="well-lg"><h5><b>{{$format->name}}</b> Format</h5></span>
      </div>
    </div>
    <div class="row last">
      <div class="col-sm-6 p-l-1 pull-left" style="width:50%">
        <div id="prefix-table" class="table-container dashboard-module" >
          <table class="table table-sm pull-left table-hover">
            <thead>
              <tr>
                <th width="30%">Prefixes</th>
                <th>Collection Type</th>
                <th width="5%"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($prefixes as $prefix)
                <tr data-format-id="{{$format->id}}" data-prefix-id="{{$prefix->id}}">
                  <td>{{$prefix->label}}</td>
                  <td>{{\Jitterbug\Models\CollectionType::formattedName($prefix->collectionType)}}</td>
                  <td><a href="#" role="button" class="delete prefix-{{$prefix->id}}" ><i class="fa fa-times" aria-hidden="true"></i></a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-sm-6 p-l-1 pull-right" style="width:40%">
        <div class="dashboard-module">
          <h6>Attach new prefixes</h6>
          <form class="form-inline" id="prefix-attach-form" data-format-id={{$format->id}}>
            {{ html()->multiselect('prefixes', $possiblePrefixes)->class('chosen-select')->data('placeholder', 'Choose one or more of the following:') }}
            <button id="prefix-attach" class="btn btn-sm btn-secondary popover-submit" type="submit" style="margin: 0.5em 0"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
@stop