@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Medicines</h1>
            <p class="text-slate-500">Manage medicine inventory</p>
        </div>
        <a href="/medicines/create" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Medicine
        </a>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex items-center justify-between">
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('warning'))
    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-lg">
        <div class="flex items-center justify-between">
                <span>{{ session('warning') }}</span>
            <div class="flex items-center gap-2">
                @if(session('duplicate_rows'))
                <a href="/medicines/download-duplicates" class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Duplicates</a>
                @endif
                @if(session('failed_rows'))
                <a href="/medicines/download-failed" class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">Failed</a>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <form method="GET" action="/medicines" class="flex items-center gap-2">
                <div class="relative">
                    <input type="text"
                           name="search"
                           id="medicineSearch"
                           value="{{ $search ?? '' }}"
                           placeholder="Search brand or generic name..."
                           class="w-64 px-4 py-2 pl-10 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           autocomplete="off"
                           onkeyup="searchMedicine(this.value)">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <div id="searchResults" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-slate-200 rounded-lg shadow-lg z-50 max-h-60 overflow-y-auto"></div>
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">Search</button>
                @if($search)
                <a href="/medicines" class="px-3 py-2 text-slate-500 hover:text-slate-700">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Clear
                </a>
                @endif
            </form>

            <div class="flex items-center gap-2">
                <a href="/medicines/template" class="px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg text-sm" title="Download Template">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg> Template
                </a>
                <button onclick="document.getElementById('exportModal').classList.remove('hidden')" class="px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg text-sm" title="Export CSV">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4 4l-4 4m0 0l-4-4m4 4V4"/></svg> Export
                </button>
                <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg text-sm" title="Import CSV">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"/></svg> Import
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">SL</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Brand Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Generic Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Dosage Type</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Strength</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Company</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Package</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody id="medicinesTableBody" class="divide-y divide-slate-200">
                @forelse($medicines as $index => $medicine)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 text-sm">{{ $medicines->firstItem() + $index }}</td>
                    <td class="px-4 py-3 text-sm font-medium">{{ $medicine->brand_name }}</td>
                    <td class="px-4 py-3 text-sm">{{ $medicine->generic_name }}</td>
                    <td class="px-4 py-3 text-sm">{{ $medicine->dosage_type }}</td>
                    <td class="px-4 py-3 text-sm">{{ $medicine->strength }}</td>
                    <td class="px-4 py-3 text-sm">{{ $medicine->company_name ?? 'N/A' }}</td>
                    <td class="px-4 py-3 text-sm">{{ $medicine->package_mark ?? 'N/A' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <a href="/medicines/{{ $medicine->id }}/edit" class="p-3 text-emerald-600 hover:bg-emerald-50 rounded" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="/medicines/{{ $medicine->id }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 text-red-600 hover:bg-red-50 rounded" title="Delete" onclick="return confirm('Are you sure?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-slate-500">No medicines found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($medicines->hasPages())
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 px-4 py-3 border-t border-slate-200 bg-white">
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-500">
                    Show
                    <select id="perPageSelect" onchange="changePerPage(this.value)" class="mx-1 px-2 py-1 border border-slate-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        @php $perPage = $medicines->perPage(); @endphp
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    entries
                </span>
                <span class="text-sm text-slate-500">
                    Showing {{ $medicines->firstItem() }} to {{ $medicines->lastItem() }} of {{ $medicines->total() }}
                </span>
            </div>

            <nav class="flex items-center gap-1">
                @if($medicines->previousPageUrl())
                <a href="{{ $medicines->previousPageUrl() }}" class="px-3 py-1.5 text-sm border border-slate-200 rounded hover:bg-slate-100 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Previous
                </a>
                @else
                <span class="px-3 py-1.5 text-sm border border-slate-200 rounded text-slate-300 cursor-not-allowed flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Previous
                </span>
                @endif

                @php
                $currentPage = $medicines->currentPage();
                $lastPage = $medicines->lastPage();
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
                <a href="{{ $medicines->url(1) }}" class="px-3 py-1.5 text-sm border border-slate-200 rounded hover:bg-slate-100">1</a>
                @if($startPage > 2)
                <span class="px-3 py-1.5 text-sm text-slate-400">...</span>
                @endif
                @endif

                @for($i = $startPage; $i <= $endPage; $i++)
                @if($i == $currentPage)
                <span class="px-3 py-1.5 text-sm bg-emerald-500 text-white border border-emerald-500 rounded">{{ $i }}</span>
                @else
                <a href="{{ $medicines->url($i) }}" class="px-3 py-1.5 text-sm border border-slate-200 rounded hover:bg-slate-100">{{ $i }}</a>
                @endif
                @endfor

                @if($endPage < $lastPage)
                @if($endPage < $lastPage - 1)
                <span class="px-3 py-1.5 text-sm text-slate-400">...</span>
                @endif
                <a href="{{ $medicines->url($lastPage) }}" class="px-3 py-1.5 text-sm border border-slate-200 rounded hover:bg-slate-100">{{ $lastPage }}</a>
                @endif

                @if($medicines->nextPageUrl())
                <a href="{{ $medicines->nextPageUrl() }}" class="px-3 py-1.5 text-sm border border-slate-200 rounded hover:bg-slate-100 flex items-center gap-1">
                    Next <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @else
                <span class="px-3 py-1.5 text-sm border border-slate-200 rounded text-slate-300 cursor-not-allowed flex items-center gap-1">
                    Next <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
                @endif
            </nav>
        </div>
        @endif
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Import Medicines</h3>
            <form method="POST" action="/medicines/import" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Select File (CSV or XLSX)</label>
                    <input type="file" name="file" accept=".csv,.xlsx,.xls" class="w-full px-3 py-2 border border-slate-200 rounded-lg" required>
                    <p class="text-xs text-slate-500 mt-1">Format: brand_name, generic_name, dosage_type, strength, company_name, package_mark</p>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600">Import</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Export Modal -->
    <div id="exportModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Export Medicines</h3>
            <form method="GET" action="/medicines/export-view">
                <div class="mb-4">
                    <p class="text-sm text-slate-600 mb-2">Current filters will be applied:</p>
                    <p class="text-sm text-slate-500">Search: <span class="font-medium">{{ $search ?? 'None' }}</span></p>
                    <p class="text-sm text-slate-500">Total: <span class="font-medium">{{ $medicines->total() }} medicines</span></p>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('exportModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4 4l-4 4m0 0l-4-4m4 4V4"/></svg> Download CSV
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let searchTimeout;

function searchMedicine(query) {
    clearTimeout(searchTimeout);

    const results = document.getElementById('searchResults');
    const form = document.querySelector('form[action="/medicines"]');

    if (query.length < 2) {
        results.classList.add('hidden');
        return;
    }

    searchTimeout = setTimeout(() => {
        fetch('/medicines/autocomplete?term=' + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {
                if (data.data && data.data.length > 0) {
                    let html = '';
                    data.data.forEach(medicine => {
                        const displayName = medicine.brand_name || '';
                        const displayGeneric = medicine.generic_name || '';
                        const displayDosage = medicine.dosage_type || '';
                        const displayCompany = medicine.company_name || '';
                        const medicineId = medicine.id || '';
                        html += `<div class="px-4 py-2 hover:bg-slate-50 cursor-pointer" onclick="selectMedicine(${medicineId}, '${displayName.replace(/'/g, "\\'")}')">
                            <div class="font-medium text-sm">${displayName}</div>
                            <div class="text-xs text-slate-500">${displayGeneric} ${displayDosage} ${displayCompany}</div>
                        </div>`;
                    });
                    html += `<div class="border-t border-slate-200 px-4 py-2 hover:bg-slate-100 cursor-pointer text-sm text-emerald-600 font-medium" onclick="showAllResults('${query.replace(/'/g, "\\'")}')">
                        Show all results for "${query}"
                    </div>`;
                    results.innerHTML = html;
                    results.classList.remove('hidden');
                } else {
                    results.innerHTML = '<div class="px-4 py-2 text-xs text-slate-500">No results found</div>';
                    results.classList.remove('hidden');
                }
            })
            .catch(err => console.error('Search error:', err));
    }, 300);
}

function selectMedicine(id, name) {
    document.getElementById('searchResults').classList.add('hidden');
    document.getElementById('medicineSearch').value = name;
    window.location.href = '/medicines/' + id;
}

function showAllResults(query) {
    document.getElementById('searchResults').classList.add('hidden');
    document.getElementById('medicineSearch').value = query;
    document.querySelector('form[action="/medicines"]').submit();
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && document.activeElement.id === 'medicineSearch') {
        const query = document.getElementById('medicineSearch').value.trim();
        if (query.length >= 2) {
            showAllResults(query);
        }
    }
});

function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#medicineSearch') && !e.target.closest('#searchResults')) {
        const results = document.getElementById('searchResults');
        if (results) results.classList.add('hidden');
    }
});
</script>
@endpush
@endsection
