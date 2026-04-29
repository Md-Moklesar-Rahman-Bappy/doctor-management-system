@props([
    'name' => null,
    'type' => 'text',
    'label' => null,
    'placeholder' => null,
    'value' => null,
    'required' => false,
    'accept' => null,
    'help' => null,
    'error' => null
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

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        accept="{{ $accept }}"
        {{ $required ? 'required' : '' }}
        class="block w-full rounded-lg border-secondary-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm {{ $error ? 'border-danger focus:ring-danger focus:border-danger' : '' }}"
    >

    @if($help)
        <p class="mt-1.5 text-sm text-secondary-500">{{ $help }}</p>
    @endif

    @if($error)
        <p class="mt-1.5 text-sm text-danger">{{ $error }}</p>
    @endif
</div>
