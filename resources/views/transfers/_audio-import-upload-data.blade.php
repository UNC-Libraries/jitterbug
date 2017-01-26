<div id="audio-upload-data-container">
  @if (count($data)==0)
    <div>No records were found in the selected file. Either it was empty, or it could not be properly parsed as a .csv file.</div>
  @else
    <div>A preview of your uploaded data containing {{count($data)}} records is shown below. Click ‘Proceed’ to begin import.</div>
  @endif
  <hr>
  <table class="table table-sm table-hover">
    @include('transfers._audio-import-table-header')
    <tbody>
      <?php $index = 2; ?>
      @foreach ($data as $row)
      <tr>
        <td>{{$index}}</td>
        <td>{{isset($row['CallNumber']) ? $row['CallNumber'] : ''}}</td>
        <td>{{isset($row['OriginatorReference']) ? $row['OriginatorReference'] : ''}}</td>
        <td>{{isset($row['Side']) ? $row['Side'] : ''}}</td>
        <td>{{isset($row['PlaybackMachine']) ? $row['PlaybackMachine'] : ''}}</td>
        <td>{{isset($row['FileSize']) ? $row['FileSize'] : ''}}</td>
        <td>{{isset($row['Duration']) ? $row['Duration'] : ''}}</td>
        <td>{{isset($row['OriginationDate']) ? $row['OriginationDate'] : ''}}</td>
        <td>{{isset($row['IART']) ? $row['IART'] : ''}}</td>
        <td>{{isset($row['OriginalPm']) ? $row['OriginalPm'] : ''}}</td>
      </tr>
      <?php $index++; ?>
      @endforeach 
    </tbody>
  </table>
</div>