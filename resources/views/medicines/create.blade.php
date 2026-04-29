@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Medicines', 'url' => route('medicines.index')],
    ['label' => 'Add New Medicine'],
];
?>
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('medicines.index') }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Add New Medicine</h1>
        </div>
        <p class="text-gray-500">Enter medicine details below</p>
    </div>
        <p class="text-gray-500">Enter medicine details below</p>
    </div>

    <div class="max-w-2xl mx-auto">
        <x-card>
            <form action="{{ route('medicines.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input name="brand_name" label="Brand Name" :value="old('brand_name')" required />

                    <x-input name="generic_name" label="Generic Name" :value="old('generic_name')" required />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-select name="dosage_type" label="Dosage Type" :options="[
                        'Tablet' => 'Tablet',
                        'Capsule' => 'Capsule',
                        'Syrup' => 'Syrup',
                        'Injection' => 'Injection',
                        'Cream' => 'Cream',
                        'Ointment' => 'Ointment',
                        'Drops' => 'Drops',
                        'Inhaler' => 'Inhaler',
                        'Gel' => 'Gel',
                        'Patch' => 'Patch',
                    ]" :value="old('dosage_type')" placeholder="Select Type" required />

                    <x-input name="strength" label="Strength" :value="old('strength')" placeholder="e.g. 500mg" required />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input name="company_name" label="Company Name" :value="old('company_name')" placeholder="e.g. Sun Pharma" />

                    <x-input name="package_mark" label="Package Mark" :value="old('package_mark')" placeholder="e.g. 10x10" />
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-gray-200">
                    <a href="{{ route('medicines.index') }}" class="btn-secondary">Cancel</a>
                    <x-button type="submit">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a1 1 0 011-1h2a1 1 0 011 1v3m-4 0a1 1 0 001 1h2a1 1 0 001-1M4 7h16"/></svg>
                        Save Medicine
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
