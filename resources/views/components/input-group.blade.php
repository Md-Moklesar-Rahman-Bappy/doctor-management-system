@props(['icon' => '', 'prepend' => '', 'append' => ''])

<div class="input-group">
    @if($prepend)
        <div class="input-group-prepend">{{ $prepend }}</div>
    @endif

    <div class="relative flex-1">
        @if($icon)
            <div class="input-icon">
                {!! $icon !!}
            </div>
        @endif

        {{ $slot }}
    </div>

    @if($append)
        <div class="input-group-append">{{ $append }}</div>
    @endif
</div>
