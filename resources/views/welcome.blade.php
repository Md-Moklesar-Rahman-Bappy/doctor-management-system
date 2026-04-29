@extends('layouts.dashboard')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12 w-full">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 border border-primary-200 rounded-full mb-6">
                    <span class="w-2 h-2 bg-primary-500 rounded-full animate-pulse"></span>
                    <span class="text-primary-700 text-sm font-medium">Modern Healthcare Management</span>
                </div>

                <h1 class="text-4xl lg:text-5xl font-bold leading-tight mb-6 text-secondary-900">
                    Streamline Your
                    <span class="text-primary-600">Medical Practice</span>
                </h1>

                <p class="text-lg text-secondary-600 mb-8 leading-relaxed">
                    Manage patients, prescriptions, medicines, and medical records all in one place.
                    Modern, efficient, and built for today's healthcare professionals.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/register" class="btn-primary text-center text-base px-8 py-3">
                        Get Started Free
                    </a>
                    <a href="#features" class="btn-secondary text-center text-base px-8 py-3">
                        Learn More
                    </a>
                </div>

                <div class="flex items-center gap-8 mt-10 pt-8 border-t border-secondary-200">
                    <div>
                        <div class="text-2xl font-bold text-secondary-900">10K+</div>
                        <div class="text-sm text-secondary-500">Patients</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-secondary-900">500+</div>
                        <div class="text-sm text-secondary-500">Doctors</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-secondary-900">99.9%</div>
                        <div class="text-sm text-secondary-500">Uptime</div>
                    </div>
                </div>
            </div>

            <div class="hidden lg:block">
                <div class="bg-white rounded-2xl shadow-xl border border-secondary-200 p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-secondary-900">Dr. Sarah Mitchell</div>
                            <div class="text-sm text-secondary-500">Cardiologist</div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-secondary-50 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-secondary-600">Today's Patients</span>
                                <span class="text-emerald-600 text-sm font-semibold">+12%</span>
                            </div>
                            <div class="text-2xl font-bold text-secondary-900">24</div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-secondary-50 rounded-xl p-4">
                                <div class="text-sm text-secondary-500 mb-1">Prescriptions</div>
                                <div class="text-xl font-bold text-secondary-900">18</div>
                            </div>
                            <div class="bg-secondary-50 rounded-xl p-4">
                                <div class="text-sm text-secondary-500 mb-1">Tests</div>
                                <div class="text-xl font-bold text-secondary-900">7</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});
</script>
@endpush
@endsection
