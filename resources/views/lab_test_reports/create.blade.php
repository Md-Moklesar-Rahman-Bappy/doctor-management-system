@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="/lab-test-reports" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h3 class="text-2xl font-bold text-slate-900">Add Lab Test Report</h3>
        </div>
        <p class="text-slate-500">Fill in the report details</p>
    </div>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="/lab-test-reports" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div>
                    <label for="patient_id" class="block text-sm font-medium text-slate-700 mb-1">Patient *</label>
                    <select id="patient_id" name="patient_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ ($selectedPatientId ?? '') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->unique_id }} - {{ $patient->patient_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="test_name" class="block text-sm font-medium text-slate-700 mb-1">Test Name *</label>
                    <input type="text" id="test_name" name="test_name" required
                           class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="mt-4">
                    <label for="report_text" class="block text-sm font-medium text-slate-700 mb-1">Report Text</label>
                    <textarea id="report_text" name="report_text" rows="4"
                              class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Report Images</label>
                    <div id="images-container">
                        <div class="flex items-center gap-2 mb-2 image-row">
                            <input type="file" name="report_images[]" accept="image/*" class="flex-1 px-3 py-2 border border-slate-200 rounded-lg">
                            <button type="button" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg" onclick="removeImage(this)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="mt-2 px-4 py-2 text-sm border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-600" onclick="addImage()">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add More Images
                    </button>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="/lab-test-reports" class="px-6 py-2.5 border border-slate-200 rounded-lg hover:bg-slate-50 font-medium">Cancel</a>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a1 1 0 011-1h2a1 1 0 011 1v3m-4 0a1 1 0 001 1h2a1 1 0 001-1m-4 0h8"/></svg>
                    Save Report
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let imageIndex = 1;

function addImage() {
    const container = document.getElementById('images-container');
    const html = `
        <div class="flex items-center gap-2 mb-2 image-row">
            <input type="file" name="report_images[]" accept="image/*" class="flex-1 px-3 py-2 border border-slate-200 rounded-lg">
            <button type="button" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg" onclick="removeImage(this)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}

function removeImage(btn) {
    btn.closest('.image-row')?.remove();
}
</script>
@endpush
@endsection
