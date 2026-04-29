@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Dashboard'],
];
@endphp
<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="page-title">Dashboard</h2>
        <p class="page-description">Welcome back, {{ auth()->user()->name ?? 'User' }}</p>
    </div>

    <!-- Stats Cards - TailAdmin Style -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stats-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Doctors</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['doctors'] ?? 0 }}</p>
                </div>
                <div class="stats-card-icon bg-blue-100">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-4">
                <span class="text-sm text-gray-500">Active professionals</span>
            </div>
        </div>

        <div class="stats-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Patients</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['patients'] ?? 0 }}</p>
                </div>
                <div class="stats-card-icon bg-emerald-100">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-4">
                <span class="text-sm text-gray-500">Registered patients</span>
            </div>
        </div>

        <div class="stats-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Prescriptions</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['prescriptions'] ?? 0 }}</p>
                </div>
                <div class="stats-card-icon bg-sky-100">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-4">
                <span class="text-sm text-gray-500">Created prescriptions</span>
            </div>
        </div>

        <div class="stats-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Lab Reports</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['labReports'] ?? 0 }}</p>
                </div>
                <div class="stats-card-icon bg-amber-100">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-4">
                <span class="text-sm text-gray-500">Test reports</span>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="card">
            <div class="card-header">
                <h5 class="text-lg font-semibold text-gray-900">Prescriptions Trend</h5>
            </div>
            <div class="card-body">
                <canvas id="prescriptionsChart" height="200"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="text-lg font-semibold text-gray-900">Patients by Gender</h5>
            </div>
            <div class="card-body">
                <canvas id="genderChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions & System Info -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-lg font-semibold text-gray-900">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="space-y-3">
                    <a href="{{ route('doctors.create') }}" class="btn-primary block text-center">Add New Doctor</a>
                    <a href="{{ route('patients.create') }}" class="btn-success block text-center">Add New Patient</a>
                    <a href="{{ route('prescriptions.create') }}" class="btn-primary block text-center">Create Prescription</a>
                    <a href="{{ route('lab_test_reports.create') }}" class="btn-warning block text-center">Add Lab Report</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="text-lg font-semibold text-gray-900">System Information</h5>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Role-based Access</span>
                        <span class="badge-success">Active</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Email Verification</span>
                        <span class="badge-success">Enabled</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">AJAX Search</span>
                        <span class="badge-success">Enabled</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">JSON Storage</span>
                        <span class="badge-info">Prescriptions</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
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
                    backgroundColor: ['rgb(59, 130, 246)', 'rgb(244, 114, 182)', 'rgb(168, 85, 247)']
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
