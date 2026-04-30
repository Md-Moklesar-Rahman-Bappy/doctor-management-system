@props([
    'items' => []
])

@if(count($items) > 0)
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            @foreach($items as $item)
                @if(isset($item['url']))
                    <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                @else
                    <li class="breadcrumb-item active">{{ $item['label'] }}</li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif
