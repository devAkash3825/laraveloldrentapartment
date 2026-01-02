@if ($paginator->hasPages())
    <ul class="pagination ajax-pagination">
       
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="#"><i class="fas fa-chevron-left" aria-hidden="true"></i></a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i class="fas fa-chevron-left" aria-hidden="true"></i></a>
            </li>
        @endif

        
        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            $startPage = max(1, $currentPage - 2);
            $endPage = min($lastPage, $currentPage + 2);

            if ($startPage > 1) {
                echo '<li class="page-item"><a class="page-link" href="' . $paginator->url(1) . '">01</a></li>';
                if ($startPage > 2) {
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                }
            }

            for ($page = $startPage; $page <= $endPage; $page++) {
                if ($page == $currentPage) {
                    echo '<li class="page-item active"><a class="page-link" href="#">' . str_pad($page, 2, '0', STR_PAD_LEFT) . '</a></li>';
                } else {
                    echo '<li class="page-item"><a class="page-link" href="' . $paginator->url($page) . '">' . str_pad($page, 2, '0', STR_PAD_LEFT) . '</a></li>';
                }
            }

            if ($endPage < $lastPage) {
                if ($endPage < $lastPage - 1) {
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                }
                echo '<li class="page-item"><a class="page-link" href="' . $paginator->url($lastPage) . '">' . str_pad($lastPage, 2, '0', STR_PAD_LEFT) . '</a></li>';
            }
        @endphp

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i class="fas fa-chevron-right" aria-hidden="true"></i></a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link" href="#"><i class="fas fa-chevron-right" aria-hidden="true"></i></a>
            </li>
        @endif
    </ul>
@endif
