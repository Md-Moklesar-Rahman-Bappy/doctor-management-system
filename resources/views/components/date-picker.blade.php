@props([
    'name',
    'label' => null,
    'value' => null,
    'required' => false,
    'error' => null
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label fw-medium d-flex align-items-center gap-2">
            <i class="fas fa-calendar-alt"></i>
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <input
        type="date"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        class="form-control {{ $error ? 'is-invalid' : '' }}"
    >

    @if($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @endif
</div>
