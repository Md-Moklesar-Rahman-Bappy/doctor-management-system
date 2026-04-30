@props([
    'icon' => null,
    'title' => null,
    'description' => null,
    'action' => null
])

<div class="empty-state text-center py-5" data-aos="fade-up">
    @if($icon)
        <div class="mb-4">
            {{ $icon }}
        </div>
    @else
        <div class="mb-4">
            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                <i class="fas fa-inbox text-muted" style="font-size: 2rem; opacity: 0.3;"></i>
            </div>
        </div>
    @endif

    @if($title)
        <h5 class="fw-bold text-dark mb-2">{{ $title }}</h5>
    @endif

    @if($description)
        <p class="text-muted mb-4" style="max-width: 320px; margin: 0 auto;">{{ $description }}</p>
    @endif

    @if($action)
        <div class="mt-2">
            {{ $action }}
        </div>
    @endif
</div>
