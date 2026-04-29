@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Two Step Verification'],
];
@endphp
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-brand-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Two Step Verification</h2>
            <p class="text-gray-500 mt-2">Enter the 6-digit code sent to your email</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/two-step-verification" class="space-y-5">
                    @csrf

                    <!-- 6-Digit Code Input -->
                    <div>
                        <label class="form-label text-center">Verification Code</label>
                        <div class="flex gap-2 justify-center mt-2">
                            <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-brand-500 focus:ring-2 focus:ring-brand-500" oninput="this.nextElementSibling?.focus()">
                            <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-brand-500 focus:ring-2 focus:ring-brand-500" oninput="this.nextElementSibling?.focus()">
                            <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-brand-500 focus:ring-2 focus:ring-brand-500" oninput="this.nextElementSibling?.focus()">
                            <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-brand-500 focus:ring-2 focus:ring-brand-500" oninput="this.nextElementSibling?.focus()">
                            <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-brand-500 focus:ring-2 focus:ring-brand-500" oninput="this.nextElementSibling?.focus()">
                            <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-brand-500 focus:ring-2 focus:ring-brand-500">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-full inline-flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Verify Code
                    </button>

                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Didn't receive the code?
                            <button type="button" class="text-brand-600 hover:text-brand-700 font-medium">Resend Code</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center text-sm text-gray-500 mt-8">Free and Open-Source Medical Management System</p>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('input[maxlength="1"]').forEach((input, index, inputs) => {
    input.addEventListener('keyup', (e) => {
        if (e.key === 'Backspace' && !input.value && index > 0) {
            inputs[index-1].focus();
        }
    });
});
</script>
@endpush
@endsection
