@props([
    'value' => null,
    'max' => 5,
    'required' => false,
    'label' => 'Add Item',
    'placeholder' => 'Type and press Enter...'
])

<div
    x-data="{
        items: {{ json_encode($value ? (is_array($value) ? $value : json_decode($value, true) ?? []) : []) }},
        newItem: '',
        addItem() {
            if (this.newItem.trim() && this.items.length < this.max) {
                this.items.push(this.newItem.trim());
                this.newItem = '';
            }
        },
        removeItem(index) {
            this.items.splice(index, 1);
        }
    }"
    class="mb-4"
>
    <template x-if="$el.previousElementSibling && $el.previousElementSibling.tagName !== 'LABEL'">
        <label class="block text-sm font-medium text-secondary-700 mb-1.5">@lang($label)</label>
    </template>

    <div class="flex flex-wrap gap-2 mb-2">
        <template x-for="(item, index) in items" :key="index">
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary-50 text-primary-700 rounded-full text-sm">
                <span x-text="item"></span>
                <button type="button" @click="removeItem(index)" class="hover:text-primary-900 focus:outline-none">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <input type="hidden" :name="`${$el.closest('[x-data]').querySelector('[name]')?.name || 'items[]'}[]`" :value="item">
            </span>
        </template>
    </div>

    <div class="flex gap-2">
        <input
            type="text"
            x-model="newItem"
            @keydown.enter.prevent="addItem()"
            placeholder="{{ $placeholder }}"
            class="flex-1 px-4 py-2 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
        >
        <button
            type="button"
            @click="addItem()"
            class="btn-secondary text-sm"
        >Add</button>
    </div>

    <p class="mt-1.5 text-xs text-secondary-500" x-text="`${items.length}/${max} items`"></p>
</div>
