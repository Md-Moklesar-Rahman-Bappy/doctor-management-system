@props([
    'type' => 'text',
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'help' => null,
    'icon' => null
])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-secondary-700 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-secondary-400">
                {!! $icon !!}
            </div>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm {{ $icon ? 'pl-10' : '' }} {{ $error ? 'border-error focus:ring-error focus:border-error' : '' }} disabled:bg-gray-50 disabled:text-gray-500"
        >

        @if($error)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-danger" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
        @endif
    </div>

    @if($error)
        <p class="mt-1.5 text-sm text-danger">{{ $error }}</p>
    @elseif($help)
        <p class="mt-1.5 text-sm text-secondary-500">{{ $help }}</p>
    @endif
</div>
