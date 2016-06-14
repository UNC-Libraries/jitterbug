  <?php $revisionHistory=$item->completeRevisionHistory(); ?>
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
        <li>{{ date('n/j/Y', strtotime($history->created_at)) }}: <strong><em>Andrew Shirk{{--{{$history->userResponsible()}}--}}</em></strong> changed <strong><em>{{ $history->fieldName() }}</em></strong> from <strong><em>{{ $history->oldValue() }}</em></strong> to <strong><em>{{ $history->newValue() }}</em></strong></li>
        @endforeach
      </ul>
    </div>
  </div>
  @endif