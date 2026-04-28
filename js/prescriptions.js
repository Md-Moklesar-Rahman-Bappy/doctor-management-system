// Prescription Form Handler
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('prescriptionForm');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            // Parse medicines array
            const medicines = [];
            const medicineCount = Math.max(
                ...Array.from(document.querySelectorAll('[name="medicines\[\]\[id\]"], [name="medicines\[id\]"]')).map(el => el.value),
                0
            );
            
            try {
                const response = await axios.post('http://localhost/doctor/public/api/prescriptions', data);
                
                new Swal({
                    title: 'Success!',
                    text: 'Prescription created successfully',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('prescriptionModal'));
                modal.hide();
                form.reset();
                
                if (typeof app !== 'undefined') {
                    app.loadPrescriptions();
                }
                
            } catch (error) {
                console.error('Error:', error);
                if (error.response?.data?.errors) {
                    let errorMessage = 'Validation errors:\n';
                    Object.values(error.response.data.errors).forEach(errors => {
                        errors.forEach(error => {
                            errorMessage += `- ${error}\n`;
                        });
                    });
                    Swal.fire('Error', errorMessage, 'error');
                } else {
                    Swal.fire('Error', 'Failed to create prescription', 'error');
                }
            }
        });
    }
});

$(document).ready(function() {
    $('#prescriptionModal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
    });
});