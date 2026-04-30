/**
 * Bootstrap 5 Tabs
 * Uses native Bootstrap 5 tab component
 */

export function initTabs() {
    // Initialize all tabs using Bootstrap's native JS
    const tabElements = [].slice.call(document.querySelectorAll('#myTab button, [data-bs-toggle="tab"]'));
    tabElements.map(function (tabEl) {
        return new bootstrap.Tab(tabEl);
    });
}

// Auto-initialize on DOM load
document.addEventListener('DOMContentLoaded', initTabs);

export default { initTabs };
