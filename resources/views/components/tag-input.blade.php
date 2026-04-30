@props([
    'name',
    'label' => null,
    'tags' => [],
    'placeholder' => 'Add tag...'
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label fw-medium">{{ $label }}</label>
    @endif

    <div class="input-group">
        <input type="text"
               id="{{ $name }}-input"
               class="form-control"
               placeholder="{{ $placeholder }}"
               onkeydown="if(event.key === 'Enter') { event.preventDefault(); addTag('{{ $name }}'); }">
        <button class="btn btn-outline-secondary" type="button" onclick="addTag('{{ $name }}')">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <div id="{{ $name }}-tags" class="d-flex flex-wrap gap-1 mt-2">
        @foreach($tags as $tag)
            <span class="badge bg-primary">
                {{ $tag }}
                <input type="hidden" name="{{ $name }}[]" value="{{ $tag }}">
                <i class="fas fa-times ms-1" style="cursor: pointer;" onclick="removeTag(this, '{{ $name }}')"></i>
            </span>
        @endforeach
    </div>

    <input type="hidden" id="{{ $name }}-hidden" name="{{ $name }}" value="{{ implode(',', $tags) }}">
</div>

<script>
function addTag(name) {
    const input = document.getElementById(name + '-input');
    const value = input.value.trim();
    if (!value) return;

    const tagsContainer = document.getElementById(name + '-tags');
    const hiddenInput = document.getElementById(name + '-hidden');

    // Create tag badge
    const tag = document.createElement('span');
    tag.className = 'badge bg-primary';
    tag.innerHTML = value + ' <input type="hidden" name="' + name + '[]" value="' + value + '"><i class="fas fa-times ms-1" style="cursor: pointer;" onclick="removeTag(this, \'' + name + '\')"></i>';
    tagsContainer.appendChild(tag);

    // Update hidden input
    updateHiddenInput(name);
    input.value = '';
}

function removeTag(element, name) {
    element.parentElement.remove();
    updateHiddenInput(name);
}

function updateHiddenInput(name) {
    const tags = [];
    const hiddenInput = document.getElementById(name + '-hidden');
    document.querySelectorAll('#' + name + '-tags input[name="' + name + '[]"]').forEach(input => {
        tags.push(input.value);
    });
    hiddenInput.value = tags.join(',');
}
</script>
