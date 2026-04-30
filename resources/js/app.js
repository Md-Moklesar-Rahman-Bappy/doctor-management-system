// Bootstrap 5 + Font Awesome + SweetAlert2 + AOS initialization

// Import Bootstrap JS
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Import SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;

// Import AOS (Animate On Scroll)
import AOS from 'aos';
import 'aos/dist/aos.css';

// Import components (Bootstrap 5 compatible)
import { initFormElements } from './components/form-elements.js';
import { showToast } from './components/toast.js';
import { initDropdowns } from './components/dropdowns.js';
import { initDataTables } from './components/data-tables.js';
import { initButtonSpinners } from './components/spinners.js';
import { initTabs } from './components/tabs.js';

// Initialize AOS
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 600,
        once: true,
        offset: 50
    });

    // Initialize all components
    initFormElements();
    initDropdowns();
    initDataTables();
    initButtonSpinners();
    initTabs();

    console.log('Bootstrap components loaded successfully');
});

// Global SweetAlert2 toast notification function
window.showToast = (message, type = 'success') => {
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

    const icons = {
        success: 'success',
        error: 'error',
        warning: 'warning',
        info: 'info'
    };

    Toast.fire({
        icon: icons[type] || 'info',
        title: message
    });
};

// Global SweetAlert2 confirm delete dialog
window.confirmDelete = (url, name = 'item') => {
    Swal.fire({
        title: 'Are you sure?',
        text: `Delete ${name}? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
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
    });
};

// AJAX search function
window.ajaxSearch = (url, query, targetId, callback) => {
    if (query.length < 2) {
        const target = document.getElementById(targetId);
        if (target) target.innerHTML = '';
        return;
    }

    fetch(`${url}?=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            if (callback) callback(data);
        })
        .catch(error => console.error('Search error:', error));
};

console.log('Bootstrap 5 components loaded successfully');
