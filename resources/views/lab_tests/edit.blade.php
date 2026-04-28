@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="/lab_tests" class="p-2 hover:bg-slate-100 rounded-lg">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Edit Lab Test</h1>
        </div>
        <p class="text-slate-500">Update the test details below</p>
    </div>

    <div class="max-w-3xl">
        <form action="/lab_tests/{{ $test->id }}" method="POST" class="bg-white rounded-xl border border-slate-200 p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Department *</label>
                    <input type="text" name="department" value="{{ $test->department }}" required class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Sample Type *</label>
                    <input type="text" name="sample_type" value="{{ $test->sample_type }}" required class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Panel *</label>
                    <input type="text" name="panel" value="{{ $test->panel }}" required class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Test Name *</label>
                    <input type="text" name="test" value="{{ $test->test }}" required class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Code</label>
                    <input type="text" name="code" value="{{ $test->code }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Unit</label>
                    <input type="text" name="unit" value="{{ $test->unit }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Result Type *</label>
                    <select name="result_type" required class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Select type</option>
                        <option value="Numeric" {{ $test->result_type == 'Numeric' ? 'selected' : '' }}>Numeric</option>
                        <option value="Text" {{ $test->result_type == 'Text' ? 'selected' : '' }}>Text</option>
                        <option value="Qualitative" {{ $test->result_type == 'Qualitative' ? 'selected' : '' }}>Qualitative</option>
                        <option value="Range" {{ $test->result_type == 'Range' ? 'selected' : '' }}>Range</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Normal Range</label>
                    <input type="text" name="normal_range" value="{{ $test->normal_range }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., 7-56 or Normal">
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <a href="/lab_tests" class="px-6 py-2.5 border border-slate-200 rounded-lg hover:bg-slate-50 font-medium">Cancel</a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 font-medium">Update Test</button>
            </div>
        </form>
    </div>
</div>
@endsection
