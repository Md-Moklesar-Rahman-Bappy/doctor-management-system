@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Doctors', 'url' => route('doctors.index')],
];
@endphp
<div>
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-2xl font-bold text-secondary-900">Doctors</h3>
            <p class="text-secondary-500">Manage doctor records</p>
        </div>
        <a href="{{ route('doctors.create') }}" class="btn-primary inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Doctor
        </a>
    </div>

    <x-card>
        <div class="p-4 border-b border-secondary-200">
            <form method="GET" action="{{ route('doctors.index') }}" class="flex items-center gap-2" id="search-form">
                <div class="relative flex-1 max-w-md" x-data="{ open: false, term: '{{ $search ?? '' }}' }" @click.away="open = false">
                    <input type="text" name="search" x-model="term" @input.debounce.300ms="
                        if (term.length >= 2) {
                            fetch('/doctors/autocomplete?term=' + encodeURIComponent(term))
                                .then(res => res.json())
                                .then(data => {
                                    if (data.length > 0) {
                                        open = true;
                                    }
                                });
                        } else {
                            open = false;
                        }
                    " class="w-full pl-10 pr-4 py-2 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           placeholder="Search by name, email, phone..." autocomplete="off">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <div x-show="open" x-transition class="absolute z-50 w-full mt-1 bg-white border border-secondary-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        <template x-if="term.length >= 2">
                            <div class="p-4 text-sm text-secondary-500">Type to search...</div>
                        </template>
                    </div>
                </div>
                <button type="submit" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
                @if($search)
                <a href="{{ route('doctors.index') }}" class="px-3 py-2 text-secondary-500 hover:text-secondary-700">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Clear
                </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-secondary-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-secondary-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-secondary-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-secondary-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-secondary-500 uppercase tracking-wider">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-secondary-500 uppercase tracking-wider">Degrees</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-secondary-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-200">
                    @forelse($doctors as $doctor)
                    <tr class="table-hover">
                        <td class="px-4 py-4 text-sm text-secondary-600">{{ $doctor->id }}</td>
                        <td class="px-4 py-4 text-sm font-medium text-secondary-900">{{ $doctor->name }}</td>
                        <td class="px-4 py-4 text-sm text-secondary-600">{{ $doctor->email }}</td>
                        <td class="px-4 py-4 text-sm text-secondary-600">{{ $doctor->phone }}</td>
                        <td class="px-4 py-4">
                            @if($doctor->degrees)
                                <div class="flex flex-wrap gap-1">
                                    @foreach(json_decode($doctor->degrees, true) as $degree)
                                        <span class="badge-info">{{ $degree }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('doctors.show', $doctor->id) }}" class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7 1.274 4.057 1.274 8.057 0 12-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('doctors.edit', $doctor->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button onclick="confirmDelete('/doctors/{{ $doctor->id }}', '{{ $doctor->name }}')" class="p-2 text-danger hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12">
                            <x-empty-state
                                title="No doctors found"
                                description="Add your first doctor to get started"
                            >
                                <x-slot:action>
                                    <a href="{{ route('doctors.create') }}" class="btn-primary inline-flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Add Doctor
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
        <div class="px-4 py-3 border-t border-secondary-200">
            {{ $doctors->links('components.pagination') }}
        </div>
        @endif
    </x-card>
</div>
@endsection
