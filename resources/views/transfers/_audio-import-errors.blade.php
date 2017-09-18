<div id="audio-import-result-container">
  <div class="text-danger">There are errors in your uploaded file. Hover over the fields for details, then correct and upload a new file.</div>
  <hr>
  <table class="table table-sm table-hover">
    @include('transfers._audio-import-table-header')
    <tbody>
      <?php $index = 0; ?>
      @foreach ($messages as $bag)
        @if ($bag->any())
          <tr>
            <td>{{$index+2}}</td>
            <td @if ($bag->has('CallNumber')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('CallNumber')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['CallNumber']) ? $data[$index]['CallNumber'] : ($bag->has('CallNumber') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('OriginatorReference')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('OriginatorReference')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['OriginatorReference']) ? $data[$index]['OriginatorReference'] : ($bag->has('OriginatorReference') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('Side')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Side')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Side']) ? $data[$index]['Side'] : ($bag->has('Side') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('PlaybackMachine')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('PlaybackMachine')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['PlaybackMachine']) ? $data[$index]['PlaybackMachine'] : ($bag->has('PlaybackMachine') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('FileSize')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('FileSize')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['FileSize']) ? $data[$index]['FileSize'] : ($bag->has('FileSize') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('Duration')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Duration')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Duration']) ? $data[$index]['Duration'] : ($bag->has('Duration') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('OriginationDate')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('OriginationDate')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['OriginationDate']) ? $data[$index]['OriginationDate'] : ($bag->has('OriginationDate') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('TransferNote')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('TransferNote')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['TransferNote']) ? $data[$index]['TransferNote'] : ($bag->has('TransferNote') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('IART')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('IART')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['IART']) ? $data[$index]['IART'] : ($bag->has('IART') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('OriginalPm')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('OriginalPm')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['OriginalPm']) ? $data[$index]['OriginalPm'] : ($bag->has('OriginalPm') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
          </tr>
        @endif
      <?php $index++; ?>
      @endforeach 
    </tbody>
  </table>
</div>