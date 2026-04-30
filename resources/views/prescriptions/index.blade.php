@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Prescriptions', 'url' => route('prescriptions.index')],
];
@endphp

<div>
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3" data-aos="fade-down">
        <div>
            <h3 class="page-title mb-1">Prescriptions</h3>
            <p class="page-description mb-0">Manage patient prescriptions</p>
        </div>
        <a href="{{ route('prescriptions.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fas fa-file-prescription me-1"></i> Create Prescription
        </a>
    </div>

    <div class="card shadow-sm" data-aos="fade-up">
        <div class="card-header bg-white border-bottom">
            <form method="GET" action="{{ route('prescriptions.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
                <div class="input-group flex-1" style="max-width: 400px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           class="form-control border-start-0" placeholder="Search prescriptions...">
                </div>
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search me-1"></i>Search
                </button>
                @if($search)
                    <a href="{{ route('prescriptions.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Medicines</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $prescription)
                    <tr>
                        <td><span class="fw-medium">#{{ $prescription->id }}</span></td>
                        <td>
                            <a href="{{ route('patients.show', $prescription->patient->id) }}" class="text-decoration-none">
                                {{ $prescription->patient->patient_name ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="text-muted">{{ $prescription->doctor->name ?? 'N/A' }}</td>
                        <td class="text-muted">{{ $prescription->prescription_date ?? $prescription->created_at->format('Y-m-d') }}</td>
                        <td>
                            <span class="badge bg-info-subtle text-info-emphasis">{{ count(json_decode($prescription->medicines, true) ?? []) }} items</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('prescriptions.show', $prescription->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('prescriptions.edit', $prescription->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('prescriptions.destroy', $prescription->id) }}" class="d-inline">
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
                        <td colspan="6" class="py-5">
                            <x-empty-state
                                title="No prescriptions found"
                                description="Create your first prescription to get started"
                            >
                                <x-slot:action>
                                    <a href="{{ route('prescriptions.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                                        <i class="fas fa-file-prescription me-1"></i> Create Prescription
                                    </a>
                                </x-slot:action>
                            </x-empty-state>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($prescriptions->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $prescriptions->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
