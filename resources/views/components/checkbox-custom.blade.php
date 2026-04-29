@props(['id' => '', 'name' => '', 'checked' => false, 'label' => '', 'value' => '1'])

<label class="list-item cursor-pointer">
    <input
        type="checkbox"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $checked ? 'checked' : '' }}
        class="checkbox-custom"
    >
    @if($label)
        <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
    @endif
    {{ $slot }}
</label>
