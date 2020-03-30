<div id={{$tableId}}>
  @if (count($data)==0)
    <div>No records were found in the selected file. Either it was empty, or it could not be properly parsed as a .csv file.</div>
  @else
    <div>A preview of your uploaded data containing {{count($data)}} records is shown below. Click ‘Proceed’ to begin import.</div>
  @endif
  <hr>
  <table class="table table-sm table-hover table-fit">
    @include('shared._import-table-header')
    <tbody>
    <?php $index = 2; ?>
    @foreach ($data as $row)
      <tr>
        <td>{{$index}}</td>
        @foreach ($possibleDataKeys as $key)
          <td>{{isset($row[$key]) ? $row[$key] : ''}}</td>
        @endforeach
      </tr>
      <?php $index++; ?>
    @endforeach
    </tbody>
  </table>
</div>
