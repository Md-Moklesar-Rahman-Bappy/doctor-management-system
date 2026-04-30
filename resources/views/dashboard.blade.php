@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Dashboard', 'url' => route('dashboard')],
];
@endphp

<div>
    <!-- Page Header -->
    <div class="mb-4" data-aos="fade-down">
        <h2 class="page-title">Dashboard</h2>
        <p class="page-description">Welcome back, {{ auth()->user()->name ?? 'User' }}</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
            <div class="stats-card animate__animated animate__fadeIn">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-medium mb-1">Total Doctors</p>
                        <p class="h3 fw-bold text-dark mb-0">{{ $stats['doctors'] ?? 0 }}</p>
                    </div>
                    <div class="stats-card-icon bg-brand-100">
                        <i class="fas fa-user-md fa-lg text-primary"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 mt-3">
                    <span class="badge bg-success-subtle text-success-emphasis">
                        <i class="fas fa-arrow-up me-1 small"></i>+12%
                    </span>
                    <span class="small text-muted">vs last month</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-medium mb-1">Total Patients</p>
                        <p class="h3 fw-bold text-dark mb-0">{{ $stats['patients'] ?? 0 }}</p>
                    </div>
                    <div class="stats-card-icon bg-success-100">
                        <i class="fas fa-users fa-lg text-success"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 mt-3">
                    <span class="badge bg-success-subtle text-success-emphasis">
                        <i class="fas fa-arrow-up me-1 small"></i>+8%
                    </span>
                    <span class="small text-muted">vs last month</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-medium mb-1">Prescriptions</p>
                        <p class="h3 fw-bold text-dark mb-0">{{ $stats['prescriptions'] ?? 0 }}</p>
                    </div>
                    <div class="stats-card-icon bg-blue-light-100">
                        <i class="fas fa-file-prescription fa-lg text-info"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 mt-3">
                    <span class="badge bg-success-subtle text-success-emphasis">
                        <i class="fas fa-arrow-up me-1 small"></i>+15%
                    </span>
                    <span class="small text-muted">vs last month</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-medium mb-1">Lab Reports</p>
                        <p class="h3 fw-bold text-dark mb-0">{{ $stats['labReports'] ?? 0 }}</p>
                    </div>
                    <div class="stats-card-icon bg-warning-100">
                        <i class="fas fa-vial fa-lg text-warning"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 mt-3">
                    <span class="badge bg-danger-subtle text-danger-emphasis">
                        <i class="fas fa-arrow-down me-1 small"></i>-3%
                    </span>
                    <span class="small text-muted">vs last month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6" data-aos="fade-right">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-semibold mb-0">Prescriptions Trend</h5>
                </div>
                <div class="card-body">
                    <canvas id="prescriptionsChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6" data-aos="fade-left">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-semibold mb-0">Patients by Gender</h5>
                </div>
                <div class="card-body">
                    <canvas id="genderChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & System Info -->
    <div class="row g-3">
        <div class="col-lg-6" data-aos="fade-up">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-semibold mb-0">Quick Actions</h5>
                </div>
                <div class="card-body d-flex flex-column gap-2">
                    <a href="{{ route('doctors.create') }}" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-user-plus"></i> Add New Doctor
                    </a>
                    <a href="{{ route('patients.create') }}" class="btn btn-success d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-user-plus"></i> Add New Patient
                    </a>
                    <a href="{{ route('prescriptions.create') }}" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-file-medical"></i> Create Prescription
                    </a>
                    <a href="{{ route('lab_test_reports.create') }}" class="btn btn-warning d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-vial"></i> Add Lab Report
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-semibold mb-0">System Information</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="small text-muted">Role-based Access</span>
                        <span class="badge bg-success-subtle text-success-emphasis">Active</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="small text-muted">Email Verification</span>
                        <span class="badge bg-success-subtle text-success-emphasis">Enabled</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="small text-muted">AJAX Search</span>
                        <span class="badge bg-success-subtle text-success-emphasis">Enabled</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="small text-muted">JSON Storage</span>
                        <span class="badge bg-info-subtle text-info-emphasis">Prescriptions</span>
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
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
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
                    backgroundColor: ['#0d6efd', '#198754', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    })
    .catch(err => console.error('Chart data error:', err));
</script>
@endpush
@endsection
