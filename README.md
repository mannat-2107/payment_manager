# 💳 PayManager SaaS — Enterprise Payroll & Employee Portal

PayManager is a robust, full-stack payroll calculation engine and employee portal built with **Laravel 11**, designed to separate administrative controls from employee-facing views. Featuring a premium **Slate & Teal Glassmorphism** design, it is optimized for high information density, sleek micro-interactions, and visual elegance.

---

## 🌟 Key Features

### 🏢 Admin Dashboard & Workspace
*   **Role-Based Access Control (RBAC):** Restrict system access safely. Separate entry points for `Super Admin`, `HR Manager`, and `Accountant` roles vs `Employee` roles.
*   **Leave Management & Automated Deductions:** Multi-step leave requests (Pending, Approved, Rejected). The payroll engine calculates overlapping weekday leaves for the billing month and applies exact per-day basic salary deductions.
*   **Salary Revision Logs:** Tracks salary change history dynamically via database observers. Logs basic pay, HRA, allowance revisions, effective dates, reasons, and the performing admin.
*   **Automated Bulk Payments:** Process batches of approved payrolls into transaction sheets. Runs a background processor with full retry capability for failed bank transfers.
*   **Payment Scheduling Engine:** Schedule recurring monthly payroll dates or trigger immediate payments via Artisan console scheduler.
*   **Employee Document Vault:** Admin-managed secure file repository for employee tax documents, IDs, or offer letters with direct download capability.

### 👤 Self-Service Employee Portal (`/my-portal`)
*   **Glassmorphism Dashboard:** An active personal command center for employees to monitor monthly net pay, download custom PDF payslips, view individual bank transfer receipt details, apply for leaves, and download personal corporate documents.

---

## 🛠️ Tech Stack

*   **Core:** PHP 8.2+ & Laravel 11 (Blade Templating, Eloquent, Observers)
*   **Styling & UI:** Vanilla CSS + Tailwind CSS (Curated custom Slate/Teal color tokens & Glassmorphism classes)
*   **Authentication & Sessioning:** Laravel Jetstream & Fortify
*   **Role & Permission Handler:** Spatie Laravel Permission
*   **Database:** SQLite / MySQL

---

## 🚀 Quick Start Guide

Follow these steps to set up PayManager locally:

### 1. Clone & Set Up Directory
```bash
git clone <your-repository-url>
cd payment-platform
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```
*(Make sure to set your DB credentials inside the `.env` file).*

### 4. Database Setup & Seeding
PayManager comes pre-loaded with comprehensive seeders including custom departments, admin accounts, and 8 active employees with 2 months of mock transaction history:
```bash
php artisan migrate --seed
```

### 5. Build Assets & Start Server
```bash
# Compile styling and tailwind components
npm run dev

# Start local server
php artisan serve
```

---

## 🔑 Login Credentials

The seeders automatically populate two primary user profiles for easy testing:

### 🏢 Administrator View
*   **Email:** `admin@payment.com`
*   **Password:** `password123`
*   **Access:** Full admin controls, workforce directories, leave approvals, payroll runs, scheduler, and reports.

### 👤 Employee Portal View
*   **Email:** `priya@company.com` (or `rahul@company.com`, `neha@company.com`)
*   **Password:** `password123`
*   **Access:** My Portal dashboard, applying for leaves, payslip downloads, personal documents.

---

## 📅 Background Tasks (Scheduler)

The scheduled automatic payment processing commands can be audited using Artisan:

```bash
# Check scheduled payment triggers
php artisan schedule:list

# Manually trigger automatic payments immediately
php artisan payments:run
```

---

## 📁 Core Directory Layout
*   `app/Http/Controllers/` — Core route orchestration (Leave Management, Revisions, Employees, Payroll, Documents).
*   `app/Services/PayrollService.php` — Core financial engine containing the custom leave deduction math.
*   `app/Observers/SalaryStructureObserver.php` — Database observer logging changes to historical revisions.
*   `resources/views/` — Blade layout files applying the premium **Slate & Teal** dashboard theme.
