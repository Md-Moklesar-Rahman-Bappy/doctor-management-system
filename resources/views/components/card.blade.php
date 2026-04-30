@props([
    'title' => null,
    'subtitle' => null,
    'shadow' => 'md',
    'hover' => false,
    'header' => null,
    'footer' => null
])

<div class="card {{ $shadow === 'md' ? 'shadow-sm' : ($shadow === 'lg' ? 'shadow' : '') }} {{ $hover ? 'card-hover' : '' }}">
    @if($title || $header)
        <div class="card-header bg-white border-bottom">
            @if($title)
                <h5 class="card-title fw-semibold mb-0">{{ $title }}</h5>
                @if($subtitle)
                    <p class="card-text text-muted small mt-1 mb-0">{{ $subtitle }}</p>
                @endif
            @endif
            @if($header)
                {{ $header }}
            @endif
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="card-footer bg-white border-top">
            {{ $footer }}
        </div>
    @endif
</div>
