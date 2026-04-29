@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Select an option',
    'required' => false,
    'error' => null,
    'help' => null
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

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        class="block w-full rounded-lg border-secondary-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm {{ $error ? 'border-danger focus:ring-danger focus:border-danger' : '' }}"
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>

    @if($error)
        <p class="mt-1.5 text-sm text-danger">{{ $error }}</p>
    @elseif($help)
        <p class="mt-1.5 text-sm text-secondary-500">{{ $help }}</p>
    @endif
</div>
