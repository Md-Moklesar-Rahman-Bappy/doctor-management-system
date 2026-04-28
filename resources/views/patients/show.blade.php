@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Patients', 'url' => route('patients.index')],
    ['label' => 'Patient Details'],
];
?>
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="/patients" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h3 class="text-2xl font-bold text-slate-900">Patient Details</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h5 class="font-semibold text-slate-900 mb-0">Patient Information</h5>
                </div>
                <div class="p-6 space-y-3">
                    <p class="text-sm"><strong class="text-slate-700">Unique ID:</strong> <span class="text-slate-600">{{ $patient->unique_id }}</span></p>
                    <p class="text-sm"><strong class="text-slate-700">Name:</strong> <span class="text-slate-600">{{ $patient->patient_name }}</span></p>
                    <p class="text-sm"><strong class="text-slate-700">Age:</strong> <span class="text-slate-600">{{ $patient->age }}</span></p>
                    <p class="text-sm"><strong class="text-slate-700">Sex:</strong> <span class="text-slate-600">{{ ucfirst($patient->sex) }}</span></p>
                    <p class="text-sm"><strong class="text-slate-700">Date:</strong> <span class="text-slate-600">{{ $patient->date }}</span></p>
                </div>
                <div class="px-6 py-4 border-t border-slate-200">
                    <a href="/patients/{{ $patient->id }}/edit" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h5 class="font-semibold text-slate-900 mb-0">Prescription History</h5>
                </div>
                <div class="p-6">
                    @if($patient->prescriptions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Doctor</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Problems</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach($patient->prescriptions as $prescription)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $prescription->created_at->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $prescription->doctor->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        @if($prescription->problem)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach(json_decode($prescription->problem, true) as $problem)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-sky-100 text-sky-700">{{ $problem }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="/prescriptions/{{ $prescription->id }}" class="p-2 text-sky-600 hover:bg-sky-50 rounded-lg" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7 1.274 4.057 1.274 8.057 0 12-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-slate-500 text-sm">No prescriptions found.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h5 class="font-semibold text-slate-900 mb-0">Lab Test Reports</h5>
                </div>
                <div class="p-6">
                    @if($patient->labTestReports->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Test Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach($patient->labTestReports as $report)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $report->test_name }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $report->created_at->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3">
                                        <a href="/lab-test-reports/{{ $report->id }}" class="p-2 text-sky-600 hover:bg-sky-50 rounded-lg" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7 1.274 4.057 1.274 8.057 0 12-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-slate-500 text-sm">No lab reports found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="/patients" class="inline-flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to List
        </a>
    </div>
</div>
@endsection
