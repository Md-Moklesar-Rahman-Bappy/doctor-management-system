@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Diagnoses', 'url' => route('problems.index')],
];
?>
<div>
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Diagnoses</h1>
            <p class="text-slate-500">Manage health problems and diagnoses</p>
        </div>
        <a href="/problems/create" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Diagnosis
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <form method="GET" action="/problems" class="flex items-center gap-2">
                <div class="relative">
                    <input type="text"
                           name="search"
                           id="problemSearch"
                           value="{{ $search ?? '' }}"
                           placeholder="Search diagnoses..."
                           class="w-64 px-4 py-2 pl-10 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">Search</button>
                @if($search)
                <a href="/problems" class="px-3 py-2 text-slate-500 hover:text-slate-700">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Clear
                </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">
                            <a href="{{ route('problems.index', ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-emerald-600">
                                SL
                                @if(request('sort') == 'id')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">
                            <a href="{{ route('problems.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-emerald-600">
                                Name
                                @if(request('sort') == 'name')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($problems as $index => $problem)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 text-sm">{{ $problems->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-sm font-medium">{{ $problem->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $problem->description ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="/problems/{{ $problem->id }}/edit" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a1 1 0 011-1h2a1 1 0 011 1v3m-4 0a1 1 0 001 1h2a1 1 0 001-1M4 7h16"/></svg>
                                </a>
                                @if(auth()->user()->role === 'superadmin')
                                <form method="POST" action="/problems/{{ $problem->id }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded" title="Delete" onclick="return confirm('Are you sure?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                <div>
                                    <p class="text-lg font-medium text-slate-500">No diagnoses found</p>
                                    <p class="text-sm text-slate-400 mt-1">Add your first diagnosis to get started</p>
                                </div>
                                <a href="/problems/create" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Add Diagnosis
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($problems->hasPages())
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 px-4 py-3 border-t border-slate-200 bg-white">
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-500">
                    Show
                    <select onchange="changePerPage(this.value)" class="mx-1 px-2 py-1 border border-slate-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        @php $perPage = $problems->perPage(); @endphp
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    </select>
                    entries
                </span>
                <span class="text-sm text-slate-500">
                    Showing {{ $problems->firstItem() }} to {{ $problems->lastItem() }} of {{ $problems->total() }}
                </span>
            </div>

            <nav class="flex items-center gap-1">
                @if($problems->previousPageUrl())
                <a href="{{ $problems->previousPageUrl() }}" class="px-3 py-2 text-sm border border-slate-200 rounded hover:bg-slate-100 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Previous
                </a>
                @else
                <span class="px-3 py-2 text-sm border border-slate-200 rounded text-slate-300 cursor-not-allowed flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Previous
                </span>
                @endif

                @for($i = max(1, $problems->currentPage() - 2); $i <= min($problems->lastPage(), $problems->currentPage() + 2); $i++)
                @if($i == $problems->currentPage())
                <span class="px-3 py-2 text-sm bg-emerald-500 text-white border border-emerald-500 rounded">{{ $i }}</span>
                @else
                <a href="{{ $problems->url($i) }}" class="px-3 py-2 text-sm border border-slate-200 rounded hover:bg-slate-100">{{ $i }}</a>
                @endif
                @endfor

                @if($problems->nextPageUrl())
                <a href="{{ $problems->nextPageUrl() }}" class="px-3 py-2 text-sm border border-slate-200 rounded hover:bg-slate-100 flex items-center gap-1">
                    Next <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @else
                <span class="px-3 py-2 text-sm border border-slate-200 rounded text-slate-300 cursor-not-allowed flex items-center gap-1">
                    Next <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
                @endif
            </nav>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
let searchTimeout;
function searchProblem(query) {
    clearTimeout(searchTimeout);
    const results = document.getElementById('searchResults');
    if (query.length < 2) {
        if (results) results.classList.add('hidden');
        return;
    }
    searchTimeout = setTimeout(() => {
        fetch('/problems/autocomplete?term=' + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data && data.data.length > 0) {
                    let html = '';
                    data.data.forEach(problem => {
                        html += `<div class="px-4 py-2 hover:bg-slate-50 cursor-pointer" onclick="selectProblem(${problem.id}, '${problem.name.replace(/'/g, "\\'")}')">
                            <div class="font-medium text-sm">${problem.name}</div>
                        </div>`;
                    });
                    if (results) {
                        results.innerHTML = html;
                        results.classList.remove('hidden');
                    }
                }
            });
    }, 300);
}

function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('input[name="search"]') && !e.target.closest('#searchResults')) {
        const results = document.getElementById('searchResults');
        if (results) results.classList.add('hidden');
    }
});
</script>
@endpush
@endsection
