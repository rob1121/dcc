@if ($paginator->count() > 1)
    <ul class="pagination">
        <!-- Previous Page Link -->
        @if ($paginator->onFirstPage())
            <li class="disabled"><span><i class="fa fa-arrow-left"></i></span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-arrow-left"></i></a></li>
        @endif

    <!-- Next Page Link -->
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-arrow-right"></i></a></li>
        @else
            <li class="disabled"><span><i class="fa fa-arrow-right"></i></span></li>
        @endif
    </ul>
@endif
