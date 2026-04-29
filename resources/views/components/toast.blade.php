@props(['type' => 'info', 'message' => '', 'show' => true, 'id' => 'toast', 'autoDismiss' => 5000])

<div x-data="{ show: {{ $show ? 'true' : 'false' }} }"
     x-init="setTimeout(() => show = false, {{ $autoDismiss }})"
     x-show="show"
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     x-transition:leave="transform ease-in duration-200 transition"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="toast toast-{{ $type }} flex items-center"
     id="{{ $id }}">

    <!-- Success Icon -->
    @if($type === 'success')
        <svg class="toast-icon text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    @endif

    <!-- Error Icon -->
    @if($type === 'error')
        <svg class="toast-icon text-error-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    @endif

    <!-- Warning Icon -->
    @if($type === 'warning')
        <svg class="toast-icon text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
        </svg>
    @endif

    <!-- Info Icon -->
    @if($type === 'info')
        <svg class="toast-icon text-blue-light-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    @endif

    <span class="text-sm font-medium flex-1">{{ $message }}</span>

    <button @click="show = false" class="toast-close">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
