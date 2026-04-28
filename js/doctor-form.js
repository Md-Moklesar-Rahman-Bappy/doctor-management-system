// Doctor Form Handler
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('doctorForm');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            try {
                const response = await axios.post('http://localhost/doctor/public/api/doctors', data);
                
                new Swal({
                    title: 'Success!',
                    text: 'Doctor created successfully',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('doctorModal'));
                modal.hide();
                form.reset();
                
                if (typeof app !== 'undefined') {
                    app.loadDoctors();
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
                    Swal.fire('Error', 'Failed to create doctor', 'error');
                }
            }
        });
    }
});

$(document).ready(function() {
    $('#doctorModal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
    });
});