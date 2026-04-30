@props(['paginator' => null])

@if($paginator && $paginator->hasPages())
    <nav aria-label="Pagination" class="p-3 border-top">
        <!-- Total Count - Always visible -->
        <div class="text-muted small mb-2 text-center text-sm-start">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <!-- Mobile View -->
            <div class="d-flex justify-content-between w-100 d-sm-none">
                @if($paginator->previousPageUrl())
                    <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-chevron-left me-1"></i> Previous
                    </a>
                @endif

                @if($paginator->nextPageUrl())
                    <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-secondary btn-sm ms-auto">
                        Next <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                @endif
            </div>

            <!-- Desktop View -->
            <div class="d-none d-sm-flex justify-content-center flex-grow-1">
                <ul class="pagination mb-0">
                    <!-- Previous Link -->
                    @if($paginator->previousPageUrl())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    <!-- Page Numbers -->
                    @foreach($paginator->links()->elements[0] ?? [] as $page => $url)
                        <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                            @if($page == $paginator->currentPage())
                                <span class="page-link">{{ $page }}</span>
                            @else
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach

                    <!-- Next Link -->
                    @if($paginator->nextPageUrl())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
