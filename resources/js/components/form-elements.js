/**
 * Form Elements - TailAdmin Style
 * Handles toggle switches, custom checkboxes, date pickers
 */
export function initToggleSwitches() {
    const toggles = document.querySelectorAll('[role="switch"]');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const isOn = toggle.getAttribute('aria-checked') === 'true';
            toggle.setAttribute('aria-checked', (!isOn).toString());

            // Toggle classes
            if (!isOn) {
                toggle.classList.add('toggle-switch-active');
                toggle.querySelector('.toggle-switch-knob')?.classList.add('toggle-switch-knob-active');
            } else {
                toggle.classList.remove('toggle-switch-active');
                toggle.querySelector('.toggle-switch-knob')?.classList.remove('toggle-switch-knob-active');
            }

            // Update hidden input value
            const hiddenInput = toggle.parentElement?.querySelector('input[type="hidden"]');
            if (hiddenInput) {
                hiddenInput.value = !isOn ? '1' : '0';
            }
        });
    });
}

export function initCustomCheckboxes() {
    const checkboxes = document.querySelectorAll('.checkbox-custom');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                checkbox.classList.add('bg-brand-500', 'border-brand-500');
            } else {
                checkbox.classList.remove('bg-brand-500', 'border-brand-500');
            }
        });

        // Initial state
        if (checkbox.checked) {
            checkbox.classList.add('bg-brand-500', 'border-brand-500');
        }
    });
}

export function initFormElements() {
    initToggleSwitches();
    initCustomCheckboxes();

    // Add focus styles to form inputs
    const inputs = document.querySelectorAll('.form-input, .select-input, .date-picker');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.classList.add('ring-2', 'ring-brand-500', 'border-brand-500');
        });
        input.addEventListener('blur', () => {
            input.classList.remove('ring-2', 'ring-brand-500', 'border-brand-500');
        });
    });
}

// Auto-initialize on DOM load
document.addEventListener('DOMContentLoaded', initFormElements);

// Expose globally
window.initFormElements = initFormElements;
window.confirmDeleteFromModule = (url, name) => {
    if (confirm(`Delete ${name}? This action cannot be undone.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.innerHTML = `
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content || ''}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    }
};

export default { initToggleSwitches, initCustomCheckboxes, initFormElements };
