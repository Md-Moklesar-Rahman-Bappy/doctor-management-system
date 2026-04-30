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
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 position-relative">
                <form method="GET" action="{{ route('lab-tests.index') }}" class="d-flex align-items-center gap-2 flex-1" style="max-width: 400px;">
                    <div class="input-group flex-1 position-relative">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}"
                               class="form-control border-start-0" placeholder="Search by test name, code or department..." autocomplete="off">
                        <div id="lab-test-dropdown" class="position-absolute start-0 top-100 mt-1 w-100 shadow-lg bg-white rounded-3 border d-none" style="z-index: 1050; max-height: 300px; overflow-y: auto;"></div>
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
                        <th>SL</th>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tests as $index => $test)
                    <tr>
                        <td class="text-muted">{{ $tests->firstItem() + $index }}</td>
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
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('lab-tests.edit', $test->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('lab-tests.destroy', $test->id) }}" class="d-inline">
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
                        <td colspan="5" class="py-5">
                            <x-empty-state
                                title="No lab tests found"
                                description="Add your first test or import from Excel to get started"
                            >
                                <x-slot:action>
                                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                                        <a href="{{ route('lab_tests.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                                            <i class="fas fa-flask me-1"></i> Add Test
                                        </a>
                                        <button onclick="document.getElementById('importModal').classList.remove('d-none')" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                                            <i class="fas fa-file-import me-1"></i> Import
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
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;

    const dropdown = document.getElementById('lab-test-dropdown');
    const autocompleteUrl = '{{ route("lab-tests.autocomplete") }}';
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const term = this.value.trim();

        if (term.length < 2) {
            dropdown.classList.add('d-none');
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(autocompleteUrl + '?term=' + encodeURIComponent(term))
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.data.length > 0 && dropdown) {
                        dropdown.innerHTML = data.data.map(item =>
                            '<div class="px-3 py-2 hover-bg-light cursor-pointer border-bottom" onclick="selectLabTest(\'' + item.test + '\', \'' + item.code + '\')">' +
                                '<div class="d-flex justify-content-between align-items-start">' +
                                    '<div>' +
                                        '<span class="fw-medium">' + item.test + '</span>' +
                                        (item.code ? '<br><small class="text-muted">Code: ' + item.code + '</small>' : '') +
                                    '</div>' +
                                    (item.department ? '<span class="badge bg-light text-dark border">' + item.department + '</span>' : '') +
                                '</div>' +
                            '</div>'
                        ).join('');
                        dropdown.classList.remove('d-none');
                    } else if (dropdown) {
                        dropdown.innerHTML = '<div class="px-3 py-3 text-muted text-center">No tests found</div>';
                        dropdown.classList.remove('d-none');
                    }
                });
        }, 300);
    });

    window.selectLabTest = function(testName, code) {
        searchInput.value = testName;
        dropdown.classList.add('d-none');
    };

    document.addEventListener('click', function(e) {
        if (dropdown && !dropdown.contains(e.target) && e.target !== searchInput) {
            dropdown.classList.add('d-none');
        }
    });
});
</script>
@endpush
@endsection
