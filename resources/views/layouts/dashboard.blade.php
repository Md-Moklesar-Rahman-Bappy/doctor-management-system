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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- AOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-light">
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand navbar-light bg-white shadow-sm fixed-top" style="z-index: 1030;">
        <div class="container-fluid px-4">
            <button class="btn btn-link text-dark p-0 me-3 d-md-none" id="sidebarToggle" style="font-size: 1.25rem;">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="/dashboard">
                <div class="rounded-3 bg-primary d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                    <i class="fas fa-user-md text-white"></i>
                </div>
                <span class="d-none d-sm-inline">Doctor</span>
            </a>

            <div class="d-flex align-items-center gap-3 ms-auto">
                <!-- Notifications -->
                <button class="btn btn-link text-muted position-relative p-1" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                        3
                    </span>
                </button>

                <!-- User Menu -->
                @auth
                    <div class="dropdown">
                        <button class="btn btn-link text-dark d-flex align-items-center gap-2 text-decoration-none p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <span class="text-white fw-semibold" style="font-size: 0.875rem;">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}</span>
                            </div>
                            <div class="text-start d-none d-md-block">
                                <div class="small fw-semibold">{{ auth()->user()->name ?? 'User' }}</div>
                                <div class="small text-muted">{{ ucfirst(auth()->user()->role ?? 'User') }}</div>
                            </div>
                            <i class="fas fa-chevron-down small text-muted d-none d-md-inline"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="min-width: 200px;">
                            <li><h6 class="dropdown-header small fw-semibold">{{ auth()->user()->email }}</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/profile"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="/logout" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content -->
    <div class="d-flex" style="margin-top: 56px;">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar shadow-sm" style="transition: margin-left 0.3s ease;">
            <nav class="p-3">
                <div class="small fw-semibold text-muted text-uppercase mb-2 ps-3">Main Menu</div>
                <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt fa-fw me-2"></i> Dashboard
                </a>
                <a href="/doctors" class="nav-link {{ request()->is('doctors*') ? 'active' : '' }}">
                    <i class="fas fa-user-md fa-fw me-2"></i> Doctors
                </a>
                <a href="/patients" class="nav-link {{ request()->is('patients*') ? 'active' : '' }}">
                    <i class="fas fa-users fa-fw me-2"></i> Patients
                </a>
                <a href="/prescriptions" class="nav-link {{ request()->is('prescriptions*') ? 'active' : '' }}">
                    <i class="fas fa-file-prescription fa-fw me-2"></i> Prescriptions
                </a>

                <div class="small fw-semibold text-muted text-uppercase mt-4 mb-2 ps-3">Inventory</div>
                <a href="/medicines" class="nav-link {{ request()->is('medicines*') ? 'active' : '' }}">
                    <i class="fas fa-pills fa-fw me-2"></i> Medicines
                </a>
                <a href="/lab-tests" class="nav-link {{ request()->is('lab-tests*') ? 'active' : '' }}">
                    <i class="fas fa-flask fa-fw me-2"></i> Lab Tests
                </a>
                <a href="/lab-test-reports" class="nav-link {{ request()->is('lab-test-reports*') ? 'active' : '' }}">
                    <i class="fas fa-vial fa-fw me-2"></i> Lab Reports
                </a>

                <div class="small fw-semibold text-muted text-uppercase mt-4 mb-2 ps-3">Other</div>
                <a href="/problems" class="nav-link {{ request()->is('problems*') ? 'active' : '' }}">
                    <i class="fas fa-stethoscope fa-fw me-2"></i> Diagnoses
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="position-absolute bottom-0 start-0 end-0 p-3 border-top bg-white">
                <div class="small text-muted text-center">
                    © 2026 Doctor HMS<br>
                    <span class="badge bg-success-subtle text-success-emphasis">v1.0</span>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content flex-grow-1 p-3 p-md-4" style="min-height: calc(100vh - 56px);">
            <!-- Breadcrumbs -->
            @if(isset($breadcrumbs))
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home me-1"></i>Home</a></li>
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
                <div class="alert alert-success alert-dismissible fade show border-start border-success border-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-start border-danger border-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-start border-danger border-4" role="alert">
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
            <div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>

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

    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.style.marginLeft === '-256px') {
                sidebar.style.marginLeft = '0';
            } else {
                sidebar.style.marginLeft = '-256px';
            }
        });

        // Initialize AOS
        AOS.init({
            duration: 600,
            once: true,
            offset: 50
        });
    </script>

    @stack('scripts')
</body>
</html>
