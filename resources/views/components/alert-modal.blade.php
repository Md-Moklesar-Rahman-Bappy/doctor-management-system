@props(['type' => 'info', 'title' => '', 'message' => '', 'show' => true, 'id' => 'alert-modal'])

<div x-data="{ show: {{ $show ? 'true' : 'false' }} }" x-show="show" x-transition class="alert-modal" id="{{ $id }}">
    <div class="alert-content">
        <div class="text-center">
            <!-- Success Icon -->
            @if($type === 'success')
                <div class="alert-icon-success">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            @endif

            <!-- Error Icon -->
            @if($type === 'error')
                <div class="alert-icon-error">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            @endif

            <!-- Warning Icon -->
            @if($type === 'warning')
                <div class="alert-icon-warning">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
            @endif

            <!-- Info Icon -->
            @if($type === 'info')
                <div class="alert-icon-info">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            @endif

            @if($title)
                <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ $title }}</h3>
            @endif

            @if($message)
                <p class="mt-2 text-sm text-gray-600">{{ $message }}</p>
            @endif

            <div class="mt-6 flex items-center justify-center gap-3">
                {{ $slot ?? '' }}
                <button @click="show = false" class="btn-secondary">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
