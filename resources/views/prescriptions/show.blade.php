@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Prescriptions', 'url' => route('prescriptions.index')],
    ['label' => 'Prescription Details'],
];
?>
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="/prescriptions" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h3 class="text-2xl font-bold text-gray-900">Prescription Details</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h5 class="font-semibold text-gray-900 mb-0">Prescription Info</h5>
            </div>
            <div class="p-6 space-y-3">
                <p class="text-sm"><strong class="text-gray-700">ID:</strong> <span class="text-gray-600">{{ $prescription->id }}</span></p>
                <p class="text-sm"><strong class="text-gray-700">Date:</strong> <span class="text-gray-600">{{ $prescription->created_at->format('Y-m-d H:i') }}</span></p>
                <p class="text-sm"><strong class="text-gray-700">Patient:</strong> 
                    <a href="/patients/{{ $prescription->patient->id }}" class="text-brand-600 hover:text-brand-700">
                        {{ $prescription->patient->unique_id }} - {{ $prescription->patient->patient_name }}
                    </a>
                </p>
                <p class="text-sm"><strong class="text-gray-700">Doctor:</strong> <span class="text-gray-600">{{ $prescription->doctor->name ?? 'N/A' }}</span></p>
            </div>
        </div>

        <div class="space-y-6">
            @if($prescription->problem)
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h5 class="font-semibold text-gray-900 mb-0">Problems</h5>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2">
                        @foreach(json_decode($prescription->problem, true) as $problem)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-light-100 text-blue-light-700">{{ $problem }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if($prescription->tests)
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h5 class="font-semibold text-gray-900 mb-0">Tests</h5>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2">
                        @foreach(json_decode($prescription->tests, true) as $test)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-100 text-warning-700">{{ $test }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if($prescription->medicines)
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h5 class="font-semibold text-gray-900 mb-0">Medicines</h5>
                </div>
                <div class="p-6">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Medicine</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Dosage</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Frequency</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach(json_decode($prescription->medicines, true) as $medicine)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $medicine['name'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $medicine['dosage'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $medicine['frequency'] ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="/prescriptions/{{ $prescription->id }}/edit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-warning-500 hover:bg-warning-600 text-white font-medium rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
        </a>
        <a href="/prescriptions" class="px-6 py-2.5 border border-gray-200 rounded-lg hover:bg-gray-50 font-medium">Back to List</a>
    </div>
</div>
@endsection
