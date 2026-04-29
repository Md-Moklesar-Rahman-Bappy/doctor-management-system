// TailAdmin Style JS Components

// Import components
import './components/tabs.js';
import './components/dropdowns.js';
import './components/toast.js';
import './components/spinners.js';
import './components/form-elements.js';
import './components/data-tables.js';

// Global toast notification function (from previous implementation)
window.showToast = (message, type = 'success') => {
    if (window.showToastFromModule) {
        window.showToastFromModule(message, type);
    }
};

// Confirm delete dialog (from previous implementation)
window.confirmDelete = (url, name = 'item') => {
    if (window.confirmDeleteFromModule) {
        window.confirmDeleteFromModule(url, name);
    } else {
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
    }
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

console.log('TailAdmin components loaded successfully');
