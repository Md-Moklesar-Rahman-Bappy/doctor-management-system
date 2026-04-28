@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Lab Test Details</h1>
            <p class="text-slate-500">View laboratory test information</p>
        </div>
        <a href="/lab_tests" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to List
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-500 mb-1">Department</label>
                <p class="text-lg font-semibold text-slate-900">{{ $test->department }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-500 mb-1">Sample Type</label>
                <p class="text-lg text-slate-900">{{ $test->sample_type }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-500 mb-1">Panel</label>
                <p class="text-lg text-slate-900">{{ $test->panel ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-500 mb-1">Test</label>
                <p class="text-lg text-slate-900">{{ $test->test }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-500 mb-1">Code</label>
                <p class="text-lg text-slate-900 font-mono">{{ $test->code }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-500 mb-1">Unit</label>
                <p class="text-lg text-slate-900">{{ $test->unit ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-500 mb-1">Result Type</label>
                <p class="text-lg text-slate-900">{{ $test->result_type ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-500 mb-1">Normal Range</label>
                <p class="text-lg text-slate-900">{{ $test->normal_range ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="mt-8 flex items-center gap-3">
            <a href="/lab_tests/{{ $test->id }}/edit" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg">Edit</a>
            <form method="POST" action="/lab_tests/{{ $test->id }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
