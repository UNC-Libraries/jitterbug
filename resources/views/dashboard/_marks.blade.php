          <div class="marks">
            <ol>
              <li class="no-marks"></li>
              @foreach ($marks as $mark)
                <li role="button" data-object-id="{{$mark->objectId()}}" data-object-type="{{$mark->objectType()}}">
                  {{$mark->object()}} - <span class="timestamp">{{$mark->timestamp()}}</span>
                  @if ($currentUser->id === $selectedMarksUserId)
                    <input class="delete-checkbox" type="checkbox" value="" title="choose mark to delete">
                  @endif
                </li>
              @endforeach
            </ol>
          </div>