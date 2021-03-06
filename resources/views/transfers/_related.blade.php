  <?php $cut=$transfer->cut; ?>
  @if ($cut !== null)
  <div class="row">
    <div class="col-xs-12">
      <h6>Related Cut</h6>
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
          <tr role="button" data-instance="{{$cut->preservation_instance_id}}" data-id="{{$cut->id}}">
            <td>{{$cut->preservation_instance_id}}</td>
            <td>{{$cut->cut_number}}</td>
            <td>{{$cut->side}}</td>
            <td>{{$cut->title}}</td>
            <td>{{$cut->performer_composer}}</td>
            <td>{{$cut->pm_start_time}}</td>
          </tr>                      
        </tbody>
      </table>
    </div>
  </div>
  @endif
  &nbsp; {{-- Hack to workaround a rendering bug --}}