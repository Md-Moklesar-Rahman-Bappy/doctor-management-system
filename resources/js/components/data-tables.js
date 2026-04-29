/**
 * Data Tables - TailAdmin Style
 * Enhanced table functionality with sorting, filtering, and export
 */
export function initDataTables() {
    const tables = document.querySelectorAll('.data-table');

    tables.forEach(table => {
        initTableSorting(table);
        initTableFiltering(table);
        initRowSelection(table);
    });
}

function initTableSorting(table) {
    const headers = table.querySelectorAll('thead th[sortable]');

    headers.forEach((header, index) => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', () => {
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
        return direction === 'asc'
            ? aText.localeCompare(bText)
            : bText.localeCompare(aText);
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
    const searchInput = table.closest('.card')?.querySelector('input[type="search"], input[name="search"]');
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

function initRowSelection(table) {
    const selectAllCheckbox = table.querySelector('thead .row-select-all');
    if (!selectAllCheckbox) return;

    selectAllCheckbox.addEventListener('change', () => {
        const checkboxes = table.querySelectorAll('tbody .row-select');
        checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
        updateBulkActions(table);
    });

    const rowCheckboxes = table.querySelectorAll('tbody .row-select');
    rowCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => updateBulkActions(table));
    });
}

function updateBulkActions(table) {
    const selectedCount = table.querySelectorAll('tbody .row-select:checked').length;
    const bulkActions = table.closest('.card')?.querySelector('.bulk-actions');

    if (bulkActions) {
        bulkActions.style.display = selectedCount > 0 ? 'flex' : 'none';
        const countSpan = bulkActions.querySelector('.selected-count');
        if (countSpan) countSpan.textContent = selectedCount;
    }
}

export function exportTable(tableId, format = 'csv') {
    const table = document.getElementById(tableId);
    if (!table) return;

    const rows = table.querySelectorAll('tr');
    const data = Array.from(rows).map(row =>
        Array.from(row.cells).map(cell => cell.textContent.trim())
    );

    if (format === 'csv') {
        const csv = data.map(row => row.join(',')).join('\n');
        downloadFile(csv, 'table-export.csv', 'text/csv');
    } else if (format === 'json') {
        const json = JSON.stringify(data, null, 2);
        downloadFile(json, 'table-export.json', 'application/json');
    }
}

function downloadFile(content, filename, type) {
    const blob = new Blob([content], { type });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    URL.revokeObjectURL(url);
}

// Auto-initialize on DOM load
document.addEventListener('DOMContentLoaded', initDataTables);

export default { initDataTables, exportTable };
