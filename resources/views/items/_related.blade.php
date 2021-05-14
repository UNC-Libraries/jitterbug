  @if (count($item->preservationInstances) > 0 )
  <div class="row">
    <div class="col-xs-12">
      <h6>Related Preservation Instances</h6>
    </div>
  </div>
  <div class="row related-container">
    <div class="col-xs-12">
      <table id="related-instances" class="table table-sm table-hover">
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
          @foreach ($item->preservationInstances as $instance)
          <tr role="button" data-id="{{$instance->id}}">
            <td>{{$instance->id}}</td>
            <td>{{$instance->file_name}}</td>
            <td>{{$instance->file_location}}</td>
            <td>{{$instance->department->name ?? ''}}</td>
            <td>{{$instance->duration}}</td>
            <td>{{$instance->type}}</td>
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
          <tr role="button" data-instance="{{$cut->preservation_instance_id}}" data-id="{{$cut->id}}">
            <td>{{$cut->preservation_instance_id}}</td>
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
  