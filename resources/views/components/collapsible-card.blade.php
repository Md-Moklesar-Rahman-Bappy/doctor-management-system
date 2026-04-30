@props([
    'title' => null,
    'id' => 'collapse-' . uniqid(),
    'show' => false
])

<div class="card shadow-sm">
    <div class="card-header bg-white" id="{{ $id }}Header">
        <h6 class="mb-0">
            <button class="btn btn-link text-decoration-none p-0 {{ $show ? '' : 'collapsed' }}"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#{{ $id }}"
                    aria-expanded="{{ $show ? 'true' : 'false' }}"
                    aria-controls="{{ $id }}">
                <i class="fas fa-chevron-{{ $show ? 'down' : 'right' }} me-2 small"></i>
                {{ $title }}
            </button>
        </h6>
    </div>

    <div id="{{ $id }}" class="collapse {{ $show ? 'show' : '' }}" aria-labelledby="{{ $id }}Header">
        <div class="card-body">
            {{ $slot }}
        </div>
    </div>
</div>
