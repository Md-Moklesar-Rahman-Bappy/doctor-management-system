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
            <h3 class="text-2xl font-bold text-slate-900">Edit Prescription</h3>
        </div>
        <p class="text-slate-500">Update the prescription details</p>
    </div>

    <div class="max-w-4xl">
        <form method="POST" action="/prescriptions/{{ $prescription->id }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Doctor</label>
                        <input type="text" value="{{ $prescription->doctor->name ?? 'N/A' }}"
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-600" readonly>
                        <input type="hidden" name="doctor_id" value="{{ $prescription->doctor_id }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Patient</label>
                        <input type="text" value="{{ $prescription->patient->unique_id }} - {{ $prescription->patient->patient_name }}"
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-600" readonly>
                        <input type="hidden" name="patient_id" value="{{ $prescription->patient_id }}">
                    </div>
                </div>

                <div class="mt-4 p-4 bg-slate-50 rounded-lg">
                    <h6 class="font-semibold text-slate-700 mb-2">Patient Information</h6>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <span class="text-xs text-slate-500">Unique ID</span>
                            <p class="font-medium text-slate-900">{{ $prescription->patient->unique_id }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500">Name</span>
                            <p class="font-medium text-slate-900">{{ $prescription->patient->patient_name }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500">Age</span>
                            <p class="font-medium text-slate-900">{{ $prescription->patient->age }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500">Sex</span>
                            <p class="font-medium text-slate-900">{{ $prescription->patient->sex }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h5 class="text-lg font-semibold text-slate-900 mb-4">Problems</h5>
                <div id="problems-container">
                    @if($prescription->problem)
                        @foreach(json_decode($prescription->problem, true) as $problem)
                            <div class="flex items-center gap-2 mb-2">
                                <input type="text" class="flex-1 px-3 py-2 border border-slate-200 rounded-lg bg-slate-50" value="{{ $problem }}" readonly>
                                <button type="button" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg" onclick="removeProblem(this)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endforeach
                    @endif
                    <div class="flex items-center gap-2 mb-2">
                        <input type="text" class="flex-1 px-3 py-2 border border-slate-200 rounded-lg problem-search" placeholder="Type to search problems...">
                        <button type="button" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 text-sm font-medium" onclick="addProblem(this)">Add</button>
                    </div>
                </div>
                <input type="hidden" name="problem[]" id="problems-json" value="{{ $prescription->problem }}">
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h5 class="text-lg font-semibold text-slate-900 mb-4">Tests</h5>
                <div id="tests-container">
                    @if($prescription->tests)
                        @foreach(json_decode($prescription->tests, true) as $test)
                            <div class="flex items-center gap-2 mb-2">
                                <input type="text" class="flex-1 px-3 py-2 border border-slate-200 rounded-lg bg-slate-50" value="{{ $test }}" readonly>
                                <button type="button" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg" onclick="removeTest(this)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endforeach
                    @endif
                    <div class="flex items-center gap-2 mb-2">
                        <input type="text" class="flex-1 px-3 py-2 border border-slate-200 rounded-lg test-search" placeholder="Type to search lab tests...">
                        <button type="button" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 text-sm font-medium" onclick="addTest(this)">Add</button>
                    </div>
                </div>
                <input type="hidden" name="tests[]" id="tests-json" value="{{ $prescription->tests }}">
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h5 class="text-lg font-semibold text-slate-900 mb-4">Medicines</h5>
                <div id="medicines-container">
                    @if($prescription->medicines)
                        @foreach(json_decode($prescription->medicines, true) as $index => $medicine)
                            <div class="grid grid-cols-12 gap-2 mb-2 medicine-row items-center">
                                <div class="col-span-5">
                                    <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg" name="medicines[{{ $index }}][name]" value="{{ $medicine['name'] ?? '' }}" placeholder="Medicine name">
                                </div>
                                <div class="col-span-3">
                                    <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg" name="medicines[{{ $index }}][dosage]" value="{{ $medicine['dosage'] ?? '' }}" placeholder="Dosage (e.g. 500mg)">
                                </div>
                                <div class="col-span-3">
                                    <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg" name="medicines[{{ $index }}][frequency]" value="{{ $medicine['frequency'] ?? '' }}" placeholder="Frequency (e.g. 3x/day)">
                                </div>
                                <div class="col-span-1">
                                    <button type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" onclick="removeMedicine(this)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" class="mt-3 px-4 py-2 text-sm border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-600" onclick="addMedicine()">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Medicine
                </button>
            </div>

            <div class="flex gap-3">
                <a href="/prescriptions" class="px-6 py-2.5 border border-slate-200 rounded-lg hover:bg-slate-50 font-medium">Cancel</a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0a1 1 0 011-1h2a1 1 0 011 1v3M4 7h16"/></svg>
                    Update Prescription
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let medicineIndex = {{ $prescription->medicines ? count(json_decode($prescription->medicines, true)) : 0 }};

function addMedicine() {
    const container = document.getElementById('medicines-container');
    const html = `
        <div class="grid grid-cols-12 gap-2 mb-2 medicine-row items-center">
            <div class="col-span-5">
                <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg" name="medicines[${medicineIndex}][name]" placeholder="Medicine name">
            </div>
            <div class="col-span-3">
                <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg" name="medicines[${medicineIndex}][dosage]" placeholder="Dosage (e.g. 500mg)">
            </div>
            <div class="col-span-3">
                <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg" name="medicines[${medicineIndex}][frequency]" placeholder="Frequency (e.g. 3x/day)">
            </div>
            <div class="col-span-1">
                <button type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" onclick="removeMedicine(this)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    medicineIndex++;
}

function removeMedicine(btn) {
    btn.closest('.medicine-row').remove();
}

function addProblem(btn) {
    // Add problem logic
}

function removeProblem(btn) {
    btn.parentElement.remove();
}

function addTest(btn) {
    // Add test logic
}

function removeTest(btn) {
    btn.parentElement.remove();
}
</script>
@endpush
@endsection
