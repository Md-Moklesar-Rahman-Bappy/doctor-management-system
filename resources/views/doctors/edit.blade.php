@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Doctors', 'url' => route('doctors.index')],
    ['label' => 'Edit Doctor'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">Edit Doctor</h3>
        </div>
        <p class="text-muted">Update doctor details</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('doctors.update', $doctor->id) }}" class="d-flex flex-column gap-3">
                        @csrf
                        @method('PUT')

                        <x-input name="name" label="Full Name" icon="fas fa-user-md" required />

                        <x-input name="license" label="License Number" icon="fas fa-id-card" required />

                        <div class="row g-3">
                            <div class="col-md-6">
                                <x-input name="email" label="Email Address" icon="fas fa-envelope" type="email" required />
                            </div>
                            <div class="col-md-6">
                                <x-input name="phone" label="Phone Number" icon="fas fa-phone" type="tel" />
                            </div>
                        </div>

                        <div>
                            <label class="form-label fw-medium d-flex align-items-center gap-2">
                                <i class="fas fa-graduation-cap"></i> Degrees
                            </label>

                            <div id="degrees-container">
                                @if($doctor->degrees && count($doctor->degrees) > 0)
                                    @foreach($doctor->degrees as $index => $degree)
                                        <div class="input-group mb-2 degree-row">
                                            <input type="text" name="degrees[]" class="form-control"
                                                   value="{{ $degree }}" placeholder="e.g., MBBS">
                                            <button type="button" class="btn btn-outline-danger" onclick="removeDegree(this)" {{ $loop->first && $loop->count == 1 ? 'disabled' : '' }}>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2 degree-row">
                                        <input type="text" name="degrees[]" class="form-control"
                                               placeholder="e.g., MBBS">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeDegree(this)" disabled>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addDegree()">
                                <i class="fas fa-plus me-1"></i> Add Degree
                            </button>

                            <div class="form-text"><i class="fas fa-info-circle me-1"></i>Add all degrees one by one</div>
                            @error('degrees')
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                            @error('degrees.*')
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-medium d-flex align-items-center gap-2">
                                <i class="fas fa-map-marker-alt"></i> Address <span class="text-danger">*</span>
                            </label>
                            <textarea id="address" name="address" class="form-control"
                                      rows="3" placeholder="Enter doctor's address" required>{{ old('address', $doctor->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        @push('scripts')
                        <script>
                        let degreeCount = {{ $doctor->degrees ? count($doctor->degrees) : 1 }};

                        function addDegree() {
                            degreeCount++;
                            const container = document.getElementById('degrees-container');

                            const div = document.createElement('div');
                            div.className = 'input-group mb-2 degree-row';
                            div.innerHTML = `
                                <input type="text" name="degrees[]" class="form-control"
                                       placeholder="e.g., MD">
                                <button type="button" class="btn btn-outline-danger" onclick="removeDegree(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            `;

                            container.appendChild(div);
                            updateRemoveButtons();
                        }

                        function removeDegree(button) {
                            button.closest('.degree-row').remove();
                            degreeCount--;
                            updateRemoveButtons();
                        }

                        function updateRemoveButtons() {
                            const rows = document.querySelectorAll('.degree-row');
                            rows.forEach(row => {
                                const btn = row.querySelector('button');
                                btn.disabled = rows.length <= 1;
                            });
                        }
                        </script>
                        @endpush

                        <div class="d-flex gap-3 pt-3 border-top">
                            <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Doctor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
