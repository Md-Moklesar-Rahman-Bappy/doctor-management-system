@props(['id' => '', 'name' => '', 'label' => '', 'placeholder' => 'Select an option', 'options' => [], 'selected' => ''])

<div>
    @if($label)
        <label for="{{ $id }}" class="form-label flex items-center gap-2">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            class="select-input"
        >
            <option value="">{{ $placeholder }}</option>
            @foreach($options as $value => $text)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $text }}</option>
            @endforeach
        </select>
        <div class="select-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>
</div>
