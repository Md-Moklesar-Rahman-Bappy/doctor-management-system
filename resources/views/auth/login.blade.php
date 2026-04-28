@extends('layouts.dashboard')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl border border-slate-200 p-8">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-900">Login</h2>
                <p class="text-slate-500 mt-1">Sign in to your account</p>
            </div>

            <form method="POST" action="/login" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password *</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                @if($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <button type="submit" class="w-full px-4 py-2.5 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 font-medium">
                    Sign In
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="/register" class="text-sm text-emerald-600 hover:text-emerald-700">
                    Don't have an account? Register as Doctor
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
