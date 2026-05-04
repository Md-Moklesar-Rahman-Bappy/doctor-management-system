@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Doctors', 'url' => route('doctors.index')],
    ['label' => 'Add New Doctor'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">Add New Doctor</h3>
        </div>
        <p class="text-muted">Enter doctor details below</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('doctors.store') }}" class="d-flex flex-column gap-3">
                        @csrf

                        <div>
                            <label for="name" class="form-label fw-medium">Full Name *</label>
                            <div class="input-icon-wrapper">
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                       class="form-control ps-4" placeholder="Dr. John Smith">
                                <div class="icon"><i class="fas fa-user-md"></i></div>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-medium">Email Address *</label>
                                <div class="input-icon-wrapper">
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                           class="form-control ps-4" placeholder="doctor@hospital.com">
                                    <div class="icon"><i class="fas fa-envelope"></i></div>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-medium">Phone Number</label>
                                <div class="input-icon-wrapper">
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                           class="form-control ps-4" placeholder="+1 (555) 123-4567">
                                    <div class="icon"><i class="fas fa-phone"></i></div>
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="form-label fw-medium">Degrees</label>

                            <div id="degrees-container">
                                <!-- First degree input (default) -->
                                <div class="input-group mb-2 degree-row">
                                    <div class="input-icon-wrapper flex-1">
                                        <input type="text" name="degrees[]" class="form-control ps-4"
                                               placeholder="e.g., MBBS" value="{{ old('degrees.0') }}">
                                        <div class="icon"><i class="fas fa-graduation-cap"></i></div>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger" onclick="removeDegree(this)" disabled>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
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

                        <div>
                            <label for="address" class="form-label fw-medium">Address *</label>
                            <div class="input-icon-wrapper">
                                <textarea id="address" name="address" class="form-control ps-4" rows="3"
                                          placeholder="Enter doctor's address" required>{{ old('address') }}</textarea>
                                <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                            </div>
                            @error('address')
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        @push('scripts')
                        <script>
                        let degreeCount = 1;

                        function addDegree() {
                            degreeCount++;
                            const container = document.getElementById('degrees-container');

                            const div = document.createElement('div');
                            div.className = 'input-group mb-2 degree-row';
                            div.innerHTML = `
                                <div class="input-icon-wrapper flex-1">
                                    <input type="text" name="degrees[]" class="form-control ps-4"
                                           placeholder="e.g., MD">
                                    <div class="icon"><i class="fas fa-graduation-cap"></i></div>
                                </div>
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
                                <i class="fas fa-save me-1"></i> Save Doctor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
