@props([
    'icon' => null,
    'title' => null,
    'description' => null,
    'action' => null
])

<div class="py-5" data-aos="fade-up">
    <div class="d-flex align-items-center justify-content-center gap-3 mb-4">
        @if($icon)
            {{ $icon }}
        @else
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                <i class="fas fa-inbox text-muted"></i>
            </div>
        @endif
        <div class="text-start">
            @if($title)
                <h5 class="fw-bold text-dark mb-1">{{ $title }}</h5>
            @endif
            @if($description)
                <p class="text-muted mb-0">{{ $description }}</p>
            @endif
        </div>
    </div>

    @if($action)
        <div class="text-center mt-3">
            {{ $action }}
        </div>
    @endif
</div>
