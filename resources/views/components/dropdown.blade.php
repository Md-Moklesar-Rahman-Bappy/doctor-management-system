@props([
    'id' => 'dropdown-' . uniqid(),
    'label' => null,
    'icon' => null,
    'items' => []
])

<div class="dropdown">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="{{ $id }}" data-bs-toggle="dropdown" aria-expanded="false">
        @if($icon)<i class="{{ $icon }} me-2"></i>@endif
        {{ $label }}
    </button>
    <ul class="dropdown-menu" aria-labelledby="{{ $id }}">
        @foreach($items as $item)
            @if(isset($item['divider']) && $item['divider'])
                <li><hr class="dropdown-divider"></li>
            @else
                <li>
                    <a class="dropdown-item {{ isset($item['active']) && $item['active'] ? 'active' : '' }}"
                       href="{{ $item['url'] ?? '#' }}">
                        @if(isset($item['icon']))<i class="{{ $item['icon'] }} me-2"></i>@endif
                        {{ $item['label'] }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
