@props(['size' => 'md', 'color' => 'brand'])

@php
    $sizeClass = match($size) {
        'sm' => 'spinner-sm',
        'lg' => 'spinner-lg',
        default => 'spinner'
    };

    $colorClass = match($color) {
        'success' => 'border-success-500',
        'error' => 'border-error-500',
        'warning' => 'border-warning-500',
        default => 'border-brand-500'
    };
@endphp

<div class="{{ $sizeClass }} {{ $colorClass }}"></div>
