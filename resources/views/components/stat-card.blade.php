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
        'primary' => 'bg-brand-100 text-brand-600',
        'blue' => 'bg-blue-light-100 text-blue-light-600',
        'emerald' => 'bg-success-100 text-success-600',
        'sky' => 'bg-blue-light-100 text-blue-light-600',
        'amber' => 'bg-warning-100 text-warning-600',
        'red' => 'bg-error-100 text-error-600',
    ][$color] ?? 'bg-brand-100 text-brand-600';

    $trendClasses = [
        'up' => 'text-success-600',
        'down' => 'text-error-600',
        'neutral' => 'text-gray-500',
    ][$trend] ?? 'text-gray-500';
@endphp

<div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 card-hover">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            @if($icon)
                <div class="w-12 h-12 {{ $colorClasses }} rounded-lg flex items-center justify-center flex-shrink-0">
                    {{ $icon }}
                </div>
            @endif
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
        </div>
    </div>
</div>
