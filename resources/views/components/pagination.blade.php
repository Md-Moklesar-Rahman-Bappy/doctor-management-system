@props([
    'paginator' => null,
    'searchParam' => 'search',
])

@php
if (!$paginator) {
    return;
}

$perPage = $paginator->perPage();
$currentPage = $paginator->currentPage();
$total = $paginator->total();
$lastItem = $paginator->lastItem();
$firstItem = $paginator->firstItem();
$lastPage = $paginator->lastPage();
$nextPageUrl = $paginator->nextPageUrl();
$prevPageUrl = $paginator->previousPageUrl();
@endphp

@if($total > 0)
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 px-4 py-3 border-t border-slate-200 bg-white">
    <div class="flex items-center gap-4">
        <span class="text-sm text-slate-500">
            Show 
            <select id="perPageSelect" onchange="changePerPage(this.value)" class="mx-1 px-2 py-1 border border-slate-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
            </select>
            entries
        </span>
        <span class="text-sm text-slate-500">
            Showing {{ $firstItem }} to {{ $lastItem }} of {{ $total }}
        </span>
    </div>
    
    <nav class="flex items-center gap-1">
        @if($prevPageUrl)
        <a href="{{ $prevPageUrl }}" class="px-3 py-1.5 text-sm border border-slate-200 rounded hover:bg-slate-100 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Previous
        </a>
        @else
        <span class="px-3 py-1.5 text-sm border border-slate-200 rounded text-slate-300 cursor-not-allowed flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Previous
        </span>
        @endif
        
        @php
        $startPage = max(1, $currentPage - 2);
        $endPage = min($lastPage, $currentPage + 2);
        
        if ($endPage - $startPage < 4) {
            if ($startPage == 1) {
                $endPage = min($lastPage, 5);
            } else {
                $startPage = max(1, $lastPage - 4);
            }
        }
        @endphp
        
        @if($startPage > 1)
        <a href="{{ $paginator->url(1) }}" class="px-3 py-1.5 text-sm border border-slate-200 rounded hover:bg-slate-100">1</a>
        @if($startPage > 2)
        <span class="px-2 text-slate-400">...</span>
        @endif
        @endif
        
        @for($i = $startPage; $i <= $endPage; $i++)
        @if($i == $currentPage)
        <span class="px-3 py-1.5 text-sm bg-emerald-500 text-white border border-emerald-500 rounded">{{ $i }}</span>
        @else
        <a href="{{ $paginator->url($i) }}" class="px-3 py-1.5 text-sm border border-slate-200 rounded hover:bg-slate-100">{{ $i }}</a>
        @endif
        @endfor
        
        @if($endPage < $lastPage)
        @if($endPage < $lastPage - 1)
        <span class="px-2 text-slate-400">...</span>
        @endif
        <a href="{{ $paginator->url($lastPage) }}" class="px-3 py-1.5 text-sm border border-slate-200 rounded hover:bg-slate-100">{{ $lastPage }}</a>
        @endif
        
        @if($nextPageUrl)
        <a href="{{ $nextPageUrl }}" class="px-3 py-1.5 text-sm border border-slate-200 rounded hover:bg-slate-100 flex items-center gap-1">
            Next
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        @else
        <span class="px-3 py-1.5 text-sm border border-slate-200 rounded text-slate-300 cursor-not-allowed flex items-center gap-1">
            Next
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </span>
        @endif
    </nav>
</div>

<script>
function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
</script>
@endif
