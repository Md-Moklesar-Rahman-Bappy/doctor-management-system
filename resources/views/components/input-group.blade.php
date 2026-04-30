@props([
    'label' => null,
    'name',
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'error' => null,
    'help' => null,
    'prepend' => null,
    'append' => null
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

    <div class="input-group">
        @if($prepend)
            <span class="input-group-text">{!! $prepend !!}</span>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            class="form-control {{ $error ? 'is-invalid' : '' }}"
        >

        @if($append)
            <span class="input-group-text">{!! $append !!}</span>
        @endif

        @if($error)
            <div class="invalid-feedback">{{ $error }}</div>
        @endif
    </div>

    @if($help && !$error)
        <div class="form-text small">{{ $help }}</div>
    @endif
</div>
