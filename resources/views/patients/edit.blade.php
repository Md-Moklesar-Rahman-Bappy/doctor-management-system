@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="/patients" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h3 class="text-2xl font-bold text-slate-900">Edit Patient</h3>
        </div>
        <p class="text-slate-500">Update patient details below</p>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <form method="POST" action="/patients/{{ $patient->id }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Unique ID</label>
                    <input type="text" value="{{ $patient->unique_id }}" disabled
                           class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-500">
                </div>

                <div>
                    <label for="patient_name" class="block text-sm font-medium text-slate-700 mb-1">Patient Name *</label>
                    <input type="text" id="patient_name" name="patient_name" value="{{ $patient->patient_name }}" required
                           class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="age" class="block text-sm font-medium text-slate-700 mb-1">Age *</label>
                        <input type="number" id="age" name="age" min="0" max="150" value="{{ $patient->age }}" required
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label for="sex" class="block text-sm font-medium text-slate-700 mb-1">Sex *</label>
                        <select id="sex" name="sex" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="male" {{ $patient->sex == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $patient->sex == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-slate-700 mb-1">Date *</label>
                        <input type="date" id="date" name="date" value="{{ $patient->date }}" required
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="/patients/{{ $patient->id }}" class="px-6 py-2.5 border border-slate-200 rounded-lg hover:bg-slate-50">Cancel</a>
                    <button type="submit" class="px-6 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 font-medium">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0a1 1 0 011-1h2a1 1 0 011 1v3m-4 0a1 1 0 001 1h2a1 1 0 001-1M4 7h16"/></svg>
                        Update Patient
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
