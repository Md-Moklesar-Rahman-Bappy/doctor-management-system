@props(['type' => 'info', 'message' => '', 'show' => true, 'id' => 'toast', 'autoDismiss' => 5000])

<div id="{{ $id }}" class="toast align-items-center border-0 {{ $show ? 'show' : '' }}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="{{ $autoDismiss }}">
    <div class="d-flex">
        <div class="toast-body d-flex align-items-center">
            @if($type === 'success')
                <i class="fas fa-check-circle text-success me-2"></i>
            @elseif($type === 'error')
                <i class="fas fa-times-circle text-danger me-2"></i>
            @elseif($type === 'warning')
                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
            @else
                <i class="fas fa-info-circle text-info me-2"></i>
            @endif
            <span class="small">{{ $message }}</span>
        </div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
