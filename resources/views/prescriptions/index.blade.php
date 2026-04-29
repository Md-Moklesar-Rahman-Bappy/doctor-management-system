@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-2xl font-bold text-slate-900">Prescriptions</h3>
            <p class="text-slate-500">Manage patient prescriptions</p>
        </div>
        <a href="/prescriptions/create" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Prescription
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-200">
            <form method="GET" action="/prescriptions" class="flex items-center gap-2" id="search-form">
                <div class="relative flex-1 max-w-md">
                    <input type="text" name="search" id="search-input" class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           placeholder="Search by patient name or unique ID..." value="{{ $search }}" autocomplete="off">
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
                <a href="/prescriptions" class="px-3 py-2 text-slate-500 hover:text-slate-700">
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
                            <a href="/prescriptions?sort=id&direction={{ request('direction') == 'asc' ? 'desc' : 'asc' }}&search={{ $search }}" class="hover:text-emerald-600">
                                ID
                                @if(request('sort') == 'id')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Patient</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Doctor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">
                            <a href="/prescriptions?sort=created_at&direction={{ request('direction') == 'asc' ? 'desc' : 'asc' }}&search={{ $search }}" class="hover:text-emerald-600">
                                Date
                                @if(request('sort') == 'created_at')
                                    <span>{!! request('direction') == 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Problems</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($prescriptions as $prescription)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-4 text-sm">{{ $prescription->id }}</td>
                        <td class="px-4 py-4 text-sm font-medium">
                            <a href="/patients/{{ $prescription->patient->id }}" class="text-emerald-600 hover:text-emerald-700">
                                {{ $prescription->patient->unique_id }} - {{ $prescription->patient->patient_name }}
                            </a>
                        </td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ $prescription->doctor->name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ $prescription->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-4">
                            @if($prescription->problem)
                                @foreach(json_decode($prescription->problem, true) as $problem)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-sky-100 text-sky-700 mr-1">{{ $problem }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <a href="/prescriptions/{{ $prescription->id }}" class="p-3 text-sky-600 hover:bg-sky-50 rounded-lg" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7 1.274 4.057 1.274 8.057 0 12-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="/prescriptions/{{ $prescription->id }}/edit" class="p-3 text-blue-600 hover:bg-blue-50 rounded-lg" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="/prescriptions/{{ $prescription->id }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-3 text-red-600 hover:bg-red-50 rounded-lg" title="Delete" onclick="return confirm('Delete this prescription?')">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div>
                                    <p class="text-lg font-medium text-slate-500">No prescriptions found</p>
                                    <p class="text-sm text-slate-400 mt-1">Create your first prescription to get started</p>
                                </div>
                                <a href="{{ route('prescriptions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Create Prescription
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-slate-200">
            {{ $prescriptions->links('components.pagination') }}
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
            fetch('/patients/autocomplete?term=' + encodeURIComponent(term))
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        dropdown.innerHTML = data.map(item =>
                            `<div class="px-4 py-2 hover:bg-slate-50 cursor-pointer" onclick="window.location='/prescriptions?search=${encodeURIComponent(item.unique_id)}'">
                                <span class="font-medium">${item.unique_id}</span> - ${item.patient_name}
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
