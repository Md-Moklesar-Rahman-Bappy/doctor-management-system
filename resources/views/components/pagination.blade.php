@props(['paginator' => null, 'links' => []])@if($paginator && $paginator->hasPages())
    <nav class="flex items-center justify-between px-4 py-3 border-t border-gray-200 sm:px-6" aria-label="Pagination">
        <!-- Mobile View -->
        <div class="flex flex-1 justify-between sm:hidden">
            @if($paginator->previousPageUrl())
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-item pagination-prev">
                    <svg class="pagination-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Previous
                </a>
            @endif

            @if($paginator->nextPageUrl())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-item pagination-next ml-3">
                    Next
                    <svg class="pagination-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @endif
        </div>

        <!-- Desktop View -->
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
            <div class="flex items-center gap-1">
                <!-- Previous Link -->
                @if($paginator->previousPageUrl())
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-item pagination-prev">
                        <svg class="pagination-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="sr-only">Previous</span>
                    </a>
                @endif

                <!-- Page Numbers -->
                @foreach($paginator->links()->elements[0] ?? [] as $page => $url)
                    @if($page == $paginator->currentPage())
                        <span class="pagination-item pagination-page pagination-page-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination-item pagination-page pagination-page-inactive">{{ $page }}</a>
                    @endif
                @endforeach

                <!-- Next Link -->
                @if($paginator->nextPageUrl())
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-item pagination-next">
                        <svg class="pagination-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="sr-only">Next</span>
                    </a>
                @endif
            </div>
        </div>
    </nav>
@endif
