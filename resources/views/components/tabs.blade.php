@props([
    'id' => 'tabs-' . uniqid(),
    'tabs' => [],
    'active' => 0
])

<div class="mb-3">
    <ul class="nav nav-tabs" id="{{ $id }}" role="tablist">
        @foreach($tabs as $index => $tab)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $index == $active ? 'active' : '' }}"
                        id="{{ $id }}-tab-{{ $index }}"
                        data-bs-toggle="tab"
                        data-bs-target="#{{ $id }}-panel-{{ $index }}"
                        type="button"
                        role="tab"
                        aria-controls="{{ $id }}-panel-{{ $index }}"
                        aria-selected="{{ $index == $active ? 'true' : 'false' }}">
                    @if(isset($tab['icon']))
                        <i class="{{ $tab['icon'] }} me-2"></i>
                    @endif
                    {{ $tab['label'] }}
                </button>
            </li>
        @endforeach
    </ul>
    <div class="tab-content border border-top-0 rounded-bottom p-3" id="{{ $id }}Content">
        @foreach($tabs as $index => $tab)
            <div class="tab-pane fade {{ $index == $active ? 'show active' : '' }}"
                 id="{{ $id }}-panel-{{ $index }}"
                 role="tabpanel"
                 aria-labelledby="{{ $id }}-tab-{{ $index }}">
                {{ $tab['content'] ?? '' }}
            </div>
        @endforeach
    </div>
</div>
