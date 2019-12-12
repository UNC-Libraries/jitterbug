  @if (count($transfers) > 0 )
  <div class="row">
    <div class="col-xs-12">
      <h6>Related Transfers</h6>
    </div>
  </div>
  <div class="row related-container">
    <div class="col-xs-12">
      <table id="related-transfers" class="table table-sm table-hover">
        <thead>
          <tr>
            <th width="10%">PM #</th>
            <th width="15%">Transfer Date</th>
            <th width="20%">Playback Machine</th>
            <th width="20%">Engineer</th>
            <th width="15%">Vendor</th>
            <th width="20%">Condition Note</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transfers as $transfer)
          <tr role="button" data-master="{{$transfer->preservationMasterId}}" data-id="{{$transfer->id}}">
            <td>{{$transfer->preservationMasterId}}</td>
            <td>{{$transfer->transferDate}}</td>
            <td>@if ($transfer->playbackMachine != null){{$transfer->playbackMachine->name}}@endif</td>
            <td>{{$transfer->engineerName}}</td>
            <td>@if ($transfer->vendor != null){{$transfer->vendor->name}}@endif</td>
            <td>{{$transfer->conditionNote}}</td>
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
            <th width="25%">Performer Composer</th>
            <th width="20%">PM Start Time</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($cuts as $cut)
          <tr role="button" data-master="{{$cut->preservationMasterId}}" data-id="{{$cut->id}}">
            <td>{{$cut->preservationMasterId}}</td>
            <td>{{$cut->cutNumber}}</td>
            <td>{{$cut->side}}</td>
            <td>{{$cut->title}}</td>
            <td>{{$cut->performerComposer}}</td>
            <td>{{$cut->pmStartTime}}</td>
          </tr>
          @endforeach                       
        </tbody>
      </table>
    </div>
  </div>
  @endif
  &nbsp; {{-- Hack to workaround a rendering bug --}}
