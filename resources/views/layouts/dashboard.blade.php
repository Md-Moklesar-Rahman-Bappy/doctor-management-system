<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Medical Management System">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Doctor - Medical Management System')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- AOS - Animate On Scroll -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand navbar-light bg-white border-bottom shadow-sm fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="/dashboard">
                <i class="fas fa-user-md me-2"></i>Doctor
            </a>
            <div class="d-flex align-items-center gap-3">
                @auth
                    <span class="text-muted small">{{ auth()->user()->email }}</span>
                    <form method="POST" action="/logout" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted text-decoration-none p-0">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content -->
    <div class="d-flex" style="margin-top: 64px;">
        <!-- Sidebar -->
        <aside class="sidebar">
            <nav class="p-3">
                <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="/doctors" class="nav-link {{ request()->is('doctors*') ? 'active' : '' }}">
                    <i class="fas fa-user-md"></i> Doctors
                </a>
                <a href="/patients" class="nav-link {{ request()->is('patients*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Patients
                </a>
                <a href="/prescriptions" class="nav-link {{ request()->is('prescriptions*') ? 'active' : '' }}">
                    <i class="fas fa-file-prescription"></i> Prescriptions
                </a>
                <a href="/medicines" class="nav-link {{ request()->is('medicines*') ? 'active' : '' }}">
                    <i class="fas fa-pills"></i> Medicines
                </a>
                <a href="/lab-tests" class="nav-link {{ request()->is('lab-tests*') ? 'active' : '' }}">
                    <i class="fas fa-flask"></i> Lab Tests
                </a>
                <a href="/lab-test-reports" class="nav-link {{ request()->is('lab-test-reports*') ? 'active' : '' }}">
                    <i class="fas fa-vial"></i> Lab Reports
                </a>
                <a href="/problems" class="nav-link {{ request()->is('problems*') ? 'active' : '' }}">
                    <i class="fas fa-stethoscope"></i> Diagnoses
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content flex-grow-1 p-4 p-md-5">
            <!-- Breadcrumbs -->
            @if(isset($breadcrumbs))
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        @foreach($breadcrumbs as $crumb)
                            @if(isset($crumb['url']))
                                <li class="breadcrumb-item"><a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a></li>
                            @else
                                <li class="breadcrumb-item active">{{ $crumb['label'] }}</li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            @endif

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Toast Container -->
            <div class="toast-container position-fixed top-0 end-0 p-3"></div>

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <!-- AOS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    @stack('scripts')
</body>
</html>
