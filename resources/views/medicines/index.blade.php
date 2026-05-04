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
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 position-relative">
                <form method="GET" action="{{ route('medicines.index') }}" class="d-flex align-items-center gap-2 flex-1" style="max-width: 400px;">
                    <div class="input-group flex-1 position-relative">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="medicine-search" name="search" value="{{ $search ?? '' }}"
                               class="form-control border-start-0" placeholder="Search brand or generic name..." autocomplete="off">
                        <div id="medicine-dropdown" class="position-absolute start-0 top-100 mt-1 w-100 shadow-lg bg-white rounded-3 border d-none" style="z-index: 1050; max-height: 300px; overflow-y: auto;"></div>
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

        <!-- Medicine Cards -->
        <div class="d-flex flex-column gap-3">
            @forelse($medicines as $index => $medicine)
            <div class="card p-3 border-0 shadow-sm mb-3 bg-white">
                <div class="row g-2 align-items-center">
                    <!-- Brand Name -->
                    <div class="col-md-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-pills text-primary"></i>
                            <div>
                                <div class="fw-medium">{{ $medicine->brand_name }}</div>
                                @if($medicine->generic_name)
                                    <div class="small text-muted">{{ $medicine->generic_name }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Strength -->
                    <div class="col-md-2">
                        <span class="badge bg-secondary">{{ $medicine->strength ?? 'N/A' }}</span>
                    </div>

                    <!-- Dosage Type -->
                    <div class="col-md-2">
                        <span class="text-muted small">{{ $medicine->dosage_type ?? 'N/A' }}</span>
                    </div>

                    <!-- Company -->
                    <div class="col-md-2">
                        <span class="text-muted small">{{ $medicine->company_name ?? 'N/A' }}</span>
                    </div>

                    <!-- Package -->
                    <div class="col-md-2">
                        <span class="text-muted small">{{ $medicine->package_mark ?? 'N/A' }}</span>
                    </div>

                    <!-- Actions -->
                    <div class="col-md-1">
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
                    </div>
                </div>
            </div>
            @empty
            <div class="py-5">
                <x-empty-state
                    title="No medicines found"
                    description="Add your first medicine or import from Excel to get started"
                >
                    <x-slot:action>
                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <a href="{{ route('medicines.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="fas fa-pills me-1"></i> Add Medicine
                            </a>
                            <button onclick="document.getElementById('importModal').classList.remove('d-none')" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                                <i class="fas fa-file-import me-1"></i> Import
                            </button>
                        </div>
                    </x-slot:action>
                </x-empty-state>
            </div>
            @endforelse
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('medicine-search');
    if (!searchInput) return;

    const dropdown = document.getElementById('medicine-dropdown');
    const autocompleteUrl = '{{ route("medicines.autocomplete") }}';
    let debounceTimer;

    // Highlight matching text
    function highlightText(text, term) {
        if (!term || !text) return text;
        try {
            const regex = new RegExp(`(${term})`, 'gi');
            return text.replace(regex, '<strong>$1</strong>');
        } catch (e) {
            return text;
        }
    }

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
                        dropdown.innerHTML = data.data.map(item => {
                            const brandHtml = highlightText(item.brand_name, term);
                            const strengthHtml = item.strength ? ` - ${item.strength}` : '';
                            const genericHtml = item.generic_name ?
                                `<div class="small text-muted">${highlightText(item.generic_name, term)}</div>` : '';

                            return `<div class="px-3 py-2 hover-bg-light cursor-pointer border-bottom"
                                        onclick="selectMedicine('${item.brand_name.replace(/'/g, "\\'")}')">
                                <div class="fw-medium">${brandHtml}${strengthHtml}</div>
                                ${genericHtml}
                                ${item.company_name ? '<small class="text-muted"><i class="fas fa-building me-1"></i>' + item.company_name + '</small>' : ''}
                            </div>`;
                        }).join('');
                        dropdown.classList.remove('d-none');
                    } else if (dropdown) {
                        dropdown.innerHTML = '<div class="px-3 py-3 text-muted text-center">No medicines found</div>';
                        dropdown.classList.remove('d-none');
                    }
                });
        }, 300);
    });

    window.selectMedicine = function(brandName) {
        searchInput.value = brandName;
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
