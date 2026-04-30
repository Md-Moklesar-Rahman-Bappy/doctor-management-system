@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Lab Tests', 'url' => route('lab-tests.index')],
];
@endphp

<div>
    <!-- Page Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3" data-aos="fade-down">
        <div>
            <h3 class="page-title mb-1">Lab Tests</h3>
            <p class="page-description mb-0">Manage your laboratory tests</p>
        </div>
        <a href="{{ route('lab-tests.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fas fa-plus"></i> Add Test
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm" data-aos="fade-up">
        <!-- Filter/Search Header -->
        <div class="card-header bg-white border-bottom">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <form method="GET" action="{{ route('lab-tests.index') }}" class="d-flex align-items-center gap-2 flex-1" style="max-width: 400px;">
                    <div class="input-group flex-1">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}"
                               class="form-control border-start-0" placeholder="Search by test name, code or department...">
                    </div>
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search me-1"></i>Search
                    </button>
                    @if($search)
                        <a href="{{ route('lab-tests.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Clear
                        </a>
                    @endif
                </form>

                <div class="d-flex gap-2">
                    <a href="{{ route('lab-tests.template') }}" class="btn btn-outline-secondary btn-sm" title="Download Template">
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
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>
                            <a href="{{ route('lab-tests.index', ['sort' => 'test', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-decoration-none text-dark d-flex align-items-center gap-1">
                                Test
                                @if(request('sort') == 'test')
                                    <span class="text-primary">{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('lab-tests.index', ['sort' => 'code', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-decoration-none text-dark d-flex align-items-center gap-1">
                                Code
                                @if(request('sort') == 'code')
                                    <span class="text-primary">{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('lab-tests.index', ['sort' => 'department', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-decoration-none text-dark d-flex align-items-center gap-1">
                                Department
                                @if(request('sort') == 'department')
                                    <span class="text-primary">{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="text-muted">Details</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tests as $index => $test)
                    <tr class="transition-all hover-bg-light">
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-medium text-dark">{{ $test->test }}</span>
                                @if($test->panel)
                                    <small class="text-muted">{{ $test->panel }}</small>
                                @endif
                            </div>
                        </td>
                        <td><code class="bg-light px-2 py-1 rounded">{{ $test->code }}</code></td>
                        <td><span class="badge bg-light text-dark border">{{ $test->department }}</span></td>
                        <td>
                            <div class="d-flex flex-column gap-1" style="font-size: 0.85rem;">
                                @if($test->sample_type)
                                    <span class="text-muted"><i class="fas fa-vial me-1 text-primary" style="width: 14px;"></i>{{ $test->sample_type }}</span>
                                @endif
                                @if($test->unit || $test->result_type)
                                    <span class="text-muted">
                                        @if($test->unit)<i class="fas fa-balance-scale me-1 text-info" style="width: 14px;"></i>{{ $test->unit }}@endif
                                        @if($test->result_type) · {{ $test->result_type }}@endif
                                    </span>
                                @endif
                                @if($test->normal_range || $test->normal_range_lower || $test->normal_range_upper)
                                    <span class="text-success">
                                        <i class="fas fa-chart-line me-1" style="width: 14px;"></i>
                                        @if($test->normal_range)
                                            {{ $test->normal_range }}
                                        @elseif($test->normal_range_lower && $test->normal_range_upper)
                                            {{ $test->normal_range_lower }} - {{ $test->normal_range_upper }}
                                        @elseif($test->normal_range_lower)
                                            > {{ $test->normal_range_lower }}
                                        @elseif($test->normal_range_upper)
                                            < {{ $test->normal_range_upper }}
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('lab-tests.edit', $test->id) }}">
                                            <i class="fas fa-edit me-2 text-primary"></i>Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteTest({{ $test->id }}, '{{ addslashes($test->test) }}')">
                                            <i class="fas fa-trash me-2"></i>Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5">
                            <x-empty-state
                                title="No tests found"
                                description="Add your first test or import from Excel to get started"
                            >
                                <x-slot:action>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('lab-tests.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                                            <i class="fas fa-plus"></i> Add Test
                                        </a>
                                        <button onclick="document.getElementById('importModal').classList.remove('d-none')" class="btn btn-secondary d-flex align-items-center gap-2">
                                            <i class="fas fa-file-import"></i> Import
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
            <div class="card-footer bg-white border-top">
                {{ $tests->links('components.pagination') }}
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
                        <h5 class="modal-title">Import Tests from Excel</h5>
                        <button onclick="document.getElementById('importModal').classList.add('d-none')" class="btn-close"></button>
                    </div>
                    <form action="{{ route('lab-tests.import') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-3 p-4">
                        @csrf
                        <p class="small text-muted">Upload an Excel file (.xlsx, .xls, .csv) with columns: department, sample_type, panel, test, code, unit, result_type, normal_range</p>
                        <div>
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" class="form-control" required>
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
                        <h5 class="modal-title">Export Tests</h5>
                        <button onclick="document.getElementById('exportModal').classList.add('d-none')" class="btn-close"></button>
                    </div>
                    <form action="{{ route('lab-tests.export') }}" method="GET" class="d-flex flex-column gap-3 p-4">
                        <div>
                            <label class="form-label fw-medium">Search (optional)</label>
                            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control">
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" onclick="document.getElementById('exportModal').classList.add('d-none')" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteTest(id, testName) {
    Swal.fire({
        title: 'Delete "' + testName + '"?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/lab-tests/' + id;
            form.innerHTML = '@csrf<input type="hidden" name="_method" value="DELETE">';
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
@endsection
