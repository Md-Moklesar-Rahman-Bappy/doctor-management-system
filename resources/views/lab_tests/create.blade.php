@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Lab Tests', 'url' => route('lab_tests.index')],
    ['label' => 'Add New Lab Test'],
];
?>
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('lab_tests.index') }}" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Add Lab Test</h1>
        </div>
        <p class="text-slate-500">Enter the test details below</p>
    </div>

    <div class="max-w-3xl">
        <x-card>
            <form action="{{ route('lab_tests.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input name="department" label="Department" :value="old('department')" placeholder="e.g., Biochemistry" required />

                    <x-input name="sample_type" label="Sample Type" :value="old('sample_type')" placeholder="e.g., Blood, Urine" required />

                    <x-input name="panel" label="Panel" :value="old('panel')" placeholder="e.g., Liver Function" required />

                    <x-input name="test" label="Test Name" :value="old('test')" placeholder="e.g., ALT, AST" required />

                    <x-input name="code" label="Code" :value="old('code')" placeholder="e.g., SGPT" />

                    <x-input name="unit" label="Unit" :value="old('unit')" placeholder="e.g., U/L, mg/dL" />

                    <x-select name="result_type" label="Result Type" :options="[
                        'Numeric' => 'Numeric',
                        'Text' => 'Text',
                        'Qualitative' => 'Qualitative',
                        'Range' => 'Range',
                    ]" :value="old('result_type')" placeholder="Select type" required />

                    <x-input name="normal_range" label="Normal Range" :value="old('normal_range')" placeholder="e.g., 7-56 or Normal" />
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-slate-200">
                    <a href="{{ route('lab_tests.index') }}" class="btn-secondary">Cancel</a>
                    <x-button type="submit">Save Test</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
