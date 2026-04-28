// Medical Management System - Main Application
const API_BASE = 'http://localhost/doctor/public/api';

// Global state
const app = {
    currentUser: null,
    patients: [],
    doctors: [],
    medicines: [],
    problems: [],
    tests: [],
    prescriptions: [],
    
    async init() {
        await this.loadDashboard();
        await this.loadPatients();
        await this.loadDoctors();
        await this.loadMedicines();
        await this.loadPrescriptions();
        await this.loadProblems();
        await this.loadTests();
        this.setupEventListeners();
    },
    
    async loadDashboard() {
        try {
            // In a real app, this would fetch actual data
            document.getElementById('totalPatients').textContent = this.patients.length;
            document.getElementById('totalDoctors').textContent = this.doctors.length;
            document.getElementById('totalPrescriptions').textContent = this.prescriptions.length;
            document.getElementById('totalMedicines').textContent = this.medicines.length;
        } catch (error) {
            console.error('Error loading dashboard:', error);
        }
    },
    
    async loadPatients() {
        try {
            const response = await axios.get(`${API_BASE}/patients`);
            this.patients = response.data.data || [];
            this.renderPatientsTable();
        } catch (error) {
            console.error('Error loading patients:', error);
        }
    },
    
    async loadDoctors() {
        try {
            const response = await axios.get(`${API_BASE}/doctors`);
            this.doctors = response.data.data || [];
        } catch (error) {
            console.error('Error loading doctors:', error);
        }
    },
    
    async loadMedicines() {
        try {
            const response = await axios.get(`${API_BASE}/medicines`);
            this.medicines = response.data.data || [];
            this.renderMedicinesTable();
        } catch (error) {
            console.error('Error loading medicines:', error);
        }
    },
    
    async loadPrescriptions() {
        try {
            const response = await axios.get(`${API_BASE}/prescriptions`);
            this.prescriptions = response.data.data || [];
            this.renderPrescriptionsTable();
        } catch (error) {
            console.error('Error loading prescriptions:', error);
        }
    },
    
    async loadProblems() {
        try {
            const response = await axios.get(`${API_BASE}/problems`);
            this.problems = response.data.data || [];
            this.renderProblemsTable();
        } catch (error) {
            console.error('Error loading problems:', error);
        }
    },
    
    async loadTests() {
        try {
            const response = await axios.get(`${API_BASE}/tests`);
            this.tests = response.data.data || [];
            this.renderTestsTable();
        } catch (error) {
            console.error('Error loading tests:', error);
        }
    },
    
    renderPatientsTable() {
        const tbody = document.getElementById('patientsTableBody');
        if (!tbody) return;
        
        if (this.patients.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No patients found</td></tr>';
            return;
        }
        
        tbody.innerHTML = this.patients.map(patient => `
            <tr>
                <td>${patient.unique_no}</td>
                <td>${patient.user?.name || 'N/A'}</td>
                <td>${patient.gender}</td>
                <td>${this.calculateAge(patient.date_of_birth)}</td>
                <td>${patient.blood_group || 'N/A'}</td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="app.viewPatient('${patient.id}')">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    },
    
    calculateAge(dateOfBirth) {
        const birthDate = new Date(dateOfBirth);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    },
    
    renderMedicinesTable() {
        const tbody = document.getElementById('medicinesTableBody');
        if (!tbody) return;
        
        if (this.medicines.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center">No medicines found</td></tr>';
            return;
        }
        
        tbody.innerHTML = this.medicines.map(medicine => `
            <tr>
                <td>${medicine.name}</td>
                <td>${medicine.generic_name}</td>
                <td>${medicine.company || 'N/A'}</td>
                <td>${medicine.strength || 'N/A'}</td>
                <td>${medicine.form}</td>
                <td>₱${medicine.price.toFixed(2)}</td>
                <td>${medicine.stock_quantity}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="app.editMedicine('${medicine.id}')">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    },
    
    renderPrescriptionsTable() {
        const tbody = document.getElementById('prescriptionsTableBody');
        if (!tbody) return;
        
        if (this.prescriptions.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No prescriptions found</td></tr>';
            return;
        }
        
        tbody.innerHTML = this.prescriptions.map(prescription => `
            <tr>
                <td>#${prescription.id}</td>
                <td>${prescription.patient?.unique_no || 'N/A'}</td>
                <td>${prescription.doctor?.user?.name || 'N/A'}</td>
                <td>${new Date(prescription.prescription_date).toLocaleDateString()}</td>
                <td>${new Date(prescription.valid_until).toLocaleDateString()}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="app.viewPrescription('${prescription.id}')">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    },
    
    renderProblemsTable() {
        const tbody = document.getElementById('problemsTableBody');
        if (!tbody) return;
        
        if (this.problems.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center">No problems found</td></tr>';
            return;
        }
        
        tbody.innerHTML = this.problems.map(problem => `
            <tr>
                <td>${problem.name}</td>
                <td>${problem.description || 'N/A'}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="app.editProblem('${problem.id}')">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    },
    
    renderTestsTable() {
        const tbody = document.getElementById('testsTableBody');
        if (!tbody) return;
        
        if (this.tests.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No tests found</td></tr>';
            return;
        }
        
        tbody.innerHTML = this.tests.map(test => `
            <tr>
                <td>${test.name}</td>
                <td>${test.category}</td>
                <td>₱${test.price.toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="app.editTest('${test.id}')">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    },
    
    setupEventListeners() {
        // Medicine search
        const medicineSearch = document.getElementById('medicineSearch');
        if (medicineSearch) {
            medicineSearch.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const filtered = this.medicines.filter(m => 
                    m.name.toLowerCase().includes(searchTerm) ||
                    m.generic_name.toLowerCase().includes(searchTerm)
                );
                this.renderMedicinesTable(filtered);
            });
        }
        
        // Patient search
        const patientSearch = document.getElementById('patientSearch');
        if (patientSearch) {
            patientSearch.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const filtered = this.patients.filter(p => 
                    p.unique_no.toLowerCase().includes(searchTerm) ||
                    (p.user?.name || '').toLowerCase().includes(searchTerm)
                );
                this.renderPatientsTable(filtered);
            });
        }
    }
};

// Initialize app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    app.init();
});

// Export for use in other scripts
window.app = app;