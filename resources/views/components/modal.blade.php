@props([
    'id' => 'modal-' . uniqid(),
    'title' => null,
    'size' => 'md'
])

@php
    $sizeClasses = [
        'sm' => 'modal-sm',
        'md' => '',
        'lg' => 'modal-lg',
        'xl' => 'modal-xl',
        'full' => 'modal-fullscreen'
    ][$size] ?? '';
@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog {{ $sizeClasses }}">
        <div class="modal-content">
            @if($title)
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif

            <div class="modal-body">
                {{ $slot }}
            </div>

            @if(isset($footer))
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('{{ $id }}');

    // Listen for open-modal event
    window.addEventListener('open-modal', function(e) {
        if (e.detail === '{{ $id }}') {
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        }
    });

    // Listen for close-modal event
    window.addEventListener('close-modal', function(e) {
        if (e.detail === '{{ $id }}') {
            const bsModal = bootstrap.Modal.getInstance(modal);
            if (bsModal) bsModal.hide();
        }
    });
});
</script>
