/**
 * Dropdowns Component - TailAdmin Style
 * Handles dropdown toggle with icons and divider support
 */
export function initDropdowns() {
    const dropdownTriggers = document.querySelectorAll('[x-data*="open"]');

    dropdownTriggers.forEach(dropdown => {
        const trigger = dropdown.querySelector('[x-on\\:click*="open"]');
        const menu = dropdown.querySelector('[x-show]');

        if (!trigger || !menu) return;

        // Toggle on trigger click
        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = menu.style.display !== 'none';
            menu.style.display = isOpen ? 'none' : 'block';
        });

        // Close on click away
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target)) {
                menu.style.display = 'none';
            }
        });
    });

    // Handle dropdown items with icons
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('click', () => {
            // Close parent dropdown if exists
            const parentDropdown = item.closest('[x-data]');
            if (parentDropdown) {
                const menu = parentDropdown.querySelector('[x-show]');
                if (menu) menu.style.display = 'none';
            }
        });
    });
}

// Auto-initialize on DOM load
document.addEventListener('DOMContentLoaded', initDropdowns);

export default { initDropdowns };
