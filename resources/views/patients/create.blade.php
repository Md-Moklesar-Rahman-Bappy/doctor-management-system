@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Patients', 'url' => route('patients.index')],
    ['label' => 'Add New Patient'],
];
@endphp
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('patients.index') }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h3 class="text-2xl font-bold text-gray-900">Add New Patient</h3>
        </div>
        <p class="text-gray-500">Enter patient details below</p>
    </div>

    <div class="max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('patients.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="patient_name" class="form-label">Patient Name *</label>
                    <input type="text" id="patient_name" name="patient_name" value="{{ old('patient_name') }}" required
                           class="form-input">
                    @error('patient_name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="age" class="form-label">Age *</label>
                        <input type="number" id="age" name="age" min="0" max="150" value="{{ old('age') }}" required
                               class="form-input">
                        @error('age')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sex" class="form-label">Sex *</label>
                        <select id="sex" name="sex" required class="form-input">
                            <option value="">Select</option>
                            <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('sex')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date" class="form-label">Date *</label>
                        <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                               class="form-input">
                        @error('date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="p-4 bg-blue-light-50 border border-blue-light-200 rounded-lg">
                    <div class="flex items-center gap-2 text-blue-light-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-sm">Unique ID will be auto-generated: PAT-XXXXXXXX</span>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('patients.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a1 1 0 011-1h2a1 1 0 011 1v3m-4 0a1 1 0 001 1h2a1 1 0 001-1M4 7h16"/></svg>
                        Save Patient
                    </button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
