@props([
    'id' => 'modal-' . uniqid(),
    'title' => null,
    'size' => 'md'
])

@php
    $sizeClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-full mx-4'
    ][$size] ?? 'max-w-lg';
@endphp

<div
    x-data="{ open: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $id }}') open = true"
    x-on:close-modal.window="if ($event.detail === '{{ $id }}') open = false"
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-secondary-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle {{ $sizeClasses }} w-full"
        >
            @if($title)
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-secondary-200">
                    <h3 class="text-lg leading-6 font-medium text-secondary-900">
                        {{ $title }}
                    </h3>
                </div>
            @endif

            <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                {{ $slot }}
            </div>

            @if(isset($footer))
                <div class="bg-secondary-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-secondary-200">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
