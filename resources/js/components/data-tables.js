/**
 * Bootstrap 5 Data Tables Enhancement
 * Adds sorting, filtering, and export functionality to tables
 */

export function initDataTables() {
    const tables = document.querySelectorAll('.table[data-sortable], .data-table');

    tables.forEach(table => {
        initTableSorting(table);
        initTableFiltering(table);
    });
}

function initTableSorting(table) {
    const headers = table.querySelectorAll('thead th[sortable], thead th a');

    headers.forEach((header, index) => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', (e) => {
            e.preventDefault();
            const direction = header.dataset.sortDirection === 'asc' ? 'desc' : 'asc';
            header.dataset.sortDirection = direction;

            sortTable(table, index, direction);
            updateSortIndicators(headers, index, direction);
        });
    });
}

function sortTable(table, columnIndex, direction) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    rows.sort((a, b) => {
        const aText = a.cells[columnIndex]?.textContent.trim() || '';
        const bText = b.cells[columnIndex]?.textContent.trim() || '';

        // Try numeric sort
        const aNum = parseFloat(aText);
        const bNum = parseFloat(bText);

        if (!isNaN(aNum) && !isNaN(bNum)) {
            return direction === 'asc' ? aNum - bNum : bNum - aNum;
        }

        // String sort
        return direction === 'asc' ?
            aText.localeCompare(bText) :
            bText.localeCompare(aText);
    });

    rows.forEach(row => tbody.appendChild(row));
}

function updateSortIndicators(headers, activeIndex, direction) {
    headers.forEach((header, index) => {
        const indicator = header.querySelector('.sort-indicator');
        if (index === activeIndex && indicator) {
            indicator.innerHTML = direction === 'asc' ? '↑' : '↓';
        } else if (indicator) {
            indicator.innerHTML = '↕';
        }
    });
}

function initTableFiltering(table) {
    const card = table.closest('.card');
    if (!card) return;

    const searchInput = card.querySelector('input[type="search"], input[name="search"]');
    if (!searchInput) return;

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });
}

// Auto-initialize on DOM load
document.addEventListener('DOMContentLoaded', initDataTables);

export { initDataTables, exportTable as default };
