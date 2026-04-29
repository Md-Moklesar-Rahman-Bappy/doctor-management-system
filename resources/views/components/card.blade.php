@props([
    'title' => null,
    'subtitle' => null,
    'padding' => true,
    'shadow' => 'md',
    'hover' => false,
    'header' => null,
    'footer' => null
])

<div class="bg-white rounded-xl border border-secondary-200 shadow-{{ $shadow }} {{ $hover ? 'card-hover' : '' }}">
    @if($title || $header)
        <div class="px-6 py-4 border-b border-secondary-200">
            @if($title)
                <h3 class="text-lg font-semibold text-secondary-900">{{ $title }}</h3>
                @if($subtitle)
                    <p class="mt-1 text-sm text-secondary-500">{{ $subtitle }}</p>
                @endif
            @endif
            @if($header)
                {{ $header }}
            @endif
        </div>
    @endif

    <div class="{{ $padding ? 'p-6' : '' }}">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-4 border-t border-secondary-200">
            {{ $footer }}
        </div>
    @endif
</div>
