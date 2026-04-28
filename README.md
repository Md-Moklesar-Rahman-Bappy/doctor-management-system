# 🏥 Doctor Management System

A Laravel-based **Doctor–Patient Management System** designed to streamline healthcare workflows.  
This project provides full CRUD coverage for doctors, patients, prescriptions, problems, medicines, and lab tests, with reusable Blade components for pagination, AJAX search, and import/export.

---

## ✨ Features

- **Authentication & Roles**
  - Superadmin (default login: `admin@admin.com / 12345678`)
  - Doctor (self-registration with email verification)
  - Patient (added directly or during prescription creation)

- **Doctor Management**
  - Add, edit, delete doctors
  - Store multiple degrees, contact info, and addresses

- **Patient Management**
  - Unique patient ID generation
  - View patient history (prescriptions + lab reports)

- **Prescription Workflow**
  - Link doctor ↔ patient
  - Add problems, tests, medicines with dosage (Bangla/English)
  - AJAX search for problems/tests
  - View old prescriptions for reference

- **Lab Test Reports**
  - Manual entry or image upload
  - Multiple reports/images per patient
  - Linked via patient unique ID

- **Reusable Components**
  - Custom Blade pagination
  - AJAX search integration
  - Import/export modules

---

## 🗂️ Database Schema

- **Doctors**: name, degrees, email, phone, address  
- **Patients**: unique_id, name, age, sex, registration date  
- **Problems**: searchable list of medical problems  
- **Lab Tests**: department, sample type, panel, test, code, unit, result type, normal range  
- **Prescriptions**: doctor_id, patient_id, problems, tests, medicines  
- **Lab Test Reports**: patient_id, test_name, report_text, report_image  

---

## 🚀 Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/Md-Moklesar-Rahman-Bappy/doctor-management-system.git
    cd doctor-management-system
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    npm run dev
    ```

3. Configure environment:
- Copy .env.example → .env
- Update database credentials
- Set APP_KEY:
    ```bash
    php artisan key:generate
    ```

4. Run migrations:
    ```bash
    php artisan migrate
    ```

5. Seed default admin:
    ```bash
    php artisan db:seed
    ```
- Login: admin@admin.com / 12345678

## 🧭 Usage
Superadmin can add doctors directly.
- Doctors can self-register (email verification required).
- Patients can be added manually or during prescription creation.
- Prescriptions link doctors ↔ patients with problems, tests, and medicines.
- Lab test reports can be uploaded or entered manually.

## 📌 Roadmap
- ✅ Full CRUD for doctors, patients, problems, medicines, tests, prescriptions
- ✅ AJAX search integration
- ✅ Lab test report uploads
- 🔜 Role-based dashboards
- 🔜 Export patient history (PDF/Excel)
- 🔜 API endpoints for mobile integration

## 🤝 Contributing
- Pull requests are welcome. For major changes, please open an issue first to discuss what you’d like to change.