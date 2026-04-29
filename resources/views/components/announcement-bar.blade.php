@props(['message' => '', 'link' => '', 'linkText' => '', 'dismissible' => true, 'id' => 'announcement'])

<div x-data="{ show: true }" x-show="show" class="announcement relative" id="{{ $id }}">
    <div class="flex items-center justify-center gap-2">
        <span>{{ $message }}</span>
        @if($link)
            <a href="{{ $link }}" class="announcement-link">{{ $linkText ?: 'Learn more' }}</a>
        @endif
    </div>

    @if($dismissible)
        <button @click="show = false" class="announcement-close">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    @endif
</div>
