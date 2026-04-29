@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Medicines', 'url' => route('medicines.index')],
];
@endphp
<div>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="page-title">Medicines</h3>
            <p class="page-description">Manage medicine inventory</p>
        </div>
        <a href="{{ route('medicines.create') }}" class="btn-primary inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Medicine
        </a>
    </div>

    @if(session('success'))
        <x-alert variant="success" :dismissible="true">
            {{ session('success') }}
        </x-alert>
    @endif

    @if(session('warning'))
        <x-alert variant="warning" :dismissible="true">
            <div class="flex items-center justify-between w-full">
                <span>{{ session('warning') }}</span>
                <div class="flex items-center gap-2">
                    @if(session('failed_rows'))
                    <a href="{{ route('medicines.export-failed') }}" class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">Failed</a>
                    @endif
                </div>
            </div>
        </x-alert>
    @endif

    <x-card>
        <!-- Filter/Search Header -->
        <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <form method="GET" action="{{ route('medicines.index') }}" class="flex items-center gap-2 flex-1">
                <div class="relative flex-1 max-w-md">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           class="search-input" placeholder="Search brand or generic name...">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
                @if($search)
                <a href="{{ route('medicines.index') }}" class="px-3 py-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Clear
                </a>
                @endif
            </form>

            <div class="flex items-center gap-2">
                <a href="{{ route('medicines.template') }}" class="px-3 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm" title="Download Template">
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
                            <a href="{{ route('medicines.index', ['sort' => 'brand_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-primary-600 flex items-center gap-1">
                                Brand Name
                                @if(request('sort') == 'brand_name')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('medicines.index', ['sort' => 'generic_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-primary-600 flex items-center gap-1">
                                Generic Name
                                @if(request('sort') == 'generic_name')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>Dosage Type</th>
                        <th>Strength</th>
                        <th>Company</th>
                        <th>Package</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($medicines as $index => $medicine)
                    <tr>
                        <td class="text-gray-600">{{ $medicines->firstItem() + $index }}</td>
                        <td>
                            <div class="font-medium text-gray-900">{{ $medicine->brand_name }}</div>
                        </td>
                        <td class="text-gray-600">{{ $medicine->generic_name }}</td>
                        <td class="text-gray-600">{{ $medicine->dosage_type }}</td>
                        <td class="text-gray-600">{{ $medicine->strength }}</td>
                        <td class="text-gray-600">{{ $medicine->company_name ?? 'N/A' }}</td>
                        <td class="text-gray-600">{{ $medicine->package_mark ?? 'N/A' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <a href="{{ route('medicines.edit', $medicine->id) }}" class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('medicines.destroy', $medicine->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-danger hover:bg-red-50 rounded-lg transition-colors" title="Delete" onclick="return confirm('Are you sure?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12">
                            <x-empty-state
                                title="No medicines found"
                                description="Add your first medicine to get started"
                            >
                                <x-slot:action>
                                    <a href="{{ route('medicines.create') }}" class="btn-primary inline-flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Add Medicine
                                    </a>
                                </x-slot:action>
                            </x-empty-state>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($medicines->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $medicines->links('components.pagination') }}
        </div>
        @endif
    </x-card>

    <!-- Import Modal -->
    <div id="importModal" class="hidden modal-backdrop">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-lg font-semibold">Import Medicines</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('medicines.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4 p-6">
                @csrf
                <div>
                    <label class="form-label">Select File (CSV or XLSX)</label>
                    <input type="file" name="file" accept=".csv,.xlsx,.xls" class="form-input" required>
                    <p class="form-help">Format: brand_name, generic_name, dosage_type, strength, company_name, package_mark</p>
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
                <h3 class="text-lg font-semibold">Export Medicines</h3>
                <button onclick="document.getElementById('exportModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('medicines.export') }}" method="GET" class="space-y-4 p-6">
                <div>
                    <p class="text-sm text-gray-600 mb-2">Current filters will be applied:</p>
                    <p class="text-sm text-gray-500">Search: <span class="font-medium">{{ $search ?? 'None' }}</span></p>
                    <p class="text-sm text-gray-500">Total: <span class="font-medium">{{ $medicines->total() }} medicines</span></p>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('exportModal').classList.add('hidden')" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"/></svg>
                        Download CSV
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
