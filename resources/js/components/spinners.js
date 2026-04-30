/**
 * Bootstrap 5 Spinners
 * Handles spinner display with button integration
 */

export function showSpinner(button, spinnerSize = 'md') {
    if (!button) return;

    const originalText = button.innerHTML;
    button.disabled = true;
    button.dataset.originalText = originalText;

    const spinnerClass = spinnerSize === 'sm' ? 'spinner-border-sm' :
                        spinnerSize === 'lg' ? '' : '';

    button.innerHTML = `<span class="spinner-border ${spinnerClass}" role="status" aria-hidden="true"></span><span class="ms-2">Loading...</span>`;

    return () => hideSpinner(button);
}

export function hideSpinner(button) {
    if (!button || !button.dataset.originalText) return;
    button.disabled = false;
    button.innerHTML = button.dataset.originalText;
    delete button.dataset.originalText;
}

export function initButtonSpinners() {
    const buttons = document.querySelectorAll('[data-spinner]');

    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            if (button.disabled) return;

            const hide = showSpinner(button, button.dataset.spinnerSize);

            // Auto-hide after delay if specified
            if (button.dataset.autoHide) {
                setTimeout(() => hide(), parseInt(button.dataset.autoHide));
            }
        });
    });
}

// Auto-initialize on DOM load
document.addEventListener('DOMContentLoaded', initButtonSpinners);

export default { showSpinner, hideSpinner, initButtonSpinners };
