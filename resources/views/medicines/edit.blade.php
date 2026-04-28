@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Medicines', 'url' => route('medicines.index')],
    ['label' => 'Edit Medicine'],
];
?>
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="/medicines" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Edit Medicine</h1>
        </div>
        <p class="text-slate-500">Update medicine details below</p>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/medicines/{{ $medicine->id }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="brand_name" class="block text-sm font-medium text-slate-700 mb-1">Brand Name *</label>
                        <input type="text" id="brand_name" name="brand_name" value="{{ old('brand_name', $medicine->brand_name) }}" required
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label for="generic_name" class="block text-sm font-medium text-slate-700 mb-1">Generic Name *</label>
                        <input type="text" id="generic_name" name="generic_name" value="{{ old('generic_name', $medicine->generic_name) }}" required
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="dosage_type" class="block text-sm font-medium text-slate-700 mb-1">Dosage Type *</label>
                        <select id="dosage_type" name="dosage_type" required
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Select Type</option>
                            <option value="Tablet" {{ old('dosage_type', $medicine->dosage_type) == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Capsule" {{ old('dosage_type', $medicine->dosage_type) == 'Capsule' ? 'selected' : '' }}>Capsule</option>
                            <option value="Syrup" {{ old('dosage_type', $medicine->dosage_type) == 'Syrup' ? 'selected' : '' }}>Syrup</option>
                            <option value="Injection" {{ old('dosage_type', $medicine->dosage_type) == 'Injection' ? 'selected' : '' }}>Injection</option>
                            <option value="Cream" {{ old('dosage_type', $medicine->dosage_type) == 'Cream' ? 'selected' : '' }}>Cream</option>
                            <option value="Ointment" {{ old('dosage_type', $medicine->dosage_type) == 'Ointment' ? 'selected' : '' }}>Ointment</option>
                            <option value="Drops" {{ old('dosage_type', $medicine->dosage_type) == 'Drops' ? 'selected' : '' }}>Drops</option>
                            <option value="Inhaler" {{ old('dosage_type', $medicine->dosage_type) == 'Inhaler' ? 'selected' : '' }}>Inhaler</option>
                            <option value="Gel" {{ old('dosage_type', $medicine->dosage_type) == 'Gel' ? 'selected' : '' }}>Gel</option>
                            <option value="Patch" {{ old('dosage_type', $medicine->dosage_type) == 'Patch' ? 'selected' : '' }}>Patch</option>
                        </select>
                    </div>

                    <div>
                        <label for="strength" class="block text-sm font-medium text-slate-700 mb-1">Strength *</label>
                        <input type="text" id="strength" name="strength" value="{{ old('strength', $medicine->strength) }}" placeholder="e.g. 500mg" required
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1">Company Name</label>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $medicine->company_name) }}" placeholder="e.g. Sun Pharma"
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label for="package_mark" class="block text-sm font-medium text-slate-700 mb-1">Package Mark</label>
                        <input type="text" id="package_mark" name="package_mark" value="{{ old('package_mark', $medicine->package_mark) }}" placeholder="e.g. 10x10"
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="flex gap-2 justify-end pt-4">
                    <a href="/medicines" class="px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a1 1 0 011-1h2a1 1 0 011 1v3m-4 0a1 1 0 001 1h2a1 1 0 001-1M4 7h16"/></svg> Update Medicine
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
