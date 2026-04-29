@props(['id' => 'toggle', 'name' => 'toggle', 'checked' => false, 'label' => ''])

<div class="flex items-center justify-between">
    @if($label)
        <label for="{{ $id }}" class="form-label mb-0">{{ $label }}</label>
    @endif

    <button
        type="button"
        id="{{ $id }}"
        :class="{{ $checked ? "'toggle-switch toggle-switch-active'" : "'toggle-switch'" }}"
        x-data="{ on: {{ $checked ? 'true' : 'false' }} }"
        @click="on = !on"
        role="switch"
        :aria-checked="on.toString()"
    >
        <span
            :class="on ? 'toggle-switch-knob toggle-switch-knob-active' : 'toggle-switch-knob'"
        ></span>
    </button>

    <!-- Hidden input to submit value -->
    <input type="hidden" name="{{ $name }}" :value="on ? '1' : '0'">
</div>
