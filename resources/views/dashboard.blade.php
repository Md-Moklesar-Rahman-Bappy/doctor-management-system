@extends('layouts.dashboard')

@section('content')
<div>
    <h2 class="text-2xl font-bold text-slate-800 mb-6">Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Doctors</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['doctors'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Patients</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['patients'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Prescriptions</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['prescriptions'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Lab Reports</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['labReports'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h5 class="font-semibold text-slate-800 mb-4">Quick Actions</h5>
                <div class="space-y-3">
                    <a href="/doctors/create" class="block w-full px-4 py-3 bg-blue-600 text-white text-center font-medium rounded-lg hover:bg-blue-700 transition">Add New Doctor</a>
                    <a href="/patients/create" class="block w-full px-4 py-3 bg-emerald-600 text-white text-center font-medium rounded-lg hover:bg-emerald-700 transition">Add New Patient</a>
                    <a href="/prescriptions/create" class="block w-full px-4 py-3 bg-sky-600 text-white text-center font-medium rounded-lg hover:bg-sky-700 transition">Create Prescription</a>
                    <a href="/lab-test-reports/create" class="block w-full px-4 py-3 bg-amber-600 text-white text-center font-medium rounded-lg hover:bg-amber-700 transition">Add Lab Report</a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h5 class="font-semibold text-slate-800 mb-4">System Info</h5>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-slate-600">Role-based Access</span>
                        <span class="text-emerald-600 font-medium">Active</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Email Verification</span>
                        <span class="text-emerald-600 font-medium">Enabled</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">AJAX Search</span>
                        <span class="text-emerald-600 font-medium">Enabled</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">JSON Storage</span>
                        <span class="text-slate-600 font-medium">Prescriptions</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h5 class="font-semibold text-slate-800 mb-4">Prescriptions Trend (Last 7 Days)</h5>
                <canvas id="prescriptionsChart" height="200"></canvas>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h5 class="font-semibold text-slate-800 mb-4">Patients by Gender</h5>
                <canvas id="genderChart" height="200"></canvas>
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
