@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Medicines', 'url' => route('medicines.index')],
];
@endphp

<div>
    <!-- Page Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3" data-aos="fade-down">
        <div>
            <h3 class="page-title mb-1">Medicines</h3>
            <p class="page-description mb-0">Manage medicine inventory</p>
        </div>
        <a href="{{ route('medicines.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fas fa-pills me-1"></i> Add Medicine
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center justify-content-between w-100">
                <span><i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}</span>
                <div class="d-flex gap-2">
                    @if(session('failed_rows'))
                        <a href="{{ route('medicines.export-failed') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-download me-1"></i>Failed
                        </a>
                    @endif
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm" data-aos="fade-up">
        <!-- Filter/Search Header -->
        <div class="card-header bg-white border-bottom">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <form method="GET" action="{{ route('medicines.index') }}" class="d-flex align-items-center gap-2 flex-1" style="max-width: 400px;">
                    <div class="input-group flex-1">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                               class="form-control border-start-0" placeholder="Search brand or generic name...">
                    </div>
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search me-1"></i>Search
                    </button>
                    @if($search)
                        <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Clear
                        </a>
                    @endif
                </form>

                <div class="d-flex gap-2">
                    <a href="{{ route('medicines.template') }}" class="btn btn-outline-secondary btn-sm" title="Download Template">
                        <i class="fas fa-download me-1"></i>Template
                    </a>
                    <button onclick="document.getElementById('exportModal').classList.remove('d-none')" class="btn btn-outline-secondary btn-sm" title="Export CSV">
                        <i class="fas fa-file-export me-1"></i>Export
                    </button>
                    <button onclick="document.getElementById('importModal').classList.remove('d-none')" class="btn btn-outline-secondary btn-sm" title="Import CSV">
                        <i class="fas fa-file-import me-1"></i>Import
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>
                            <a href="{{ route('medicines.index', ['sort' => 'brand_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-decoration-none text-dark d-flex align-items-center gap-1">
                                Brand Name
                                @if(request('sort') == 'brand_name')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('medicines.index', ['sort' => 'generic_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-decoration-none text-dark d-flex align-items-center gap-1">
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
                <tbody>
                    @forelse($medicines as $index => $medicine)
                    <tr>
                        <td class="text-muted">{{ $medicines->firstItem() + $index }}</td>
                        <td><span class="fw-medium">{{ $medicine->brand_name }}</span></td>
                        <td class="text-muted">{{ $medicine->generic_name }}</td>
                        <td class="text-muted">{{ $medicine->dosage_type }}</td>
                        <td class="text-muted">{{ $medicine->strength }}</td>
                        <td class="text-muted">{{ $medicine->company_name ?? 'N/A' }}</td>
                        <td class="text-muted">{{ $medicine->package_mark ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('medicines.destroy', $medicine->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-5">
                            <x-empty-state
                                title="No medicines found"
                                description="Add your first medicine to get started"
                            >
                                <x-slot:action>
                                    <a href="{{ route('medicines.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                                        <i class="fas fa-pills me-1"></i> Add Medicine
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
            <div class="card-footer bg-white border-top">
                {{ $medicines->links('components.pagination') }}
            </div>
        @endif
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="d-none">
        <div class="modal-backdrop fade show"></div>
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Medicines</h5>
                        <button onclick="document.getElementById('importModal').classList.add('d-none')" class="btn-close"></button>
                    </div>
                    <form action="{{ route('medicines.import') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-3 p-4">
                        @csrf
                        <div>
                            <label class="form-label fw-medium">Select File (CSV or XLSX)</label>
                            <input type="file" name="file" accept=".csv,.xlsx,.xls" class="form-control" required>
                            <div class="form-text">Format: brand_name, generic_name, dosage_type, strength, company_name, package_mark</div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" onclick="document.getElementById('importModal').classList.add('d-none')" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div id="exportModal" class="d-none">
        <div class="modal-backdrop fade show"></div>
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Export Medicines</h5>
                        <button onclick="document.getElementById('exportModal').classList.add('d-none')" class="btn-close"></button>
                    </div>
                    <form action="{{ route('medicines.export') }}" method="GET" class="d-flex flex-column gap-3 p-4">
                        <div>
                            <p class="small text-muted mb-2">Current filters will be applied:</p>
                            <p class="small">Search: <span class="fw-medium">{{ $search ?? 'None' }}</span></p>
                            <p class="small">Total: <span class="fw-medium">{{ $medicines->total() }} medicines</span></p>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" onclick="document.getElementById('exportModal').classList.add('d-none')" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-download me-1"></i>Download CSV
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
