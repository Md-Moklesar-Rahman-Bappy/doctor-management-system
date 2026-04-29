@props([
    'icon' => null,
    'title' => null,
    'description' => null,
    'action' => null
])

<div class="text-center py-12 px-4">
    @if($icon)
        <div class="mx-auto w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mb-4">
            {{ $icon }}
        </div>
    @else
        <div class="mx-auto w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        </div>
    @endif

    @if($title)
        <h3 class="text-sm font-medium text-secondary-900 mb-1">{{ $title }}</h3>
    @endif

    @if($description)
        <p class="text-sm text-secondary-500 mb-4">{{ $description }}</p>
    @endif

    @if($action)
        <div class="mt-4">
            {{ $action }}
        </div>
    @endif
</div>
