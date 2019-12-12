  @if (count($item->preservationMasters) > 0 )
  <div class="row">
    <div class="col-xs-12">
      <h6>Related Preservation Masters</h6>
    </div>
  </div>
  <div class="row related-container">
    <div class="col-xs-12">
      <table id="related-masters" class="table table-sm table-hover">
        <thead>
          <tr>
            <th width="12%">PM #</th>
            <th width="20%">File Name</th>
            <th width="30%">File Location</th>
            <th width="15%">Department</th>
            <th width="16%">Duration</th>
            <th width="7%">Type</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($item->preservationMasters as $master)
          <tr role="button" data-id="{{$master->id}}">
            <td>{{$master->id}}</td>
            <td>{{$master->file_name}}</td>
            <td>{{$master->file_location}}</td>
            <td>{{$master->department->name or ''}}</td>
            <td>{{$master->duration}}</td>
            <td>{{$master->type}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  @if (count($cuts) > 0 )
  <div class="row">
    <div class="col-xs-12">
      <h6>Related Cuts</h6>
    </div>
  </div>
  <div class="row related-container">
    <div class="col-xs-12">
      <table id="related-cuts" class="table table-sm table-hover">
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
          @foreach ($cuts as $cut)
          <tr role="button" data-master="{{$cut->preservation_master_id}}" data-id="{{$cut->id}}">
            <td>{{$cut->preservation_master_id}}</td>
            <td>{{$cut->cut_number}}</td>
            <td>{{$cut->side}}</td>
            <td>{{$cut->title}}</td>
            <td>{{$cut->performer_composer}}</td>
            <td>{{$cut->pm_start_time}}</td>
          </tr>
          @endforeach                       
        </tbody>
      </table>
    </div>
  </div>
  @endif
  &nbsp; {{-- Hack to workaround a rendering bug --}}
  