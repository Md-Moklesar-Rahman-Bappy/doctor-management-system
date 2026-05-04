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

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label fw-medium d-flex align-items-center gap-2">
            @if($icon)<i class="{{ $icon }}"></i>@endif
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <div>
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            class="form-control {{ $error ? 'is-invalid' : '' }}"
        >

        @if($error)
            <div class="invalid-feedback">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $error }}
            </div>
        @endif
    </div>

    @if($help && !$error)
        <div class="form-text">{{ $help }}</div>
    @endif
</div>
