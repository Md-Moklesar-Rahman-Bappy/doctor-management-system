@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Doctors', 'url' => route('doctors.index')],
    ['label' => 'Edit Doctor'],
];
?>
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('doctors.index') }}" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Edit Doctor</h1>
        </div>
        <p class="text-slate-500">Update doctor details below</p>
    </div>

    <div class="max-w-2xl mx-auto">
        <x-card>
            <form method="POST" action="{{ route('doctors.update', $doctor->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <x-input name="name" label="Name" :value="old('name', $doctor->name)" required />
                <x-input name="email" label="Email" type="email" :value="old('email', $doctor->email)" required />
                <x-input name="phone" label="Phone" :value="old('phone', $doctor->phone)" required />
                <x-textarea name="address" label="Address" :value="old('address', $doctor->address)" rows="3" required />

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Degrees</label>
                    <div id="degrees-container">
                        @if($doctor->degrees)
                            @foreach(json_decode($doctor->degrees, true) as $degree)
                        <div class="flex items-center gap-2 mb-2 degree-row">
                            <input type="text" name="degrees[]" value="{{ $degree }}" class="flex-1 px-3 py-2 border border-slate-200 rounded-lg bg-slate-50">
                            <button type="button" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg" onclick="removeDegree(this)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="mt-2 px-4 py-2 text-sm border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-600" onclick="addDegree()">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Degree
                    </button>
                </div>

                @if($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="flex gap-3 justify-end pt-4 border-t border-slate-200">
                    <a href="{{ route('doctors.index') }}" class="btn-secondary">Cancel</a>
                    <x-button type="submit">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a1 1 0 011-1h2a1 1 0 011 1v3m-4 0a1 1 0 001 1h2a1 1 0 001-1M4 7h16"/></svg>
                        Update Doctor
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>

@push('scripts')
<script>
let degreeIndex = {{ $doctor->degrees ? count(json_decode($doctor->degrees, true)) : 0 }};

function addDegree() {
    const container = document.getElementById('degrees-container');
    const html = `
        <div class="flex items-center gap-2 mb-2 degree-row">
            <input type="text" name="degrees[]" class="flex-1 px-3 py-2 border border-slate-200 rounded-lg" placeholder="e.g. MBBS">
            <button type="button" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg" onclick="removeDegree(this)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}

function removeDegree(btn) {
    btn.closest('.degree-row')?.remove();
}
</script>
@endpush
@endsection
