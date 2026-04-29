@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Prescriptions', 'url' => route('prescriptions.index')],
];
@endphp
<div>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="page-title">Prescriptions</h3>
            <p class="page-description">Manage patient prescriptions</p>
        </div>
        <a href="{{ route('prescriptions.create') }}" class="btn-primary inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Prescription
        </a>
    </div>

    <x-card>
        <!-- Filter/Search Header -->
        <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <form method="GET" action="{{ route('prescriptions.index') }}" class="flex items-center gap-2 flex-1">
                <div class="relative flex-1 max-w-md" x-data="{ open: false, term: '{{ $search ?? '' }}' }" @click.away="open = false">
                    <input type="text" name="search" x-model="term" @input.debounce.300ms="
                            if (term.length >= 2) {
                                fetch('/patients/autocomplete?term=' + encodeURIComponent(term))
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success && data.data.length > 0) {
                                            open = true;
                                        }
                                    });
                            } else {
                                open = false;
                            }
                        " class="search-input" placeholder="Search by patient name or unique ID..." autocomplete="off">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
                @if($search)
                <a href="{{ route('prescriptions.index') }}" class="px-3 py-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Clear
                </a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>
                            <a href="{{ route('prescriptions.index', ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-primary-600 flex items-center gap-1">
                                Date
                                @if(request('sort') == 'created_at')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th>Problems</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($prescriptions as $prescription)
                    <tr>
                        <td class="text-gray-600">{{ $prescription->id }}</td>
                        <td>
                            <a href="{{ route('patients.show', $prescription->patient->id) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                {{ $prescription->patient->unique_id }} - {{ $prescription->patient->patient_name }}
                            </a>
                        </td>
                        <td class="text-gray-600">{{ $prescription->doctor->name ?? 'N/A' }}</td>
                        <td class="text-gray-600">{{ $prescription->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($prescription->problem)
                                <div class="flex flex-wrap gap-1">
                                    @foreach(json_decode($prescription->problem, true) as $problem)
                                        <span class="badge-info">{{ $problem }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-1">
                                <a href="{{ route('prescriptions.show', $prescription->id) }}" class="p-2 text-brand-600 hover:bg-brand-50 rounded-lg transition-colors" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7 1.274 4.057 1.274 8.057 0 12-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('prescriptions.edit', $prescription->id) }}" class="p-2 text-blue-light-600 hover:bg-blue-light-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button onclick="confirmDelete('{{ route('prescriptions.destroy', $prescription->id) }}', 'Prescription #{{ $prescription->id }}')" class="p-2 text-error-600 hover:bg-error-50 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12">
                            <x-empty-state
                                title="No prescriptions found"
                                description="Create your first prescription to get started"
                            >
                                <x-slot:action>
                                    <a href="{{ route('prescriptions.create') }}" class="btn-primary inline-flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Create Prescription
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
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $prescriptions->links('components.pagination') }}
        </div>
        @endif
    </x-card>
</div>

@push('scripts')
<script>
function confirmDelete(url, name) {
    if (confirm('Are you sure you want to delete ' + name + '?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.innerHTML = '@csrf<input type="hidden" name="_method" value="DELETE">';
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection
