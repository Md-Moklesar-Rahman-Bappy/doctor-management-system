@props([
    'icon' => null,
    'title' => null,
    'description' => null,
    'action' => null
])

<div class="empty-state" data-aos="fade-up">
    @if($icon)
        <div class="empty-state-icon">
            {{ $icon }}
        </div>
    @else
        <div class="empty-state-icon">
            <i class="fas fa-inbox text-muted" style="font-size: 2.5rem; opacity: 0.3;"></i>
        </div>
    @endif

    @if($title)
        <h6 class="fw-semibold text-dark mb-1">{{ $title }}</h6>
    @endif

    @if($description)
        <p class="text-muted small mb-3">{{ $description }}</p>
    @endif

    @if($action)
        <div class="mt-3">
            {{ $action }}
        </div>
    @endif
</div>
