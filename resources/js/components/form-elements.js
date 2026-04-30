/**
 * Bootstrap 5 Form Enhancements
 * Handles toggle switches, custom checkboxes, date pickers
 */

export function initToggleSwitches() {
    const toggles = document.querySelectorAll('.form-check-input[type="checkbox"][role="switch"]');

    toggles.forEach(toggle => {
        toggle.addEventListener('change', () => {
            const hiddenInput = toggle.closest('.mb-3')?.querySelector('input[type="hidden"]');
            if (hiddenInput) {
                hiddenInput.value = toggle.checked ? '1' : '0';
            }
        });
    });
}

export function initCustomCheckboxes() {
    const checkboxes = document.querySelectorAll('.form-check-input');

    checkboxes.forEach(checkbox => {
        // Initial state
        if (checkbox.checked) {
            checkbox.parentElement?.classList.add('selected');
        }
    });
}

export function initFormElements() {
    initToggleSwitches();
    initCustomCheckboxes();

    // Add focus styles to form inputs
    const inputs = document.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement?.classList.add('focused');
        });
        input.addEventListener('blur', () => {
            input.parentElement?.classList.remove('focused');
        });
    });
}

// Auto-initialize on DOM load
document.addEventListener('DOMContentLoaded', initFormElements);

// Expose globally
window.initFormElements = initFormElements;

export default { initToggleSwitches, initCustomCheckboxes, initFormElements };
