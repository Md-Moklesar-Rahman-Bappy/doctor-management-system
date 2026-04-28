// Medicine Management with Pagination Support
let currentPage = 1;
let totalPages = 1;
let searchQuery = '';

// Load medicines with pagination support
async function loadMedicines(page = 1) {
    try {
        const response = await axios.get('/api/medicines', {
            params: {
                page: page,
                limit: 10,
                q: searchQuery
            }
        });
        
        currentPage = response.data.current_page;
        totalPages = response.data.last_page;
        
        renderMedicinesTable(response.data.data);
        renderPaginationControls();
        
    } catch (error) {
        console.error('Error loading medicines:', error);
        showToast('Error loading medicines', 'error');
    }
}

// Render medicines table
function renderMedicinesTable(medicines) {
    const tbody = document.getElementById('medicinesTableBody');
    if (!tbody) return;
    
    if (medicines.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">No medicines found</td></tr>';
        return;
    }
    
    tbody.innerHTML = medicines.map(medicine => `
        <tr>
            <td>${medicine.name}</td>
            <td>${medicine.generic_name}</td>
            <td>${medicine.name}</td>
            <td>${medicine.generic_name}</td>
            <td>${medicine.dosage || 'N/A'}</td>
            <td>${medicine.form || 'N/A'}</td>
            <td>₱${medicine.price.toFixed(2)}</td>
            <td>${medicine.stock_quantity}</td>
            <td>
                <button class="btn btn-sm btn-warning" onclick="editMedicine('${medicine.id}')">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

// Render pagination controls
function renderPaginationControls() {
    const container = document.getElementById('paginationContainer');
    if (!container) return;
    
    let html = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
    
    // Previous button
    html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <button class="page-link" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
                    <i class="fas fa-chevron-left"></i>
                </button>
             </li>`;
    
    // Page numbers (show max 5 pages around current)
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + 4);
    
    if (endPage - startPage < 4) {
        startPage = Math.max(1, endPage - 4);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                    <button class="page-link" onclick="changePage(${i})">${i}</button>
                 </li>`;
    }
    
    // Next button
    html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <button class="page-link" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
                    <i class="fas fa-chevron-right"></i>
                </button>
             </li>`;
    
    html += '</ul></nav>';
    container.innerHTML = html;
}

// Change page (fix for the > button issue)
function changePage(page) {
    // Validate page number
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    loadMedicines(currentPage);
    
    // Update active page in pagination
    renderPaginationControls();
}

// Search functionality
async function searchMedicine(query) {
    searchQuery = query;
    currentPage = 1; // Reset to first page on search
    await loadMedicines(currentPage);
}

// Autocomplete for medicine search
async function autocompleteMedicine(query) {
    try {
        const response = await axios.get('/api/medicines/autocomplete', {
            params: { term: query }
        });
        return response.data;
    } catch (error) {
        console.error('Autocomplete error:', error);
        return [];
    }
}

// Initialize medicines on page load
document.addEventListener('DOMContentLoaded', function() {
    loadMedicines(currentPage);
    
    // Setup search with debounce
    const searchInput = document.getElementById('medicineSearch');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchMedicine(this.value);
            }, 300);
        });
    }
    
    // Setup pagination container
    const paginationContainer = document.getElementById('paginationContainer');
    if (!paginationContainer) {
        console.error('Pagination container not found');
    }
});

// Helper function to show toast notifications
function showToast(message, type = 'info') {
    // Implement toast notification if needed
    console.log(`${type}: ${message}`);
}

// Export for use in other scripts
window.medicinePagination = {
    loadMedicines,
    changePage,
    searchMedicine,
    currentPage: () => currentPage,
    totalPages: () => totalPages
};