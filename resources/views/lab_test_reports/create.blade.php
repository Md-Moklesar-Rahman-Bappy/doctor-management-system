@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Lab Reports', 'url' => route('lab_test_reports.index')],
    ['label' => 'Add New Lab Report'],
];
?>
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('lab_test_reports.index') }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Add Lab Test Report</h1>
        </div>
        <p class="text-gray-500">Fill in the report details</p>
    </div>

    <div class="max-w-2xl mx-auto">
        <x-card>
            <form method="POST" action="{{ route('lab_test_reports.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <x-select name="patient_id" label="Patient" :options="$patients->pluck('patient_name', 'id')->toArray()" :value="old('patient_id', $selectedPatientId ?? '')" placeholder="Select Patient" required />

                <x-input name="test_name" label="Test Name" :value="old('test_name')" required />

                <x-textarea name="report_text" label="Report Text" :value="old('report_text')" rows="4" />

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Report Images</label>
                    <div id="images-container">
                        <div class="flex items-center gap-2 mb-2 image-row">
                            <x-file-input name="report_images[]" accept="image/*" class="flex-1" />
                            <button type="button" class="px-4 py-2 text-error-600 hover:bg-error-50 rounded-lg" onclick="removeImage(this)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="mt-2 px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-600" onclick="addImage()">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add More Images
                    </button>
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-gray-200">
                    <a href="{{ route('lab_test_reports.index') }}" class="btn-secondary">Cancel</a>
                    <x-button type="submit">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a1 1 0 011-1h2a1 1 0 011 1v3m-4 0a1 1 0 001 1h2a1 1 0 001-1m-4 0h8"/></svg>
                        Save Report
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>

@push('scripts')
<script>
let imageIndex = 1;

function addImage() {
    const container = document.getElementById('images-container');
    const html = `
        <div class="flex items-center gap-2 mb-2 image-row">
            <input type="file" name="report_images[]" accept="image/*" class="flex-1 px-3 py-2 border border-gray-200 rounded-lg">
            <button type="button" class="px-4 py-2 text-error-600 hover:bg-error-50 rounded-lg" onclick="removeImage(this)">
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
