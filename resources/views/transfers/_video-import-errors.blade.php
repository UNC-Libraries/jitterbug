<div id="video-import-result-container">
  <div class="text-danger">There are errors in your uploaded file. Hover over the fields for details, then correct and upload a new file.</div>
  <hr>
  <table class="table table-sm table-hover">
    @include('transfers._video-import-table-header')
    <tbody>
      <?php $index = 0; ?>
      @foreach ($messages as $bag)
        @if ($bag->any())
          <tr>
            <td>{{$index+2}}</td>
            <td @if ($bag->has('CallNumber')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('CallNumber')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['CallNumber']) ? $data[$index]['CallNumber'] : ($bag->has('CallNumber') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('FileName')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('FileName')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['FileName']) ? $data[$index]['FileName'] : ($bag->has('FileName') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('Codec')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Codec')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Codec']) ? $data[$index]['Codec'] : ($bag->has('Codec') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('Duration')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Duration')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Duration']) ? $data[$index]['Duration'] : ($bag->has('Duration') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('FileSize')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('FileSize')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['FileSize']) ? $data[$index]['FileSize'] : ($bag->has('FileSize') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('PreservationChecksum')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('PreservationChecksum')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['PreservationChecksum']) ? $data[$index]['PreservationChecksum'] : ($bag->has('PreservationChecksum') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('AspectRatio')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('AspectRatio')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['AspectRatio']) ? $data[$index]['AspectRatio'] : ($bag->has('AspectRatio') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('TransferMachine')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('TransferMachine')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['TransferMachine']) ? $data[$index]['TransferMachine'] : ($bag->has('TransferMachine') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('TimeBaseCorrector')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('TimeBaseCorrector')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['TimeBaseCorrector']) ? $data[$index]['TimeBaseCorrector'] : ($bag->has('TimeBaseCorrector') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('A/Dconverter')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('A/Dconverter')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['A/Dconverter']) ? $data[$index]['A/Dconverter'] : ($bag->has('A/Dconverter') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('CaptureEngineer')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('CaptureEngineer')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['CaptureEngineer']) ? $data[$index]['CaptureEngineer'] : ($bag->has('CaptureEngineer') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('IART')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('IART')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['IART']) ? $data[$index]['IART'] : ($bag->has('IART') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('Date')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Date')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Date']) ? $data[$index]['Date'] : ($bag->has('Date') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('Color')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Color')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Color']) ? $data[$index]['Color'] : ($bag->has('Color') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('Sound')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Sound')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Sound']) ? $data[$index]['Sound'] : ($bag->has('Sound') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>

            <td @if ($bag->has('Format')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Format')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Format']) ? $data[$index]['Format'] : ($bag->has('Format') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            
          </tr>
        @endif
      <?php $index++; ?>
      @endforeach 
    </tbody>
  </table>
</div>