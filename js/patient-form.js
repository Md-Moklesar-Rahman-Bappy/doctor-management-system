// Patient Form Handler
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('patientForm');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            try {
                const response = await axios.post('http://localhost/doctor/public/api/patients', data);
                
                // Show success message
                new Swal({
                    title: 'Success!',
                    text: 'Patient created successfully',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Close modal and reset form
                const modal = bootstrap.Modal.getInstance(document.getElementById('patientModal'));
                modal.hide();
                form.reset();
                
                // Reload patients table
                if (typeof app !== 'undefined') {
                    app.loadPatients();
                }
                
            } catch (error) {
                console.error('Error:', error);
                if (error.response?.data?.errors) {
                    // Show validation errors
                    let errorMessage = 'Validation errors:\n';
                    Object.values(error.response.data.errors).forEach(errors => {
                        errors.forEach(error => {
                            errorMessage += `- ${error}\n`;
                        });
                    });
                    Swal.fire('Error', errorMessage, 'error');
                } else {
                    Swal.fire('Error', 'Failed to create patient', 'error');
                }
            }
        });
    }
});

// Close modal when clicking outside
$(document).ready(function() {
    $('#patientModal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
    });
});