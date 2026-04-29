@extends('layouts.dashboard')

@section('content')
<?php
$breadcrumbs = [
    ['label' => 'Lab Reports', 'url' => route('lab_test_reports.index')],
    ['label' => 'Lab Report Details'],
];
?>
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="/lab-test-reports" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h3 class="text-2xl font-bold text-gray-900">Lab Test Report Details</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h5 class="font-semibold text-gray-900 mb-0">Report Information</h5>
                </div>
                <div class="p-6 space-y-3">
                    <p class="text-sm"><strong class="text-gray-700">Patient:</strong>
                        <a href="/patients/{{ $report->patient->id }}" class="text-brand-600 hover:text-brand-700">
                            {{ $report->patient->unique_id }} - {{ $report->patient->patient_name }}
                        </a>
                    </p>
                    <p class="text-sm"><strong class="text-gray-700">Test Name:</strong> <span class="text-gray-600">{{ $report->test_name }}</span></p>
                    <p class="text-sm"><strong class="text-gray-700">Date:</strong> <span class="text-gray-600">{{ $report->created_at->format('Y-m-d H:i') }}</span></p>
                </div>
                <div class="px-6 py-4 border-t border-gray-200">
                    <a href="/lab-test-reports/{{ $report->id }}/edit" class="inline-flex items-center gap-2 px-4 py-2 bg-warning-500 hover:bg-warning-600 text-white text-sm font-medium rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            @if($report->report_text)
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h5 class="font-semibold text-gray-900 mb-0">Report Text</h5>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">{{ $report->report_text }}</p>
                </div>
            </div>
            @endif

            @if($report->report_image)
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h5 class="font-semibold text-gray-900 mb-0">Images</h5>
                </div>
                <div class="p-6">
                    @php
                        $images = json_decode($report->report_image, true);
                    @endphp
                    @if(is_array($images))
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($images as $image)
                                <img src="/storage/{{ $image }}" class="w-full rounded-lg border border-gray-200">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-6">
        <a href="/lab-test-reports" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to List
        </a>
    </div>
</div>
@endsection
