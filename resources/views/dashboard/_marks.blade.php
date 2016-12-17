          <div class="marks">
            <ol>
              <li class="no-marks"></li>
              @foreach ($marks as $mark)
              <li role="button" data-object-id="{{$mark->objectId()}}" data-object-type="{{$mark->objectType()}}">{{$mark->object()}} - <span class="timestamp">{{$mark->timestamp()}}</span>@if ($currentUser->id === $selectedMarksUserId)<a href="#" role="button" class="delete" title="Delete mark"><i class="fa fa-times" aria-hidden="true"></i></a>@endif</li>
              @endforeach
            </ol>
          </div>