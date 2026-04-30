@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'required' => false,
    'error' => null,
    'placeholder' => 'Select...'
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label fw-medium">
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
        class="form-select {{ $error ? 'is-invalid' : '' }}"
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ (old($name, $selected) == $value) ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>

    @if($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @endif
</div>
