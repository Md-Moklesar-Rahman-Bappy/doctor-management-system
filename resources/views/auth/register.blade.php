@extends('layouts.dashboard')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl border border-slate-200 p-8">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-900">Doctor Registration</h2>
                <p class="text-slate-500 mt-1">Create your account</p>
            </div>

            <form method="POST" action="/register" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

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

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirm Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
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
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="/login" class="text-sm text-emerald-600 hover:text-emerald-700">
                    Already have an account? Sign In
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
