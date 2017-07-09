<div id="items-import-result-container">
  <div class="text-danger">There are errors in your uploaded file. Hover over the fields for details, then correct and upload a new file.</div>
  <hr>
  <table class="table table-sm table-hover">
    @include('items._items-import-table-header')
    <tbody>
      <?php $index = 0; ?>
      @foreach ($messages as $bag)
        @if ($bag->any())
          <tr>
            <td>{{$index+2}}</td>
            <td @if ($bag->has('Type')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Type')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Type']) ? $data[$index]['Type'] : ($bag->has('Type') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('Title')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Title')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Title']) ? $data[$index]['Title'] : ($bag->has('Title') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('Collection')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Collection')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Collection']) ? $data[$index]['Collection'] : ($bag->has('Collection') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('ContainerNote')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('ContainerNote')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['ContainerNote']) ? $data[$index]['ContainerNote'] : ($bag->has('ContainerNote') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('AccessionNumber')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('AccessionNumber')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['AccessionNumber']) ? $data[$index]['AccessionNumber'] : ($bag->has('AccessionNumber') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('LegacyID')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('LegacyID')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['LegacyID']) ? $data[$index]['LegacyID'] : ($bag->has('LegacyID') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('FormatID')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('FormatID')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['FormatID']) ? $data[$index]['FormatID'] : ($bag->has('FormatID') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('RecLocation')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('RecLocation')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['RecLocation']) ? $data[$index]['RecLocation'] : ($bag->has('RecLocation') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('ItemYear')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('ItemYear')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['ItemYear']) ? $data[$index]['ItemYear'] : ($bag->has('ItemYear') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('ItemDate')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('ItemDate')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['ItemDate']) ? $data[$index]['ItemDate'] : ($bag->has('ItemDate') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('Size')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Size')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Size']) ? $data[$index]['Size'] : ($bag->has('Size') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('Element')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Element')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Element']) ? $data[$index]['Element'] : ($bag->has('Element') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('Base')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Base')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Base']) ? $data[$index]['Base'] : ($bag->has('Base') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('Color')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('Color')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['Color']) ? $data[$index]['Color'] : ($bag->has('Color') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('SoundType')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('SoundType')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['SoundType']) ? $data[$index]['SoundType'] : ($bag->has('SoundType') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('LengthInFeet')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('LengthInFeet')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['LengthInFeet']) ? $data[$index]['LengthInFeet'] : ($bag->has('LengthInFeet') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
            <td @if ($bag->has('ContentDescription')) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first('ContentDescription')}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index]['ContentDescription']) ? $data[$index]['ContentDescription'] : ($bag->has('ContentDescription') ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
          </tr>
        @endif
      <?php $index++; ?>
      @endforeach 
    </tbody>
  </table>
</div>