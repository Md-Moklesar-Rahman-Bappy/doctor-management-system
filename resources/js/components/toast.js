/**
 * Toast Notifications - TailAdmin Style
 * Handles toast notification system with auto-dismiss
 */
const toasts = [];

export function showToast(message, type = 'info', duration = 5000) {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();

    const toast = document.createElement('div');
    toast.className = `toast toast-${type} flex items-center`;

    let iconColor = 'blue-light';
    if (type === 'error') iconColor = 'error';
    else if (type === 'success') iconColor = 'success';
    else if (type === 'warning') iconColor = 'warning';

    toast.innerHTML = `
        <svg class="toast-icon text-${iconColor}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            ${getToastIcon(type)}
        </svg>
        <span class="text-sm font-medium flex-1">${message}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;

    toastContainer.appendChild(toast);

    // Auto dismiss
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-10px)';
        toast.style.transition = 'all 300ms ease-out';
        setTimeout(() => toast.remove(), 300);
    }, duration);

    toasts.push(toast);
    return toast;
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'fixed top-4 right-4 z-50 flex flex-col gap-2';
    document.body.appendChild(container);
    return container;
}

function getToastIcon(type) {
    const icons = {
        success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>',
        info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
    };
    return icons[type] || icons.info;
}

// Expose globally for easy access
window.showToast = showToast;
window.showToastFromModule = showToast;

export default { showToast };
