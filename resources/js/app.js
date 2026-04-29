import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
Alpine.plugin(focus);
Alpine.start();

window.Swal = Swal;

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
