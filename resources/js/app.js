// Alpine.js is loaded via CDN
// SweetAlert2 is loaded via CDN

// Global toast notification function
window.showToast = (message, type = 'success') => {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    Toast.fire({ icon: type, title: message });
};

// Confirm delete dialog
window.confirmDelete = (url, name = 'item') => {
    Swal.fire({
        title: 'Are you sure?',
        text: `Delete ${name}? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.innerHTML = `
                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
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
        document.getElementById(targetId).innerHTML = '';
        return;
    }

    fetch(`${url}?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            if (callback) {
                callback(data);
            }
        })
        .catch(error => console.error('Search error:', error));
};
