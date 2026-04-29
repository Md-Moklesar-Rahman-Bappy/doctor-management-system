@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Doctors', 'url' => route('doctors.index')],
    ['label' => 'Add New Doctor'],
];
@endphp
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('doctors.index') }}" class="p-2 text-secondary-500 hover:text-secondary-700 hover:bg-secondary-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h3 class="text-2xl font-bold text-secondary-900">Add New Doctor</h3>
        </div>
        <p class="text-secondary-500">Enter doctor details below</p>
    </div>

    <div class="max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('doctors.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="form-input">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="form-input">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="form-label">Phone *</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                           class="form-input">
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="form-label">Address *</label>
                    <textarea id="address" name="address" required rows="3"
                              class="form-input">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Degrees</label>
                    <div id="degrees-container">
                        <div class="flex items-center gap-2 mb-2 degree-row">
                            <input type="text" name="degrees[]" class="flex-1 form-input" placeholder="e.g. MBBS">
                            <button type="button" class="p-2 text-danger hover:bg-red-50 rounded-lg" onclick="removeDegree(this)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="mt-2 px-4 py-2 text-sm border border-secondary-300 rounded-lg hover:bg-secondary-50 text-secondary-600" onclick="addDegree()">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Degree
                    </button>
                </div>

                @if($errors->any())
                    <x-alert variant="danger">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert>
                @endif

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('doctors.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a1 1 0 011-1h2a1 1 0 011 1v3m-4 0a1 1 0 001 1h2a1 1 0 001-1M4 7h16"/></svg>
                        Save Doctor
                    </button>
                </div>
            </form>
        </x-card>
    </div>
</div>

@push('scripts')
<script>
let degreeIndex = 1;

function addDegree() {
    const container = document.getElementById('degrees-container');
    const html = `
        <div class="flex items-center gap-2 mb-2 degree-row">
            <input type="text" name="degrees[]" class="flex-1 form-input" placeholder="e.g. MBBS">
            <button type="button" class="p-2 text-danger hover:bg-red-50 rounded-lg" onclick="removeDegree(this)">
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
