@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Home'],
];
?>
<div class="min-h-screen flex items-center">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 relative">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-12 items-center relative">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500/10 border border-emerald-500/20 rounded-full mb-6">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    <span class="text-emerald-400 text-sm font-medium">Trusted by 500+ Healthcare Providers</span>
                </div>
                
                <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6 text-white">
                    Streamline Your
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">Medical Practice</span>
                </h1>
                
                <p class="text-xl text-slate-400 mb-8 leading-relaxed">
                    Manage patients, prescriptions, medicines, and medical records all in one place. 
                    Modern, efficient, and built for today's healthcare professionals.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/register" class="px-8 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-xl transition-all hover:shadow-lg hover:shadow-emerald-500/25 text-center">Start Free Trial</a>
                    <a href="#features" class="px-8 py-4 bg-white/10 hover:bg-white/20 border border-white/10 text-white font-semibold rounded-xl transition-all text-center backdrop-blur-sm">Learn More</a>
                </div>
                
                <div class="flex items-center gap-8 mt-10 pt-10 border-t border-white/10">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">10K+</div>
                        <div class="text-sm text-slate-400">Patients</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">500+</div>
                        <div class="text-sm text-slate-400">Doctors</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">99.9%</div>
                        <div class="text-sm text-slate-400">Uptime</div>
                    </div>
                </div>
            </div>
            
            <div class="hidden lg:block relative">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 to-blue-500/20 rounded-3xl blur-2xl"></div>
                <div class="relative bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-3xl p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-white">Dr. Sarah Mitchell</div>
                            <div class="text-sm text-slate-400">Cardiologist</div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-slate-700/50 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-slate-300">Today's Patients</span>
                                <span class="text-emerald-400 text-sm font-semibold">+12%</span>
                            </div>
                            <div class="text-2xl font-bold text-white">24</div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-700/50 rounded-xl p-4">
                                <div class="text-sm text-slate-400 mb-1">Prescriptions</div>
                                <div class="text-xl font-bold text-white">18</div>
                            </div>
                            <div class="bg-slate-700/50 rounded-xl p-4">
                                <div class="text-sm text-slate-400 mb-1">Tests</div>
                                <div class="text-xl font-bold text-white">7</div>
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
    // Smooth scroll for anchor links
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
