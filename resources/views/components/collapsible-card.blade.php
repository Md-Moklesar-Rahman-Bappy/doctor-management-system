@props([
    'title' => null,
    'footer' => null,
])

<div x-data="{ open: true }" class="bg-white rounded-xl shadow-sm border border-secondary-200">
    <div class="px-6 py-4 border-b border-secondary-200 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-secondary-900">{{ $title }}</h3>
        <button @click="open = !open" class="p-1 hover:bg-secondary-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-secondary-500 transform transition-transform duration-200" :class="{ 'rotate-180': !open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
    </div>
    <div x-show="open" x-transition class="p-6">
        {{ $slot }}
    </div>
    @if($footer)
        <div class="px-6 py-4 border-t border-secondary-200 bg-secondary-50" x-show="open">
            {{ $footer }}
        </div>
    @endif
</div>
