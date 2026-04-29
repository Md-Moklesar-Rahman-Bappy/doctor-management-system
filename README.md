# 🏥 Doctor Management System

A modern, elegant Laravel-based **Doctor–Patient Management System** designed to streamline healthcare workflows.

This project provides full CRUD coverage for doctors, patients, prescriptions, problems, medicines, and lab tests, with reusable Blade components, modern UI design, and comprehensive testing.

---

## ✨ Features

### Core Features
- **Authentication & Role-Based Access**
  - Superadmin with full system access
  - Doctor self-registration with email verification
  - Patient management (added directly or during prescription creation)

- **Doctor Management**
  - Add, edit, delete doctors
  - Store multiple degrees, contact info, and addresses
  - Search functionality with autocomplete

- **Patient Management**
  - Automatic unique patient ID generation
  - Complete patient history (prescriptions + lab reports)
  - Advanced search and filtering

- **Prescription Workflow**
  - Link doctor ↔ patient
  - Add problems, tests, medicines with dosage (Bangla/English)
  - AJAX search for problems/tests
  - View prescription history

- **Lab Test Reports**
  - Manual entry or image upload
  - Multiple reports/images per patient
  - Linked via patient unique ID

### Technical Features
- **Modern Design System** with Tailwind CSS
- **Reusable Blade Components** (inputs, buttons, cards, tables, modals, alerts)
- **AJAX Search** with debouncing and autocomplete
- **Responsive Design** for mobile and desktop
- **SweetAlert2** for elegant notifications
- **Alpine.js** for interactive components

---

## 🗂️ Database Schema

- **Doctors**: name, degrees (JSON), email, phone, address, user_id
- **Patients**: unique_id, patient_name, age, sex, date, user_id
- **Problems**: searchable list of medical problems
- **Lab Tests**: department, sample type, panel, test, code, unit, result type, normal range
- **Prescriptions**: doctor_id, patient_id, problems (JSON), tests (JSON), medicines (JSON)
- **Lab Test Reports**: patient_id, test_name, report_text, report_image

---

## 🚀 Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/yourusername/doctor-management-system.git
    cd doctor-management-system
    ```

2. Install PHP dependencies:
    ```bash
    composer install
    ```

3. Install JavaScript dependencies:
    ```bash
    npm install
    ```

4. Configure environment:
    ```bash
    cp .env.example .env
    # Edit .env with your database credentials
    php artisan key:generate
    ```

5. Run migrations and seeders:
    ```bash
    php artisan migrate --seed
    ```

6. Build assets:
    ```bash
    npm run build
    # or for development
    npm run dev
    ```

7. Start the server:
    ```bash
    php artisan serve
    ```

### Default Login Credentials
After seeding, you can log in with:
- **Email**: Check your `.env` file or the seeder for admin credentials
- **Note**: For security, default credentials are not hardcoded. Check `database/seeders/DatabaseSeeder.php`

---

## 🧭 Usage

1. **Superadmin** can manage all doctors, patients, and system settings
2. **Doctors** can self-register (email verification required)
3. **Patients** can be added manually or during prescription creation
4. **Prescriptions** link doctors ↔ patients with medical details
5. **Lab Reports** can be uploaded or entered manually

---

## 📌 Roadmap

- ✅ Full CRUD for all entities
- ✅ AJAX search integration
- ✅ Modern UI with Tailwind CSS
- ✅ Reusable Blade components
- 🔜 Role-based dashboards
- 🔜 Export patient history (PDF/Excel)
- 🔜 API endpoints for mobile integration
- 🔜 Static analysis with Larastan/PHPStan
- 🔜 Comprehensive test coverage

---

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

Generate coverage report:
```bash
php artisan test --coverage
```

---

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

Please ensure your code passes:
- PHPUnit tests
- Laravel Pint (code style)
- Static analysis (if configured)

---

## 📸 Screenshots

*Screenshots coming soon - modern, clean, professional UI*

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
