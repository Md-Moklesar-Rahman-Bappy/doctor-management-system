@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'disabled' => false,
    'fullWidth' => false,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary' => 'bg-brand-500 text-white hover:bg-brand-600 focus:ring-brand-500 shadow-sm',
        'secondary' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-gray-500 shadow-sm',
        'danger' => 'bg-error-500 text-white hover:bg-error-600 focus:ring-error-500 shadow-sm',
        'success' => 'bg-success-500 text-white hover:bg-success-600 focus:ring-success-500 shadow-sm',
        'warning' => 'bg-warning-500 text-white hover:bg-warning-600 focus:ring-warning-500 shadow-sm',
        'ghost' => 'text-gray-700 hover:bg-gray-100 focus:ring-gray-500',
        'link' => 'text-brand-600 hover:text-brand-700 underline-offset-4 hover:underline focus:ring-brand-500',
    ];

    $sizes = [
        'sm' => 'text-xs px-3 py-1.5 gap-1.5',
        'md' => 'text-sm px-4 py-2 gap-2',
        'lg' => 'text-base px-6 py-3 gap-2.5',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']) . ($fullWidth ? ' w-full' : '');
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $classes }}">
        @if($icon && $iconPosition === 'left')
            <span class="w-4 h-4">{!! $icon !!}</span>
        @endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right')
            <span class="w-4 h-4">{!! $icon !!}</span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} class="{{ $classes }}">
        @if($icon && $iconPosition === 'left')
            <span class="w-4 h-4">{!! $icon !!}</span>
        @endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right')
            <span class="w-4 h-4">{!! $icon !!}</span>
        @endif
    </button>
@endif
