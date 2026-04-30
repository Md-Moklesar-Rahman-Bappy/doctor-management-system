@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Doctors', 'url' => route('doctors.index')],
];
@endphp

<div>
    <!-- Page Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3" data-aos="fade-down">
        <div>
            <h3 class="page-title mb-1">Doctors</h3>
            <p class="page-description mb-0">Manage doctor records</p>
        </div>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fas fa-user-md me-1"></i> Add Doctor
        </a>
    </div>

    <div class="card shadow-sm" data-aos="fade-up">
        <!-- Filter/Search Header -->
        <div class="card-header bg-white border-bottom">
            <form method="GET" action="{{ route('doctors.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
                <div class="input-group flex-1" style="max-width: 400px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           class="form-control border-start-0" placeholder="Search by name, email, phone...">
                </div>
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search me-1"></i>Search
                </button>
                @if($search)
                    <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary">
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
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Degrees</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doctor)
                    <tr>
                        <td class="text-muted">{{ $doctor->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <span class="fw-semibold text-primary small text-uppercase">{{ substr($doctor->name, 0, 2) }}</span>
                                </div>
                                <div>
                                    <div class="fw-medium">{{ $doctor->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted">{{ $doctor->email }}</td>
                        <td class="text-muted">{{ $doctor->phone }}</td>
                        <td>
                            @if($doctor->degrees)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach(json_decode($doctor->degrees, true) as $degree)
                                        <span class="badge bg-info-subtle text-info-emphasis">{{ $degree }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete('/doctors/{{ $doctor->id }}', '{{ $doctor->name }}')" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-5">
                            <x-empty-state
                                title="No doctors found"
                                description="Add your first doctor to get started"
                            >
                                <x-slot:action>
                                    <a href="{{ route('doctors.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                                        <i class="fas fa-user-md me-1"></i> Add Doctor
                                    </a>
                                </x-slot:action>
                            </x-empty-state>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($doctors->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $doctors->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
