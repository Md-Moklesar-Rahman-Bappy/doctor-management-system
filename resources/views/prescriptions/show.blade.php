@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="/prescriptions" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h3 class="text-2xl font-bold text-slate-900">Prescription Details</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h5 class="font-semibold text-slate-900 mb-0">Prescription Info</h5>
            </div>
            <div class="p-6 space-y-3">
                <p class="text-sm"><strong class="text-slate-700">ID:</strong> <span class="text-slate-600">{{ $prescription->id }}</span></p>
                <p class="text-sm"><strong class="text-slate-700">Date:</strong> <span class="text-slate-600">{{ $prescription->created_at->format('Y-m-d H:i') }}</span></p>
                <p class="text-sm"><strong class="text-slate-700">Patient:</strong> 
                    <a href="/patients/{{ $prescription->patient->id }}" class="text-emerald-600 hover:text-emerald-700">
                        {{ $prescription->patient->unique_id }} - {{ $prescription->patient->patient_name }}
                    </a>
                </p>
                <p class="text-sm"><strong class="text-slate-700">Doctor:</strong> <span class="text-slate-600">{{ $prescription->doctor->name ?? 'N/A' }}</span></p>
            </div>
        </div>

        <div class="space-y-6">
            @if($prescription->problem)
            <div class="bg-white rounded-xl border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h5 class="font-semibold text-slate-900 mb-0">Problems</h5>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2">
                        @foreach(json_decode($prescription->problem, true) as $problem)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-sky-100 text-sky-700">{{ $problem }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if($prescription->tests)
            <div class="bg-white rounded-xl border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h5 class="font-semibold text-slate-900 mb-0">Tests</h5>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2">
                        @foreach(json_decode($prescription->tests, true) as $test)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">{{ $test }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if($prescription->medicines)
            <div class="bg-white rounded-xl border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h5 class="font-semibold text-slate-900 mb-0">Medicines</h5>
                </div>
                <div class="p-6">
                    <table class="w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Medicine</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Dosage</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Frequency</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach(json_decode($prescription->medicines, true) as $medicine)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $medicine['name'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $medicine['dosage'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $medicine['frequency'] ?? 'N/A' }}</td>
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
        <a href="/prescriptions/{{ $prescription->id }}/edit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
        </a>
        <a href="/prescriptions" class="px-6 py-2.5 border border-slate-200 rounded-lg hover:bg-slate-50 font-medium">Back to List</a>
    </div>
</div>
@endsection
