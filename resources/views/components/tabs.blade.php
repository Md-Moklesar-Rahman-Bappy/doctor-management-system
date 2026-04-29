@props(['tabs' => [], 'active' => 0, 'id' => 'tabs'])

<div x-data="{ activeTab: {{ $active }} }" class="w-full" id="{{ $id }}">
    <!-- Tab Headers -->
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px space-x-6" aria-label="Tabs">
            @foreach($tabs as $index => $tab)
                <button
                    @click="activeTab = {{ $index }}"
                    :class="activeTab === {{ $index }} ? 'tab-underline-active' : 'tab-underline'"
                >
                    @if(isset($tab['icon']))
                        <span class="tab-underline-icon">{!! $tab['icon'] !!}</span>
                    @endif
                    <span>{{ $tab['label'] }}</span>
                    @if(isset($tab['badge']))
                        <span class="tab-badge tab-badge-primary">{{ $tab['badge'] }}</span>
                    @endif
                </button>
            @endforeach
        </nav>
    </div>

    <!-- Tab Content -->
    <div class="mt-4">
        {{ $slot }}
    </div>
</div>
