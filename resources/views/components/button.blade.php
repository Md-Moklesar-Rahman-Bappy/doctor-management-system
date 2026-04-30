@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'disabled' => false,
    'fullWidth' => false,
    'icon' => null,
])

@php
    $variants = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'danger' => 'btn-danger',
        'success' => 'btn-success',
        'warning' => 'btn-warning',
        'ghost' => 'btn-outline-secondary',
        'link' => 'btn-link text-decoration-none',
    ];

    $sizes = [
        'sm' => 'btn-sm',
        'md' => '',
        'lg' => 'btn-lg',
    ];

    $classes = 'btn ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? '') . ($fullWidth ? ' w-100' : '');
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $classes }}">
        @if($icon)<i class="{{ $icon }} me-2"></i>@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} class="{{ $classes }}">
        @if($icon)<i class="{{ $icon }} me-2"></i>@endif
        {{ $slot }}
    </button>
@endif
