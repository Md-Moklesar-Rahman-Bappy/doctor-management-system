<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Medical Management System">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Doctor - Medical Management System')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/dashboard" class="text-xl font-bold text-primary-600">Doctor</a>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <span class="text-sm text-gray-600">{{ auth()->user()->email }}</span>
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="flex pt-16">
        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen fixed left-0 top-16 overflow-y-auto">
            <nav class="p-4 space-y-2">
                <a href="/dashboard" class="flex items-center gap-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->is('dashboard') ? 'bg-primary-50 text-primary-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1 1v3a1 1 0 001 1h3m-6 0l6-6m-9 5h.01M12 12h.01"/></svg>
                    Dashboard
                </a>
                <a href="/doctors" class="flex items-center gap-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->is('doctors*') ? 'bg-primary-50 text-primary-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Doctors
                </a>
                <a href="/patients" class="flex items-center gap-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->is('patients*') ? 'bg-primary-50 text-primary-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.637M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Patients
                </a>
                <a href="/prescriptions" class="flex items-center gap-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->is('prescriptions*') ? 'bg-primary-50 text-primary-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Prescriptions
                </a>
                <a href="/medicines" class="flex items-center gap-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->is('medicines*') ? 'bg-primary-50 text-primary-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.429a2 2 0 00-1.398-2.903l-1.371-1.37a2 2 0 00-1.414-.465l-3.34 3.34a4 4 0 00-.465 1.414l-1.37 1.371a2 2 0 002.903 1.398l6.227 1.793a.5.5 0 00.383-.683l-1.535-5.357z"/></svg>
                    Medicines
                </a>
                <a href="/lab-tests" class="flex items-center gap-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->is('lab-tests*') ? 'bg-primary-50 text-primary-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.429a2 2 0 00-1.398-2.903l-1.371-1.37a2 2 0 00-1.414-.465l-3.34 3.34a4 4 0 00-.465 1.414l-1.37 1.371a2 2 0 002.903 1.398l6.227 1.793a.5.5 0 00.383-.683l-1.535-5.357z"/></svg>
                    Lab Tests
                </a>
                <a href="/lab-test-reports" class="flex items-center gap-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->is('lab-test-reports*') ? 'bg-primary-50 text-primary-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10V7a2 2 0 00-2-2h-6m-4 10V5a2 2 0 00-2-2h-2a2 2 0 00-2 2v12a2 2 0 002 2h10z"/></svg>
                    Lab Reports
                </a>
                <a href="/problems" class="flex items-center gap-3 px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->is('problems*') ? 'bg-primary-50 text-primary-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-2-7a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V7z"/></svg>
                    Problems
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 flex-1 p-8">
            <!-- Breadcrumbs -->
            @if(isset($breadcrumbs))
                <div class="mb-4">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1">
                            <li><a href="/dashboard" class="text-sm text-gray-500 hover:text-gray-700">Home</a></li>
                            @foreach($breadcrumbs as $crumb)
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    @if(isset($crumb['url']))
                                        <a href="{{ $crumb['url'] }}" class="text-sm text-gray-500 hover:text-gray-700">{{ $crumb['label'] }}</a>
                                    @else
                                        <span class="text-sm text-gray-900">{{ $crumb['label'] }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                </div>
            @endif

            <!-- Alerts -->
            @if(session('success'))
                <x-alert variant="success" :dismissible="true">
                    {{ session('success') }}
                </x-alert>
            @endif

            @if(session('error'))
                <x-alert variant="error" :dismissible="true">
                    {{ session('error') }}
                </x-alert>
            @endif

            @if($errors->any())
                <x-alert variant="error" :dismissible="true">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
