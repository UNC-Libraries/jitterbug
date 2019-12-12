  @if ($transfer !== null)
  <div class="row">
    <div class="col-xs-12">
      <h6>Related Transfer</h6>
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
          <tr role="button" data-master="{{$transfer->preservationMasterId}}" data-id="{{$transfer->id}}">
            <td>{{$transfer->preservationMasterId}}</td>
            <td>{{$transfer->transferDate}}</td>
            <td>@if ($transfer->playbackMachine){{$transfer->playbackMachine->name}}@endif</td>
            <td>{{$transfer->engineerName}}</td>
            <td>@if ($transfer->vendor){{$transfer->vendor->name}}@endif</td>
            <td>{{$transfer->conditionNote}}</td>
          </tr>                      
        </tbody>
      </table>
    </div>
  </div>
  @endif
  &nbsp; {{-- Hack to workaround a rendering bug --}}