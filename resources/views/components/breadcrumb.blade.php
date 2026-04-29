@if(isset($breadcrumbs) && count($breadcrumbs) > 0)
<nav class="breadcrumb" aria-label="Breadcrumb">
    <ol class="flex items-center gap-1.5">
        @foreach($breadcrumbs as $index => $crumb)
            <li class="flex items-center gap-1.5">
                @if(isset($crumb['url']) && !$loop->last)
                    <a href="{{ $crumb['url'] }}" class="flex items-center gap-1.5 text-gray-500 hover:text-brand-500 transition-colors">
                        @if(isset($crumb['icon']))
                            <span class="breadcrumb-icon">{!! $crumb['icon'] !!}</span>
                        @endif
                        <span>{{ $crumb['label'] }}</span>
                    </a>
                @else
                    <span class="flex items-center gap-1.5 {{ $loop->last ? 'breadcrumb-active' : 'text-gray-500' }}">
                        @if(isset($crumb['icon']))
                            <span class="breadcrumb-icon">{!! $crumb['icon'] !!}</span>
                        @endif
                        <span>{{ $crumb['label'] }}</span>
                    </span>
                @endif
            </li>
            @if(!$loop->last)
                <li class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
@endif
