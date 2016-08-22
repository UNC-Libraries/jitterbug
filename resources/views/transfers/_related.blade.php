  <?php $cut=$transfer->cut; ?>
  @if ($cut !== null)
  <div class="row">
    <div class="col-xs-12 col-e0">
      <h6>Related Cut</h6>
    </div>
  </div>
  <div class="row first last">
    <div class="col-xs-12 col-fff">
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
          <tr role="button" data-master="{{$cut->preservationMasterId}}" data-id="{{$cut->id}}">
            <td>{{$cut->preservationMasterId}}</td>
            <td>{{$cut->cutNumber}}</td>
            <td>{{$cut->side}}</td>
            <td>{{$cut->title}}</td>
            <td>{{$cut->performerComposer}}</td>
            <td>{{$cut->pmStartTime}}</td>
          </tr>                      
        </tbody>
      </table>
    </div>
  </div>
  @endif