@extends('layouts.master', ['title' => 'Format', 'section' => 'formats'])

@section('content')
  <div id="detail">
    <div class="row">
      <div class="col-xs-12 m-t-1">
        <span class="well-lg"><h6>{{$format->name}} Format</h6></span>
      </div>
    </div>
    <div class="row last">
      <div class="col-xs-6 p-l-1 pull-left" style="width:50%">
        <div id="table-container dashboard-module" >
          <table class="table table-sm pull-left">
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
      <div class="col-xs-6 p-l-1 pull-right" style="width:40%">
        <div class="dashboard-module" >
          <h6>Attach new prefixes</h6>
          <form class="form-inline">
            {!! Form::select('prefixes', $possiblePrefixes, null, array('class' => 'chosen-select',
              'multiple' => 'multiple', 'data-placeholder' => 'Choose one or more of the following:')) !!}
            <button class="btn btn-sm btn-secondary popover-submit" type="submit" style="margin: 0.5em 0"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
@stop