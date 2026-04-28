@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-2xl font-bold text-slate-900">Lab Test Reports</h3>
            <p class="text-slate-500">Manage patient lab test reports</p>
        </div>
        <a href="/lab-test-reports/create" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Report
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-200">
            <form method="GET" action="/lab-test-reports" class="flex items-center gap-2">
                <div class="relative flex-1 max-w-md">
                    <input type="text" name="search" class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           placeholder="Search by test name or patient unique ID..." value="{{ $search }}">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
                @if($search)
                <a href="/lab-test-reports" class="px-3 py-2 text-slate-500 hover:text-slate-700">
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Patient</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Test Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Has Image</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($reports as $report)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-4 text-sm">{{ $report->id }}</td>
                        <td class="px-4 py-4 text-sm font-medium">
                            <a href="/patients/{{ $report->patient->id }}" class="text-emerald-600 hover:text-emerald-700">
                                {{ $report->patient->unique_id }} - {{ $report->patient->patient_name }}
                            </a>
                        </td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ $report->test_name }}</td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ $report->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-4">
                            @if($report->report_image)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Yes</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <a href="/lab-test-reports/{{ $report->id }}" class="p-3 text-sky-600 hover:bg-sky-50 rounded-lg" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7 1.274 4.057 1.274 8.057 0 12-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="/lab-test-reports/{{ $report->id }}/edit" class="p-3 text-blue-600 hover:bg-blue-50 rounded-lg" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="/lab-test-reports/{{ $report->id }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-3 text-red-600 hover:bg-red-50 rounded-lg" title="Delete" onclick="return confirm('Delete this report?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">No lab test reports found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-slate-200">
            {{ $reports->links('components.pagination') }}
        </div>
    </div>
</div>
@endsection
