@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Doctors', 'url' => route('doctors.index')],
];
?>
<div>
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-2xl font-bold text-slate-900">Doctors</h3>
            <p class="text-slate-500">Manage doctor records</p>
        </div>
        <a href="{{ route('doctors.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Doctor
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-200">
            <form method="GET" action="/doctors" class="flex items-center gap-2" id="search-form">
                <div class="relative flex-1 max-w-md">
                    <input type="text" name="search" id="search-input" class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           placeholder="Search by name, email, phone..." value="{{ $search }}" autocomplete="off">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <div id="autocomplete-dropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-lg max-h-60 overflow-y-auto"></div>
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
                @if($search)
                <a href="{{ route('doctors.index') }}" class="px-3 py-2 text-slate-500 hover:text-slate-700">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Clear
                </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">
                            <a href="{{ route('doctors.index', ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-emerald-600">
                                ID
                                @if(request('sort') == 'id')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">
                            <a href="{{ route('doctors.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-emerald-600">
                                Name
                                @if(request('sort') == 'name')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">
                            <a href="{{ route('doctors.index', ['sort' => 'email', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-emerald-600">
                                Email
                                @if(request('sort') == 'email')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Degrees</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($doctors as $doctor)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-4 text-sm">{{ $doctor->id }}</td>
                        <td class="px-4 py-4 text-sm font-medium text-slate-900">{{ $doctor->name }}</td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ $doctor->email }}</td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ $doctor->phone }}</td>
                        <td class="px-4 py-4">
                            @if($doctor->degrees)
                                <div class="flex flex-wrap gap-1">
                                    @foreach(json_decode($doctor->degrees, true) as $degree)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-sky-100 text-sky-700">{{ $degree }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('doctors.show', $doctor->id) }}" class="p-3 text-sky-600 hover:bg-sky-50 rounded-lg" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7 1.274 4.057 1.274 8.057 0 12-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('doctors.edit', $doctor->id) }}" class="p-3 text-blue-600 hover:bg-blue-50 rounded-lg" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="/doctors/{{ $doctor->id }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-3 text-red-600 hover:bg-red-50 rounded-lg" title="Delete" onclick="return confirm('Delete this doctor?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <div>
                                    <p class="text-lg font-medium text-slate-500">No doctors found</p>
                                    <p class="text-sm text-slate-400 mt-1">Add your first doctor to get started</p>
                                </div>
                                <a href="{{ route('doctors.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Add Doctor
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-slate-200">
            {{ $doctors->links('components.pagination') }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const dropdown = document.getElementById('autocomplete-dropdown');
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const term = this.value.trim();

        if (term.length < 2) {
            dropdown.classList.add('hidden');
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch('/doctors/autocomplete?term=' + encodeURIComponent(term))
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        dropdown.innerHTML = data.map(item =>
                            `<div class="px-4 py-2 hover:bg-slate-50 cursor-pointer" onclick="window.location='/doctors?search=${encodeURIComponent(item.name)}'">
                                <span class="font-medium">${item.name}</span> - ${item.email || ''}
                            </div>`
                        ).join('');
                        dropdown.classList.remove('hidden');
                    } else {
                        dropdown.classList.add('hidden');
                    }
                });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target) && e.target !== searchInput) {
            dropdown.classList.add('hidden');
        }
    });
});
</script>
@endpush
