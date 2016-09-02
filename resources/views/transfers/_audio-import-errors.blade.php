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
            <td @if ($bag->has('CallNumber')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('CallNumber')}}" tabindex="0" class="text-danger" @endif>{{isset($data[$index]['CallNumber']) ? $data[$index]['CallNumber'] : ''}}</td>
            <td @if ($bag->has('OriginatorReference')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('OriginatorReference')}}" tabindex="0" class="text-danger" @endif>{{isset($data[$index]['OriginatorReference']) ? $data[$index]['OriginatorReference'] : ''}}</td>
            <td @if ($bag->has('Side')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Side')}}" tabindex="0" class="text-danger" @endif>{{isset($data[$index]['Side']) ? $data[$index]['Side'] : ''}}</td>
            <td @if ($bag->has('PlaybackMachine')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('PlaybackMachine')}}" tabindex="0" class="text-danger" @endif>{{isset($data[$index]['PlaybackMachine']) ? $data[$index]['PlaybackMachine'] : ''}}</td>
            <td @if ($bag->has('FileSize')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('FileSize')}}" tabindex="0" class="text-danger" @endif>{{isset($data[$index]['FileSize']) ? $data[$index]['FileSize'] : ''}}</td>
            <td @if ($bag->has('Duration')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Duration')}}" tabindex="0" class="text-danger" @endif>{{isset($data[$index]['Duration']) ? $data[$index]['Duration'] : ''}}</td>
          </tr>
        @endif
      <?php $index++; ?>
      @endforeach 
    </tbody>
  </table>
</div>