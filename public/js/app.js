// Global variables for pagination
let currentPage = 1;
let totalPages = 1;
let searchQuery = '';

// Load medicines with pagination support
async function loadMedicines(page = 1) {
    const tbody = document.getElementById('medicinesTableBody');
    if (tbody) {
        tbody.innerHTML = '<tr><td colspan="9" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>';
    }
    
    try {
        const response = await axios.get('/medicines', {
            params: {
                page: page,
                per_page: 10,
                q: searchQuery
            }
        });
        
        // Handle pagination response
        if (response.data.meta) {
            currentPage = response.data.meta.current_page;
            totalPages = response.data.meta.last_page;
            renderMedicinesTable(response.data.data);
        } else if (response.data.data) {
            currentPage = response.data.current_page || 1;
            totalPages = response.data.last_page || 1;
            renderMedicinesTable(response.data.data);
        } else {
            currentPage = 1;
            totalPages = 1;
            renderMedicinesTable(response.data);
        }
        
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
    
    if (!medicines || medicines.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" class="text-center">No medicines found</td></tr>';
        return;
    }
    
    tbody.innerHTML = medicines.map(medicine => `
        <tr>
            <td>${medicine.name}</td>
            <td>${medicine.generic_name || 'N/A'}</td>
            <td>${medicine.dosage || 'N/A'}</td>
            <td>${medicine.form || 'N/A'}</td>
            <td>${medicine.strength ? medicine.strength + 'mg' : 'N/A'}</td>
            <td>₱${medicine.price ? parseFloat(medicine.price).toFixed(2) : '0.00'}</td>
            <td>${medicine.stock_quantity !== undefined ? medicine.stock_quantity : 'N/A'}</td>
            <td>
                <button class="btn btn-sm btn-warning" onclick="editMedicine('${medicine.id}')">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
            <td>
                <button class="btn btn-sm btn-danger" onclick="deleteMedicine('${medicine.id}')">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

// Render pagination controls
function renderPaginationControls() {
    const container = document.getElementById('paginationContainer');
    if (!container) return;
    
    if (totalPages <= 1) {
        container.innerHTML = '';
        return;
    }
    
    let html = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
    
    // Previous button
    html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <button class="page-link" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
             </li>`;
    
    // Page numbers - show max 5 pages
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
                    Next <i class="fas fa-chevron-right"></i>
                </button>
             </li>`;
    
    html += '</ul></nav>';
    container.innerHTML = html;
}

// Change page - FIXED: Now correctly increments/decrements page
function changePage(page) {
    // Validate page number
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    loadMedicines(currentPage);
}

// Delete medicine function
async function deleteMedicine(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const deleteBtn = event ? event.target.closest('button') : null;
            if (deleteBtn) {
                deleteBtn.disabled = true;
                deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }
            
            try {
                const response = await axios.delete(`/medicines/${id}`);
                
                if (response.data.success || response.status === 200 || response.status === 204) {
                    Swal.fire('Deleted!', 'Medicine deleted successfully.', 'success');
                    loadMedicines(currentPage);
                } else {
                    Swal.fire('Error!', response.data.message || 'Error deleting medicine', 'error');
                }
            } catch (error) {
                console.error('Delete error:', error);
                if (error.response && error.response.data && error.response.data.message) {
                    Swal.fire('Error!', error.response.data.message, 'error');
                } else {
                    Swal.fire('Error!', 'Error deleting medicine. Please try again.', 'error');
                }
            } finally {
                if (deleteBtn) {
                    deleteBtn.disabled = false;
                    deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
                }
            }
        }
    });
}

// Edit medicine function
function editMedicine(id) {
    window.location.href = `/medicines/${id}/edit`;
}

// Search functionality
async function searchMedicine(query) {
    searchQuery = query;
    currentPage = 1; // Reset to first page on search
    await loadMedicines(currentPage);
}

// Debounced search function
function debouncedSearch(query) {
    clearTimeout(window.searchTimeout);
    window.searchTimeout = setTimeout(() => {
        searchMedicine(query);
    }, 300);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadMedicines(currentPage);
    
    // Setup search
    const searchInput = document.getElementById('medicineSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            debouncedSearch(this.value);
        });
    }
});

// Helper functions
function showToast(message, type = 'info') {
    if (typeof Swal !== 'undefined') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        Toast.fire({
            icon: type,
            title: message
        });
    }
}

// Export functions
window.loadMedicines = loadMedicines;
window.changePage = changePage;
window.searchMedicine = searchMedicine;
window.deleteMedicine = deleteMedicine;
window.editMedicine = editMedicine;
window.renderMedicinesTable = renderMedicinesTable;
window.currentPage = () => currentPage;
window.totalPages = () => totalPages;