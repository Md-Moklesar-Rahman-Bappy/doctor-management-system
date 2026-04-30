@props([
    'name',
    'label' => null,
    'accept' => null,
    'required' => false,
    'error' => null,
    'help' => null
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

    <input
        type="file"
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $accept ? "accept=$accept" : '' }}
        {{ $required ? 'required' : '' }}
        class="form-control {{ $error ? 'is-invalid' : '' }}"
    >

    @if($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @endif

    @if($help)
        <div class="form-text small">{{ $help }}</div>
    @endif
</div>
