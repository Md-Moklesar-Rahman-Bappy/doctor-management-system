/**
 * Bootstrap 5 Dropdowns
 * Uses native Bootstrap 5 dropdown component
 */

export function initDropdowns() {
    // Initialize all dropdowns using Bootstrap's native JS
    const dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
    dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });

    // Handle dropdown items with icons
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('click', () => {
            // Close parent dropdown
            const parentDropdown = item.closest('.dropdown');
            if (parentDropdown) {
                const dropdownToggle = parentDropdown.querySelector('[data-bs-toggle="dropdown"]');
                if (dropdownToggle) {
                    const dropdown = bootstrap.Dropdown.getInstance(dropdownToggle);
                    if (dropdown) dropdown.hide();
                }
            }
        });
    });
}

// Auto-initialize on DOM load
document.addEventListener('DOMContentLoaded', initDropdowns);

export default { initDropdowns };
