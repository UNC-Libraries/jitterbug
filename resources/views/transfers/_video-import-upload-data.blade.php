<div id="video-upload-data-container">
  @if (count($data)==0)
    <div>No records were found in the selected file. Either it was empty, or it could not be properly parsed as a .csv file.</div>
  @else
    <div>A preview of your uploaded data containing {{count($data)}} records is shown below. Click ‘Proceed’ to begin import.</div>
  @endif
  <hr>
  <table class="table table-sm table-hover">
    @include('transfers._video-import-table-header')
    <tbody>
      <?php $index = 2; ?>
      @foreach ($data as $row)
      <tr>
        <td>{{$index}}</td>
        <td>{{isset($row['CallNumber']) ? $row['CallNumber'] : ''}}</td>
        <td>{{isset($row['FileName']) ? $row['FileName'] : ''}}</td>
        <td>{{isset($row['Codec']) ? $row['Codec'] : ''}}</td>
        <td>{{isset($row['Duration']) ? $row['Duration'] : ''}}</td>
        <td>{{isset($row['FileSize']) ? $row['FileSize'] : ''}}</td>
        <td>{{isset($row['PreservationChecksum']) ? $row['PreservationChecksum'] : ''}}</td>
        <td>{{isset($row['AspectRatio']) ? $row['AspectRatio'] : ''}}</td>
        <td>{{isset($row['TransferMachine']) ? $row['TransferMachine'] : ''}}</td>
        <td>{{isset($row['TimeBaseCorrector']) ? $row['TimeBaseCorrector'] : ''}}</td>
        <td>{{isset($row['A/Dconverter']) ? $row['A/Dconverter'] : ''}}</td>
        <td>{{isset($row['CaptureEngineer']) ? $row['CaptureEngineer'] : ''}}</td>
        <td>{{isset($row['Date']) ? $row['Date'] : ''}}</td>
        <td>{{isset($row['Color']) ? $row['Color'] : ''}}</td>
        <td>{{isset($row['Sound']) ? $row['Sound'] : ''}}</td>
        <td>{{isset($row['Format']) ? $row['Format'] : ''}}</td>
      </tr>
      <?php $index++; ?>
      @endforeach 
    </tbody>
  </table>
</div>