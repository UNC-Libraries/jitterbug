<div id='{{ $tableType }}-import-result-container'>
  <div class="text-danger">There are errors in your uploaded file. Hover over the fields for details, then correct and upload a new file.</div>
  <hr>
  <table class="table table-sm table-hover table-fit">
    @include('shared._import-table-header')
    <tbody>
    <?php $index = 0; ?>
    @foreach ($messages as $bag)
      @if ($bag->any())
        <tr>
          <td>{{$index+2}}</td>
          @foreach ($possibleDataKeys as $fieldName)
            <td @if ($bag->has($fieldName)) data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$bag->first($fieldName)}}" tabindex="0" class="text-danger" @endif>{!! !empty($data[$index][$fieldName]) ? $data[$index][$fieldName] : ($bag->has($fieldName) ? '<div class="empty-required">&nbsp;</div>' : '') !!}</td>
          @endforeach
        </tr>
      @endif
      <?php $index++; ?>
    @endforeach
    </tbody>
  </table>
</div>
