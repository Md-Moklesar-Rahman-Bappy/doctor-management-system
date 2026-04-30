@props([
    'name',
    'label' => null,
    'checked' => false,
    'help' => null
])

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        @if($label)
            <label for="{{ $name }}" class="form-label fw-medium mb-0">{{ $label }}</label>
        @endif
        @if($help)
            <div class="form-text small">{{ $help }}</div>
        @endif
    </div>
    <div class="form-check form-switch">
        <input
            type="checkbox"
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $checked ? 'checked' : '' }}
            class="form-check-input"
            role="switch"
        >
    </div>
</div>
