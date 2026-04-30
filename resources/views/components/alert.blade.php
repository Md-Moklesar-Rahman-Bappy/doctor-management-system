@props([
    'variant' => 'info',
    'dismissible' => false,
    'title' => null,
])

@php
    $variants = [
        'success' => 'alert-success',
        'warning' => 'alert-warning',
        'danger' => 'alert-danger',
        'info' => 'alert-info',
    ];

    $icons = [
        'success' => 'fa-check-circle',
        'warning' => 'fa-exclamation-triangle',
        'danger' => 'fa-times-circle',
        'info' => 'fa-info-circle',
    ];
@endphp

<div class="alert {{ $variants[$variant] ?? $variants['info'] }} {{ $dismissible ? 'alert-dismissible fade show' : '' }}" role="alert">
    <div class="d-flex align-items-start">
        <div class="me-2">
            <i class="fas {{ $icons[$variant] ?? $icons['info'] }}"></i>
        </div>
        <div class="flex-grow-1">
            @if($title)
                <h6 class="alert-heading fw-semibold mb-1">{{ $title }}</h6>
            @endif
            <div class="{{ $title ? 'mb-0 small' : '' }}">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        @endif
    </div>
</div>
