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
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500 shadow-sm',
        'secondary' => 'bg-white text-secondary-700 border border-secondary-300 hover:bg-secondary-50 focus:ring-secondary-500 shadow-sm',
        'danger' => 'bg-danger text-white hover:bg-red-700 focus:ring-red-500 shadow-sm',
        'success' => 'bg-success text-white hover:bg-green-700 focus:ring-green-500 shadow-sm',
        'warning' => 'bg-warning text-white hover:bg-yellow-600 focus:ring-yellow-500 shadow-sm',
        'ghost' => 'text-secondary-700 hover:bg-secondary-100 focus:ring-secondary-500',
        'link' => 'text-primary-600 hover:text-primary-700 underline-offset-4 hover:underline focus:ring-primary-500',
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
