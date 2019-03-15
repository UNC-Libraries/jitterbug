<div id="items-upload-data-container">
  @if (count($data)==0)
    <div>No records were found in the selected file. Either it was empty, or it could not be properly parsed as a .csv file.</div>
  @else
    <div>A preview of your uploaded data containing {{count($data)}} records is shown below. Click ‘Proceed’ to begin import.</div>
  @endif
  <hr>
  <table class="table table-sm table-hover">
    @include('items._items-import-table-header')
    <tbody>
      <?php $index = 2; ?>
      @foreach ($data as $row)
      <tr>
        <td>{{$index}}</td>
        <td>{{isset($row['Type']) ? $row['Type'] : ''}}</td>
        <td>{{isset($row['Title']) ? $row['Title'] : ''}}</td>
        <td>{{isset($row['Collection']) ? $row['Collection'] : ''}}</td>
        <td>{{isset($row['ContainerNote']) ? $row['ContainerNote'] : ''}}</td>
        <td>{{isset($row['AccessionNumber']) ? $row['AccessionNumber'] : ''}}</td>
        <td>{{isset($row['LegacyID']) ? $row['LegacyID'] : ''}}</td>
        <td>{{isset($row['FormatID']) ? $row['FormatID'] : ''}}</td>
        <td>{{isset($row['RecLocation']) ? $row['RecLocation'] : ''}}</td>
        <td>{{isset($row['ItemYear']) ? $row['ItemYear'] : ''}}</td>
        <td>{{isset($row['ItemDate']) ? $row['ItemDate'] : ''}}</td>
        <td>{{isset($row['Size']) ? $row['Size'] : ''}}</td>
        <td>{{isset($row['Element']) ? $row['Element'] : ''}}</td>
        <td>{{isset($row['Base']) ? $row['Base'] : ''}}</td>
        <td>{{isset($row['Color']) ? $row['Color'] : ''}}</td>
        <td>{{isset($row['SoundType']) ? $row['SoundType'] : ''}}</td>
        <td>{{isset($row['LengthInFeet']) ? $row['LengthInFeet'] : ''}}</td>
        <td>{{isset($row['ContentDescription']) ? $row['ContentDescription'] : ''}}</td>
        <td>{{isset($row['ReelTapeNumber']) ? $row['ReelTapeNumber'] : ''}}</td>
      </tr>
      <?php $index++; ?>
      @endforeach 
    </tbody>
  </table>
</div>