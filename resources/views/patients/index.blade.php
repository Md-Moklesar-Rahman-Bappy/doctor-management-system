@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-2xl font-bold text-slate-900">Patients</h3>
            <p class="text-slate-500">Manage patient records</p>
        </div>
        <a href="/patients/create" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Patient
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-200">
            <form method="GET" action="/patients" class="flex items-center gap-2">
                <div class="relative flex-1 max-w-md">
                    <input type="text" name="search" class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           placeholder="Search by Unique ID or Name..." value="{{ $search }}">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
                @if($search)
                <a href="/patients" class="px-3 py-2 text-slate-500 hover:text-slate-700">
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Unique ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Age</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Sex</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($patients as $patient)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-4"><span class="font-medium text-slate-900">{{ $patient->unique_id }}</span></td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ $patient->patient_name }}</td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ $patient->age }}</td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ ucfirst($patient->sex) }}</td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ $patient->date }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <a href="/patients/{{ $patient->id }}" class="p-3 text-sky-600 hover:bg-sky-50 rounded-lg" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7 1.274 4.057 1.274 8.057 0 12-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="/patients/{{ $patient->id }}/edit" class="p-3 text-blue-600 hover:bg-blue-50 rounded-lg" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <a href="/prescriptions/create?patient_id={{ $patient->id }}" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg" title="Create Prescription">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>
                                <a href="/lab-test-reports/create?patient_id={{ $patient->id }}" class="p-3 text-amber-600 hover:bg-amber-50 rounded-lg" title="Add Lab Report">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                </a>
                                <form action="/patients/{{ $patient->id }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-3 text-red-600 hover:bg-red-50 rounded-lg" title="Delete" onclick="return confirm('Delete this patient?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">No patients found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-slate-200">
            {{ $patients->links('components.pagination') }}
        </div>
    </div>
</div>
@endsection
