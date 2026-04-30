@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Patients', 'url' => route('patients.index')],
];
@endphp

<div>
    <!-- Page Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3" data-aos="fade-down">
        <div>
            <h3 class="page-title mb-1">Patients</h3>
            <p class="page-description mb-0">Manage patient records</p>
        </div>
        <a href="{{ route('patients.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fas fa-user-plus"></i> Add Patient
        </a>
    </div>

    <div class="card shadow-sm" data-aos="fade-up">
        <!-- Filter/Search Header -->
        <div class="card-header bg-white border-bottom">
            <form method="GET" action="{{ route('patients.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
                <div class="input-group flex-1" style="max-width: 400px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           class="form-control border-start-0" placeholder="Search by Unique ID or Name...">
                </div>
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search me-1"></i>Search
                </button>
                @if($search)
                    <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">
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
                        <th>Unique ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td><span class="fw-medium">{{ $patient->unique_id }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <span class="fw-semibold text-success small text-uppercase">{{ substr($patient->patient_name, 0, 2) }}</span>
                                </div>
                                <div>
                                    <div class="fw-medium">{{ $patient->patient_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted">{{ $patient->age }}</td>
                        <td class="text-muted">{{ ucfirst($patient->sex) }}</td>
                        <td class="text-muted">{{ $patient->date }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('prescriptions.create') }}?patient_id={{ $patient->id }}" class="btn btn-sm btn-outline-success" title="Create Prescription">
                                    <i class="fas fa-file-prescription"></i>
                                </a>
                                <button onclick="confirmDelete('{{ route('patients.destroy', $patient->id) }}', '{{ $patient->patient_name }}')" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-5">
                            <x-empty-state
                                title="No patients found"
                                description="Add your first patient to get started"
                            >
                                <x-slot:action>
                                    <a href="{{ route('patients.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                                        <i class="fas fa-user-plus"></i> Add Patient
                                    </a>
                                </x-slot:action>
                            </x-empty-state>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($patients->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $patients->links('components.pagination') }}
            </div>
        @endif
    </x-card>
</div>
@endsection
