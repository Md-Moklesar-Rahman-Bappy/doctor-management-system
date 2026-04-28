@extends('layouts.dashboard')

@section('content')
<div>
    @if(session('success'))
    <div id="toast-success" class="fixed top-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
    @endif

    @if(session('warning'))
    <div id="toast-warning" class="fixed top-4 right-4 bg-yellow-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('warning') }}
    </div>
    @endif

    @if(session('error'))
    <div id="toast-error" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('error') }}
    </div>
    @endif

    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Lab Tests</h1>
            <p class="text-slate-500">Manage your laboratory tests</p>
        </div>
        <div class="flex gap-2">
            <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import
            </button>
            <a href="/lab_tests/export" class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4 4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export
            </a>
            <a href="/lab_tests/create" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Test
            </a>
        </div>
    </div>

    <div class="mb-6 relative">
        <div class="relative max-w-md">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="searchInput" autocomplete="off" placeholder="Search by test name, code or department..." class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" onkeyup="searchTest(this.value)">
        </div>
        <div id="searchDropdown" class="hidden absolute z-50 w-full max-w-md mt-1 bg-white border border-slate-200 rounded-lg shadow-lg max-h-60 overflow-y-auto"></div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase w-16">SL</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Department</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Sample Type</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Panel</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Test</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Code</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Unit</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Result Type</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Normal Range</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase w-24">Actions</th>
                </tr>
            </thead>
            <tbody id="testTableBody" class="divide-y divide-slate-200">
                @forelse($tests as $index => $test)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-4 text-center text-slate-600">{{ $tests->firstItem() + $index }}</td>
                    <td class="px-4 py-4 font-medium text-slate-900">{{ $test->department }}</td>
                    <td class="px-4 py-4 text-slate-600">{{ $test->sample_type }}</td>
                    <td class="px-4 py-4 text-slate-600">{{ $test->panel }}</td>
                    <td class="px-4 py-4 text-slate-900">{{ $test->test }}</td>
                    <td class="px-4 py-4 text-slate-600 font-mono">{{ $test->code }}</td>
                    <td class="px-4 py-4 text-slate-600">{{ $test->unit }}</td>
                    <td class="px-4 py-4 text-slate-600">{{ $test->result_type }}</td>
                    <td class="px-4 py-4 text-slate-600">
                        @if($test->normal_range)
                            {{ $test->normal_range }}
                        @elseif($test->normal_range_lower && $test->normal_range_upper)
                            {{ $test->normal_range_lower }} - {{ $test->normal_range_upper }}
                        @elseif($test->normal_range_lower)
                            > {{ $test->normal_range_lower }}
                        @elseif($test->normal_range_upper)
                            < {{ $test->normal_range_upper }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="/lab_tests/{{ $test->id }}/edit" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <button type="button" onclick="deleteTest({{ $test->id }})" class="p-2 text-red-500 hover:bg-red-50 rounded-lg" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-6 py-8 text-center text-slate-500">No tests found. Add some tests or import from Excel.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 flex items-center justify-between border-t border-slate-200">
        <div class="flex items-center gap-2">
            <span class="text-sm text-slate-500">Show</span>
            <select id="perPage" onchange="changePerPage(this.value)" class="border border-slate-200 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="10" {{ $tests->perPage() == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $tests->perPage() == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $tests->perPage() == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $tests->perPage() == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="text-sm text-slate-500">per page</span>
        </div>
        <div class="text-sm text-slate-500">
            Showing <span id="fromInfo">{{ $tests->firstItem() }}</span> to <span id="toInfo">{{ $tests->lastItem() }}</span> of <span id="totalInfo">{{ $tests->total() }}</span>
        </div>
        <div class="flex items-center gap-1">
            <button onclick="changePage({{ $tests->currentPage() - 1 }})" id="prevBtn" class="px-3 py-1 border border-slate-200 rounded hover:bg-slate-50 {{ $tests->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $tests->onFirstPage() ? 'disabled' : '' }}>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <span id="pageNumbers">
                @for($i = 1; $i <= $tests->lastPage(); $i++)
                    @if($i == 1 || $i == $tests->lastPage() || ($i >= $tests->currentPage() - 1 && $i <= $tests->currentPage() + 1))
                        <button onclick="changePage({{ $i }})" class="px-3 py-1 rounded {{ $tests->currentPage() == $i ? 'bg-emerald-500 text-white' : 'border border-slate-200 hover:bg-slate-50' }}">{{ $i }}</button>
                    @elseif($i == $tests->currentPage() - 2 || $i == $tests->currentPage() + 2)
                        <span class="px-2 text-slate-400">...</span>
                    @endif
                @endfor
            </span>
            <button onclick="changePage({{ $tests->currentPage() + 1 }})" id="nextBtn" class="px-3 py-1 border border-slate-200 rounded hover:bg-slate-50 {{ $tests->onLastPage() ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $tests->onLastPage() ? 'disabled' : '' }}>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <span class="text-sm text-slate-500 ml-2">Page <span id="pageInfo">{{ $tests->currentPage() }} of {{ $tests->lastPage() }}</span></span>
            <span class="text-sm text-slate-500 ml-3">Go to:</span>
            <input type="number" id="goToPageInput" min="1" max="{{ $tests->lastPage() }}" class="w-16 border border-slate-200 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" onkeypress="if(event.key==='Enter')goToPage()">
        </div>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold mb-4">Import Tests from Excel</h3>
        <p class="text-sm text-slate-500 mb-4">Upload an Excel file (.xlsx, .xls, .csv) with columns: department, sample_type, panel, test, code, unit, result_type, normal_range</p>
        <form action="/lab_tests/import" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" class="w-full border border-slate-200 rounded-lg p-2" required>
            </div>
            <div class="flex gap-2 justify-end">
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600">Import</button>
            </div>
        </form>
    </div>
</div>

@if(session('warning') && str_contains(session('warning'), 'failed'))
<div class="fixed bottom-4 right-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4 shadow-lg z-50">
    <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <span class="text-yellow-800">Some tests failed to import.</span>
        <a href="/lab_tests/export-failed" class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">Download Failed</a>
    </div>
</div>
@endif

@push('scripts')
<script>
    let searchTimeout;

    function searchTest(query) {
        clearTimeout(searchTimeout);

        const results = document.getElementById('searchDropdown');

        if (query.length < 2) {
            results.classList.add('hidden');
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch('/lab_tests/autocomplete?term=' + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    if (data.data && data.data.length > 0) {
                        let html = '';
                        data.data.forEach(test => {
                            const displayName = test.test || '';
                            const displayCode = test.code || '';
                            const displayDept = test.department || '';
                            html += '<div class="px-4 py-2 hover:bg-slate-50 cursor-pointer" onclick="selectTest(' + test.id + ', \'' + displayName.replace(/'/g, "\\'") + '\')">' +
                                '<div class="font-medium text-sm">' + displayName + '</div>' +
                                '<div class="text-xs text-slate-500">' + displayCode + ' - ' + displayDept + '</div>' +
                            '</div>';
                        });
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

    function selectTest(id, name) {
        document.getElementById('searchDropdown').classList.add('hidden');
        document.getElementById('searchInput').value = name;
        window.location.href = '/lab_tests/' + id;
    }

    function deleteTest(id) {
        if (!confirm('Are you sure you want to delete this test?')) return;
        fetch('/lab_tests/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: '_method=DELETE'
        })
        .then(res => {
            window.location.reload();
        })
        .catch(err => {
            console.error(err);
            alert('Error deleting test. Please try again.');
        });
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#searchInput') && !e.target.closest('#searchDropdown')) {
            const results = document.getElementById('searchDropdown');
            if (results) results.classList.add('hidden');
        }
    });

    setTimeout(() => {
        document.querySelectorAll('[id^="toast-"]').forEach(toast => toast.remove());
    }, 5000);
</script>
@endpush
@endsection
