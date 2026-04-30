@extends('layouts.dashboard')

@section('content')
<div class="min-vh-100 d-flex align-items-center" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="d-flex align-items-center gap-2 bg-primary-subtle border border-primary-subtle rounded-pill px-4 py-2 mb-4 d-inline-flex">
                    <span class="bg-primary rounded-circle d-inline-block" style="width: 8px; height: 8px; animation: pulse 2s infinite;"></span>
                    <span class="text-primary fw-medium small">Modern Healthcare Management</span>
                </div>

                <h1 class="display-5 fw-bold mb-4" style="line-height: 1.2;">
                    Streamline Your<br>
                    <span class="text-primary">Medical Practice</span>
                </h1>

                <p class="lead text-muted mb-4" style="line-height: 1.6;">
                    Manage patients, prescriptions, medicines, and medical records all in one place.
                    Modern, efficient, and built for today's healthcare professionals.
                </p>

                <div class="d-flex flex-column flex-sm-row gap-3 mb-5">
                    <a href="/register" class="btn btn-primary btn-lg px-5">
                        Get Started Free
                    </a>
                    <a href="#features" class="btn btn-outline-secondary btn-lg px-5">
                        Learn More
                    </a>
                </div>

                <div class="d-flex gap-5 pt-4 border-top">
                    <div>
                        <div class="h3 fw-bold text-dark">10K+</div>
                        <div class="small text-muted">Patients</div>
                    </div>
                    <div>
                        <div class="h3 fw-bold text-dark">500+</div>
                        <div class="small text-muted">Doctors</div>
                    </div>
                    <div>
                        <div class="h3 fw-bold text-dark">99.9%</div>
                        <div class="small text-muted">Uptime</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fas fa-user-md text-white"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Dr. Sarah Mitchell</div>
                                <div class="small text-muted">Cardiologist</div>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            <div class="bg-light rounded-3 p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small fw-medium text-muted">Today's Patients</span>
                                    <span class="text-success fw-semibold small">+12%</span>
                                </div>
                                <div class="display-6 fw-bold text-dark">24</div>
                            </div>

                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-3">
                                        <div class="small text-muted mb-1">Prescriptions</div>
                                        <div class="h3 fw-bold text-dark">18</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-3">
                                        <div class="small text-muted mb-1">Tests</div>
                                        <div class="h3 fw-bold text-dark">7</div>
                                    </div>
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
