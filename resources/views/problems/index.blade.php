@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Diagnoses', 'url' => route('problems.index')],
];
@endphp

<div>
    <!-- Page Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3" data-aos="fade-down">
        <div>
            <h3 class="page-title mb-1">Diagnoses</h3>
            <p class="page-description mb-0">Manage health problems and diagnoses</p>
        </div>
        <a href="{{ route('problems.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fas fa-plus"></i> Add Diagnosis
        </a>
    </div>

    <div class="card shadow-sm" data-aos="fade-up">
        <!-- Filter/Search Header -->
        <div class="card-header bg-white border-bottom">
            <form method="GET" action="{{ route('problems.index') }}" class="d-flex align-items-center gap-2 flex-wrap position-relative">
                <div class="input-group flex-1 position-relative" style="max-width: 400px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="problem-search" name="search" value="{{ $search ?? '' }}"
                           class="form-control border-start-0" placeholder="Search diagnoses..." autocomplete="off">
                    <div id="problem-dropdown" class="position-absolute start-0 top-100 mt-1 w-100 shadow-lg bg-white rounded-3 border d-none" style="z-index: 1050; max-height: 300px; overflow-y: auto;"></div>
                </div>
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search me-1"></i>Search
                </button>
                @if($search)
                    <a href="{{ route('problems.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>
                            <a href="{{ route('problems.index', ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-decoration-none text-dark d-flex align-items-center gap-1">
                                SL
                                @if(request('sort') == 'id')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('problems.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-decoration-none text-dark d-flex align-items-center gap-1">
                                Name
                                @if(request('sort') == 'name')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($problems as $index => $problem)
                    <tr>
                        <td class="text-muted">{{ $problems->firstItem() + $index }}</td>
                        <td class="fw-medium">{{ $problem->name }}</td>
                        <td class="text-muted">{{ $problem->description ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('problems.edit', $problem->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('problems.destroy', $problem->id) }}" class="d-inline">
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
                        <td colspan="4" class="py-5">
                            <x-empty-state
                                title="No diagnoses found"
                                description="Add your first diagnosis to get started"
                            >
                                <x-slot:action>
                                    <a href="{{ route('problems.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                                        <i class="fas fa-plus"></i> Add Diagnosis
                                    </a>
                                </x-slot:action>
                            </x-empty-state>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($problems->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $problems->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('problem-search');
    if (!searchInput) return;

    const dropdown = document.getElementById('problem-dropdown');
    const autocompleteUrl = '{{ route("problems.autocomplete") }}';
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
                            '<div class="px-3 py-2 hover-bg-light cursor-pointer border-bottom" onclick="selectProblem(\'' + item.id + '\', \'' + item.name + '\')">' +
                                '<div>' +
                                    '<span class="fw-medium">' + item.name + '</span>' +
                                    (item.description ? '<br><small class="text-muted">' + item.description + '</small>' : '') +
                                '</div>' +
                            '</div>'
                        ).join('');
                        dropdown.classList.remove('d-none');
                    } else if (dropdown) {
                        dropdown.innerHTML = '<div class="px-3 py-3 text-muted text-center">No diagnoses found</div>';
                        dropdown.classList.remove('d-none');
                    }
                });
        }, 300);
    });

    window.selectProblem = function(id, name) {
        searchInput.value = name;
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
