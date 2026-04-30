@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Lab Reports', 'url' => route('lab_test_reports.index')],
];
@endphp

<div>
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3" data-aos="fade-down">
        <div>
            <h1 class="fw-bold text-dark mb-1">Lab Reports</h1>
            <p class="text-muted mb-0">Manage patient lab test reports</p>
        </div>
        <a href="{{ route('lab_test_reports.create') }}" class="btn btn-warning d-flex align-items-center gap-2">
            <i class="fas fa-vial me-1"></i> Add Lab Report
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm" data-aos="fade-up">
        <div class="card-header bg-white border-bottom">
            <form method="GET" action="{{ route('lab_test_reports.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
                <div class="input-group flex-1" style="max-width: 400px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search by patient ID or name..." class="form-control border-start-0">
                </div>
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search me-1"></i>Search
                </button>
                @if($search)
                    <a href="{{ route('lab_test_reports.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>
                            <a href="{{ route('lab_test_reports.index', ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-decoration-none text-dark">
                                ID
                                @if(request('sort') == 'id')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>Patient</th>
                        <th>
                            <a href="{{ route('lab_test_reports.index', ['sort' => 'test_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-decoration-none text-dark">
                                Test Name
                                @if(request('sort') == 'test_name')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('lab_test_reports.index', ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-decoration-none text-dark">
                                Date
                                @if(request('sort') == 'created_at')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>Has Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td class="text-muted">{{ $report->id }}</td>
                        <td>
                            <a href="{{ route('patients.show', $report->patient->id) }}" class="text-decoration-none">
                                <span class="fw-medium text-primary">{{ $report->patient->unique_id }}</span> - {{ $report->patient->patient_name }}
                            </a>
                        </td>
                        <td class="text-muted">{{ $report->test_name }}</td>
                        <td class="text-muted">{{ $report->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($report->report_image)
                                <span class="badge bg-primary-subtle text-primary-emphasis">Yes</span>
                            @else
                                <span class="badge bg-light text-muted">No</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('lab_test_reports.show', $report->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('lab_test_reports.edit', $report->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('lab_test_reports.destroy', $report->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this report?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-5">
                            <div class="text-center">
                                <i class="fas fa-vial text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                <p class="fw-medium text-muted">No lab test reports found</p>
                                <p class="small text-muted">Add your first report to get started</p>
                                <a href="{{ route('lab_test_reports.create') }}" class="btn btn-warning d-flex align-items-center gap-2 mt-3">
                                    <i class="fas fa-vial"></i> Add Report
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-top">
            {{ $reports->links('components.pagination') }}
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    if (!searchInput) return;

    const dropdown = document.getElementById('autocomplete-dropdown');
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const term = this.value.trim();

        if (term.length < 2) {
            if (dropdown) dropdown.classList.add('d-none');
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch('/patients/autocomplete?term=' + encodeURIComponent(term))
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0 && dropdown) {
                        dropdown.innerHTML = data.map(item =>
                            `<div class="px-3 py-2 hover-bg-light cursor-pointer" onclick="window.location='/lab-test-reports?search=${encodeURIComponent(item.unique_id)}'">
                                <span class="fw-medium">${item.unique_id}</span> - ${item.patient_name}
                            </div>`
                        ).join('');
                        dropdown.classList.remove('d-none');
                    } else if (dropdown) {
                        dropdown.classList.add('d-none');
                    }
                });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (dropdown && !dropdown.contains(e.target) && e.target !== searchInput) {
            dropdown.classList.add('d-none');
        }
    });
});
</script>
@endpush
@endsection
