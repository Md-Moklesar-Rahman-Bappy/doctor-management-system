/**
 * Tabs Component - TailAdmin Style
 * Handles tab switching with underline style and icon support
 */
export function initTabs() {
    const tabContainers = document.querySelectorAll('[x-data*="activeTab"]');

    tabContainers.forEach(container => {
        const tabButtons = container.querySelectorAll('[x-on\\:click*="activeTab"]');
        const tabPanels = container.querySelectorAll('[x-show]');

        tabButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                // Update active states
                tabButtons.forEach(btn => {
                    btn.classList.remove('tab-underline-active');
                    btn.classList.add('tab-underline');
                });
                button.classList.add('tab-underline-active');
                button.classList.remove('tab-underline');

                // Show/hide panels
                tabPanels.forEach((panel, panelIndex) => {
                    if (panelIndex === index) {
                        panel.style.display = 'block';
                    } else {
                        panel.style.display = 'none';
                    }
                });
            });
        });
    });
}

// Auto-initialize on DOM load
document.addEventListener('DOMContentLoaded', initTabs);

export default { initTabs };
