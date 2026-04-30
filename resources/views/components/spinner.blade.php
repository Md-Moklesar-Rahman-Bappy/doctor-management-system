@props([
    'size' => 'md',
    'color' => 'primary',
    'type' => 'border'
])

@php
    $sizes = [
        'sm' => 'spinner-border-sm',
        'md' => '',
        'lg' => 'spinner-border-lg',
    ];

    $colors = [
        'primary' => 'text-primary',
        'secondary' => 'text-secondary',
        'success' => 'text-success',
        'danger' => 'text-danger',
        'warning' => 'text-warning',
        'info' => 'text-info',
        'light' => 'text-light',
        'dark' => 'text-dark',
    ];

    $sizeClass = $sizes[$size] ?? '';
    $colorClass = $colors[$color] ?? '';
@endphp

@if($type === 'grow')
    <div class="spinner-grow {{ $sizeClass }} {{ $colorClass }}" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
@else
    <div class="spinner-border {{ $sizeClass }} {{ $colorClass }}" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
@endif
