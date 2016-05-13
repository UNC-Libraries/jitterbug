@if ($paginator->lastPage() > 1)
    <ul class="pagination pagination-sm">
        <li class="{{ ($paginator->currentPage() == 1) ? 'page-item disabled' : 'page-item' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>

        <?php
          $numLinks = 5;
          $half = floor($numLinks / 2);
          $from = $paginator->currentPage() - $half;
          $to = $paginator->currentPage() + $half;
          if( $from < 1 ) {
              $remainder = 1 - $from;
              $from = 1;
              $to += $remainder;
          }
          if( $to > $paginator->lastPage()) {
              $remainder = $to - $paginator->lastPage();
              $from = max(1, $from-$remainder);
              $to = $paginator->lastPage();
          }
        ?>

        @for ($i = $from; $i <= $to; $i++)
        <li class="{{ ($paginator->currentPage() == $i) ? 'page-item active' : 'page-item' }}">
            <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
        </li>
        @endfor
        <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? 'page-item disabled' : 'page-item' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
@endif

