@props([
    'title' => null,
    'value' => null,
    'icon' => null,
    'color' => 'primary',
    'trend' => null,
    'trendValue' => null,
])

@php
    $colorClasses = [
        'primary' => 'bg-primary-100 text-primary-600',
        'blue' => 'bg-blue-100 text-blue-600',
        'emerald' => 'bg-emerald-100 text-emerald-600',
        'sky' => 'bg-sky-100 text-sky-600',
        'amber' => 'bg-amber-100 text-amber-600',
        'red' => 'bg-red-100 text-red-600',
    ][$color] ?? 'bg-primary-100 text-primary-600';

    $trendClasses = [
        'up' => 'text-green-600',
        'down' => 'text-red-600',
        'neutral' => 'text-slate-500',
    ][$trend] ?? 'text-slate-500';
@endphp

<div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 card-hover">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-secondary-500">{{ $title }}</p>
            <p class="text-3xl font-bold text-secondary-900 mt-1">{{ $value }}</p>
            @if($trend && $trendValue)
                <p class="text-xs mt-1 {{ $trendClasses }}">
                    @if($trend === 'up')
                        ↑
                    @elseif($trend === 'down')
                        ↓
                    @endif
                    {{ $trendValue }}
                </p>
            @endif
        </div>
        @if($icon)
            <div class="w-12 h-12 {{ $colorClasses }} rounded-lg flex items-center justify-center">
                {{ $icon }}
            </div>
        @endif
    </div>
</div>
