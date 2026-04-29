@props(['trigger' => '', 'align' => 'right', 'width' => '48'])

@php
    $alignClass = match($align) {
        'left' => 'left-0',
        'center' => 'left-1/2 -translate-x-1/2',
        default => 'right-0'
    };

    $widthClass = match($width) {
        '48' => 'w-48',
        '56' => 'w-56',
        '64' => 'w-64',
        default => 'w-48'
    };
@endphp

<div x-data="{ open: false }" class="relative inline-block text-left">
    <!-- Trigger -->
    <div @click="open = !open" class="cursor-pointer">
        {{ $trigger }}
    </div>

    <!-- Dropdown Menu -->
    <div x-show="open"
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute z-50 mt-2 {{ $alignClass }} {{ $widthClass }} bg-white rounded-lg shadow-lg border border-gray-200 py-1"
         style="display: none;">
        {{ $slot }}
    </div>
</div>
