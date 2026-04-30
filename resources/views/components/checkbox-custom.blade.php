@props([
    'name',
    'label' => null,
    'checked' => false,
    'value' => 1
])

<div class="form-check mb-3">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        {{ $checked ? 'checked' : '' }}
        class="form-check-input"
    >
    @if($label)
        <label class="form-check-label" for="{{ $name }}">
            {{ $label }}
        </label>
    @endif
</div>
