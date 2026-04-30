@props([
    'id' => 'announcement-' . uniqid(),
    'type' => 'info',
    'message' => '',
    'dismissible' => true
])

@php
    $types = [
        'info' => ['bg' => 'bg-info-subtle', 'text' => 'text-info-emphasis', 'icon' => 'fa-info-circle'],
        'success' => ['bg' => 'bg-success-subtle', 'text' => 'text-success-emphasis', 'icon' => 'fa-check-circle'],
        'warning' => ['bg' => 'bg-warning-subtle', 'text' => 'text-warning-emphasis', 'icon' => 'fa-exclamation-triangle'],
        'danger' => ['bg' => 'bg-danger-subtle', 'text' => 'text-danger-emphasis', 'icon' => 'fa-exclamation-circle'],
    ];

    $config = $types[$type] ?? $types['info'];
@endphp

<div class="alert {{ $config['bg'] }} {{ $config['text'] }} d-flex align-items-center gap-2 py-2 px-3 mb-0 position-relative" role="alert">
    <i class="fas {{ $config['icon'] }}"></i>
    <span class="small flex-grow-1">{{ $message }}</span>
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
