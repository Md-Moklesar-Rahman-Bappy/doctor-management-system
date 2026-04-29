@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Lab Tests', 'url' => route('lab_tests.index')],
];
@endphp
<div>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h3 class="page-title">Lab Tests</h3>
            <p class="page-description">Manage your laboratory tests</p>
        </div>
        <a href="{{ route('lab_tests.create') }}" class="btn-primary inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Test
        </a>
    </div>

    @if(session('success'))
        <x-alert variant="success" :dismissible="true">
            {{ session('success') }}
        </x-alert>
    @endif

    <x-card>
        <!-- Filter/Search Header -->
        <div class="p-4 border-b border-gray-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <form method="GET" action="{{ route('lab_tests.index') }}" class="flex items-center gap-2 flex-1">
                <div class="relative flex-1 max-w-md">
                    <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}"
                           class="search-input" placeholder="Search by test name, code or department...">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
                @if($search)
                <a href="{{ route('lab_tests.index') }}" class="px-3 py-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Clear
                </a>
                @endif
            </form>

            <div class="flex items-center gap-2">
                <a href="{{ route('lab_tests.template') }}" class="px-3 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm" title="Download Template">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"/></svg>
                    Template
                </a>
                <button onclick="document.getElementById('exportModal').classList.remove('hidden')" class="px-3 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm" title="Export CSV">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4 4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Export
                </button>
                <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="px-3 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm" title="Import CSV">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"/></svg>
                    Import
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>
                            <a href="{{ route('lab_tests.index', ['sort' => 'department', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-primary-600 flex items-center gap-1">
                                Department
                                @if(request('sort') == 'department')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>Sample Type</th>
                        <th>Panel</th>
                        <th>
                            <a href="{{ route('lab_tests.index', ['sort' => 'test', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-primary-600 flex items-center gap-1">
                                Test
                                @if(request('sort') == 'test')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('lab_tests.index', ['sort' => 'code', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-primary-600 flex items-center gap-1">
                                Code
                                @if(request('sort') == 'code')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>Unit</th>
                        <th>Result Type</th>
                        <th>Normal Range</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($tests as $index => $test)
                    <tr>
                        <td class="text-gray-600">{{ $tests->firstItem() + $index }}</td>
                        <td class="font-medium text-gray-900">{{ $test->department }}</td>
                        <td class="text-gray-600">{{ $test->sample_type }}</td>
                        <td class="text-gray-600">{{ $test->panel }}</td>
                        <td class="font-medium text-gray-900">{{ $test->test }}</td>
                        <td class="text-gray-600 font-mono">{{ $test->code }}</td>
                        <td class="text-gray-600">{{ $test->unit }}</td>
                        <td class="text-gray-600">{{ $test->result_type }}</td>
                        <td class="text-gray-600">
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
                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('lab_tests.edit', $test->id) }}" class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button type="button" onclick="deleteTest({{ $test->id }})" class="p-2 text-danger hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-4 py-12">
                            <x-empty-state
                                title="No tests found"
                                description="Add your first test or import from Excel to get started"
                            >
                                <x-slot:action>
                                    <div class="flex gap-2">
                                        <a href="{{ route('lab_tests.create') }}" class="btn-primary inline-flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Add Test
                                        </a>
                                        <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="btn-secondary inline-flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"/></svg>
                                            Import
                                        </button>
                                    </div>
                                </x-slot:action>
                            </x-empty-state>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tests->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $tests->links('components.pagination') }}
        </div>
        @endif
    </x-card>

    <!-- Import Modal -->
    <div id="importModal" class="hidden modal-backdrop">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-lg font-semibold">Import Tests from Excel</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('lab_tests.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4 p-6">
                @csrf
                <p class="text-sm text-gray-500 mb-4">Upload an Excel file (.xlsx, .xls, .csv) with columns: department, sample_type, panel, test, code, unit, result_type, normal_range</p>
                <div>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" class="form-input" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Export Modal -->
    <div id="exportModal" class="hidden modal-backdrop">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-lg font-semibold">Export Tests</h3>
                <button onclick="document.getElementById('exportModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('lab_tests.export') }}" method="GET" class="space-y-4 p-6">
                <div>
                    <label class="form-label">Search (optional)</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="form-input">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('exportModal').classList.add('hidden')" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"/></svg>
                        Export
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteTest(id) {
    if (confirm('Delete this test?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/lab_tests/' + id;
        form.innerHTML = '@csrf<input type="hidden" name="_method" value="DELETE">';
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection
