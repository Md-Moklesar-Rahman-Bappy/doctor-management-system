@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Dashboard', 'url' => route('dashboard')],
];
@endphp

<div class="animate__animated animate__fadeIn">
    <!-- Welcome Header -->
    <div class="bg-primary-gradient text-white rounded-4 p-4 p-md-5 mb-4 shadow-sm" data-aos="fade-down">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h2 class="fw-bold mb-2">Welcome back, {{ auth()->user()->name ?? 'User' }}! 👋</h2>
                <p class="mb-0 opacity-75">Here's what's happening with your medical practice today.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <span class="badge bg-white text-primary px-3 py-2 rounded-pill">
                    <i class="fas fa-calendar-alt me-2"></i>{{ now()->format('l, F j, Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3" data-aos="fade-up" data-aos-delay="100">
            <div class="card border-0 shadow-sm hover-shadow transition-all h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center bg-primary-subtle flex-shrink-0" style="width: 48px; height: 48px;">
                                <i class="fas fa-user-md fa-lg text-primary"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Total Doctors</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $stats['doctors'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success-emphasis">
                                <i class="fas fa-arrow-up me-1"></i>+12%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3" data-aos="fade-up" data-aos-delay="200">
            <div class="card border-0 shadow-sm hover-shadow transition-all h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center bg-success-subtle flex-shrink-0" style="width: 48px; height: 48px;">
                                <i class="fas fa-users fa-lg text-success"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Total Patients</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $stats['patients'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success-emphasis">
                                <i class="fas fa-arrow-up me-1"></i>+8%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3" data-aos="fade-up" data-aos-delay="300">
            <div class="card border-0 shadow-sm hover-shadow transition-all h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center bg-info-subtle flex-shrink-0" style="width: 48px; height: 48px;">
                                <i class="fas fa-file-prescription fa-lg text-info"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Prescriptions</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $stats['prescriptions'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success-emphasis">
                                <i class="fas fa-arrow-up me-1"></i>+15%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3" data-aos="fade-up" data-aos-delay="400">
            <div class="card border-0 shadow-sm hover-shadow transition-all h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center bg-warning-subtle flex-shrink-0" style="width: 48px; height: 48px;">
                                <i class="fas fa-vial fa-lg text-warning"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Lab Reports</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $stats['labReports'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-danger-subtle text-danger-emphasis">
                                <i class="fas fa-arrow-down me-1"></i>-3%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8" data-aos="fade-right">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-semibold mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>Prescriptions Trend
                    </h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary active">Week</button>
                        <button type="button" class="btn btn-outline-secondary">Month</button>
                        <button type="button" class="btn btn-outline-secondary">Year</button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="prescriptionsChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4" data-aos="fade-left">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title fw-semibold mb-0">
                        <i class="fas fa-chart-pie text-primary me-2"></i>Patients by Gender
                    </h5>
                </div>
                <div class="card-body d-flex align-items-center">
                    <canvas id="genderChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & System Info -->
    <div class="row g-4">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title fw-semibold mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 col-xl-3">
                            <a href="{{ route('doctors.create') }}" class="card border-0 shadow-sm hover-shadow transition-all text-decoration-none h-100">
                                <div class="card-body d-flex align-items-center gap-3 p-4">
                                    <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                        <i class="fas fa-user-md fa-lg text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Add Doctor</h6>
                                        <p class="small text-muted mb-0">Register new doctor</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <a href="{{ route('patients.create') }}" class="card border-0 shadow-sm hover-shadow transition-all text-decoration-none h-100">
                                <div class="card-body d-flex align-items-center gap-3 p-4">
                                    <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                        <i class="fas fa-user-plus fa-lg text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Add Patient</h6>
                                        <p class="small text-muted mb-0">Register new patient</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <a href="{{ route('prescriptions.create') }}" class="card border-0 shadow-sm hover-shadow transition-all text-decoration-none h-100">
                                <div class="card-body d-flex align-items-center gap-3 p-4">
                                    <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                        <i class="fas fa-file-medical fa-lg text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">New Prescription</h6>
                                        <p class="small text-muted mb-0">Create prescription</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <a href="{{ route('lab_test_reports.create') }}" class="card border-0 shadow-sm hover-shadow transition-all text-decoration-none h-100">
                                <div class="card-body d-flex align-items-center gap-3 p-4">
                                    <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                        <i class="fas fa-vial fa-lg text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Lab Report</h6>
                                        <p class="small text-muted mb-0">Add lab report</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title fw-semibold mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>System Status
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-shield-alt text-success me-2"></i>
                                <span class="small">Role-based Access</span>
                            </div>
                            <span class="badge bg-success-subtle text-success-emphasis">Active</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-envelope text-success me-2"></i>
                                <span class="small">Email Verification</span>
                            </div>
                            <span class="badge bg-success-subtle text-success-emphasis">Enabled</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-search text-success me-2"></i>
                                <span class="small">AJAX Search</span>
                            </div>
                            <span class="badge bg-success-subtle text-success-emphasis">Enabled</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-database text-info me-2"></i>
                                <span class="small">JSON Storage</span>
                            </div>
                            <span class="badge bg-info-subtle text-info-emphasis">Prescriptions</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title fw-semibold mb-0">
                        <i class="fas fa-clock text-primary me-2"></i>Recent Activity
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fas fa-plus text-primary small"></i>
                                </div>
                                <div>
                                    <p class="small mb-0 fw-medium">New patient registered</p>
                                    <p class="small text-muted mb-0">2 minutes ago</p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fas fa-file-medical text-success small"></i>
                                </div>
                                <div>
                                    <p class="small mb-0 fw-medium">Prescription created</p>
                                    <p class="small text-muted mb-0">1 hour ago</p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fas fa-vial text-info small"></i>
                                </div>
                                <div>
                                    <p class="small mb-0 fw-medium">Lab report added</p>
                                    <p class="small text-muted mb-0">3 hours ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
fetch('/api/dashboard-chart-data')
    .then(res => res.json())
    .then(data => {
        // Prescriptions Chart
        const ctx1 = document.getElementById('prescriptionsChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: data.prescriptions.labels,
                datasets: [{
                    label: 'Prescriptions',
                    data: data.prescriptions.data,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });

        // Gender Chart
        const ctx2 = document.getElementById('genderChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female', 'Other'],
                datasets: [{
                    data: [data.gender.male, data.gender.female, data.gender.other],
                    backgroundColor: ['#0d6efd', '#198754', '#dc3545'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    })
    .catch(err => console.error('Chart data error:', err));
</script>
@endpush
@endsection
