@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Patients', 'url' => route('patients.index')],
    ['label' => 'Edit Patient'],
];
?>
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('patients.index') }}" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Edit Patient</h1>
        </div>
        <p class="text-slate-500">Update patient details below</p>
    </div>

    <div class="max-w-2xl mx-auto">
        <x-card>
            <form method="POST" action="{{ route('patients.update', $patient->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Unique ID</label>
                    <input type="text" value="{{ $patient->unique_id }}" disabled
                           class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-500">
                </div>

                <x-input name="patient_name" label="Patient Name" :value="old('patient_name', $patient->patient_name)" required />

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <x-input name="age" label="Age" type="number" :value="old('age', $patient->age)" min="0" max="150" required />

                    <x-select name="sex" label="Sex" :options="['male' => 'Male', 'female' => 'Female']" :value="old('sex', $patient->sex)" placeholder="Select" required />

                    <x-input name="date" label="Date" type="date" :value="old('date', $patient->date)" required />
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-slate-200">
                    <a href="{{ route('patients.index') }}" class="btn-secondary">Cancel</a>
                    <x-button type="submit">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a1 1 0 011-1h2a1 1 0 011 1v3m-4 0a1 1 0 001 1h2a1 1 0 001-1M4 7h16"/></svg>
                        Update Patient
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
