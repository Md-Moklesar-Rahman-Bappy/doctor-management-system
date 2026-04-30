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
            <form method="GET" action="{{ route('problems.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
                <div class="input-group flex-1" style="max-width: 400px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           class="form-control border-start-0" placeholder="Search diagnoses...">
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
@endsection
