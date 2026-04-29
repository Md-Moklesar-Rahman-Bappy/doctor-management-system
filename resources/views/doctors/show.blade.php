@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Doctors', 'url' => route('doctors.index')],
    ['label' => 'Doctor Details'],
];
?>
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('doctors.index') }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h3 class="text-2xl font-bold text-gray-900">Doctor Details</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h5 class="font-semibold text-gray-900 mb-0">Doctor Information</h5>
                </div>
                <div class="p-6 space-y-3">
                    <h4 class="text-lg font-bold text-gray-900">{{ $doctor->name }}</h4>
                    <p class="text-sm"><strong class="text-gray-700">Email:</strong> <span class="text-gray-600">{{ $doctor->email }}</span></p>
                    <p class="text-sm"><strong class="text-gray-700">Phone:</strong> <span class="text-gray-600">{{ $doctor->phone }}</span></p>
                    <p class="text-sm"><strong class="text-gray-700">Address:</strong> <span class="text-gray-600">{{ $doctor->address }}</span></p>
                    <p class="text-sm"><strong class="text-gray-700">Degrees:</strong>
                        @if($doctor->degrees)
                            <span class="inline-flex flex-wrap gap-1">
                                @foreach(json_decode($doctor->degrees, true) as $degree)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-light-100 text-blue-light-700">{{ $degree }}</span>
                                @endforeach
                            </span>
                        @endif
                    </p>
                    <p class="text-sm"><strong class="text-gray-700">Email Verified:</strong>
                        @if($doctor->email_verified)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-100 text-brand-700">Yes</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-100 text-warning-700">No</span>
                        @endif
                    </p>
                </div>
                <div class="px-6 py-4 border-t border-gray-200">
                    <a href="{{ route('doctors.edit', $doctor->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-warning-500 hover:bg-warning-600 text-white text-sm font-medium rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h5 class="font-semibold text-gray-900 mb-0">Quick Actions</h5>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="/prescriptions/create?doctor_id={{ $doctor->id }}" class="flex items-center gap-3 p-4 bg-blue-light-50 hover:bg-blue-light-100 rounded-lg transition">
                            <div class="w-10 h-10 bg-blue-light-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">Create Prescription</div>
                                <div class="text-sm text-gray-500">Write a new prescription</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="/doctors" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to List
        </a>
    </div>
</div>
@endsection
