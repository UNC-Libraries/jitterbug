  <?php $revisionHistory=$revisionable->completeRevisionHistory(); ?>
  @if ($revisionHistory->count() > 0)
  <div class="row revision-history-title">
    <div class="col-xs-12">
      <a href="#"><i class="fa fa-caret-right fa-fw" aria-hidden="true"></i> Revision History</a>
    </div>
  </div>
  <div class="row revision-history">
    <div class="col-xs-12">
      <ul>
        @foreach ($revisionHistory as $history)
          @if($history->field == 'created_at' && !$history->old_value)
            <li>{{ date('n/j/Y', strtotime($history->created_at)) }}: <strong><em>Andrew Shirk{{--{{$history->userResponsible()}}--}}</em></strong> created this record</li>
          @else
            <li>{{ date('n/j/Y', strtotime($history->created_at)) }}: <strong><em>Andrew Shirk{{--{{$history->userResponsible()}}--}}</em></strong> changed <strong><em>{{ $history->fieldName() }}</em></strong> from <strong><em>{{ $history->oldValue() }}</em></strong> to <strong><em>{{ $history->newValue() }}</em></strong></li>
          @endif
        @endforeach
      </ul>
    </div>
  </div>
  @endif