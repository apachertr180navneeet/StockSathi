# Stocksathi Inventory Management System - Project Documentation

## Project Overview
Stocksathi is a comprehensive, enterprise-grade Inventory Management System (ERP) built with Laravel. It is designed to handle multi-warehouse inventory, procurement, sales, financial accounting, and human resource management in a unified, high-performance environment.

---

## Tech Stack
- **Framework**: Laravel 11.x
- **Database**: MySQL
- **Frontend**: Bootstrap 5, JQuery, AJAX, Feather Icons, Remix Icons.
- **Authentication**: Laravel Fortify/Breeze (Customized)
- **Permissions**: Spatie Laravel-Permission (Syncing 105+ permissions)
- **Notifications**: Toastr.js & SweetAlert2

---

## Core Modules & Features

### 1. Inventory & Logistics
- **Brand & Category**: Hierarchical categorization of products.
- **Warehouse Management**: Support for multiple storage locations.
- **Product Management**: Detailed SKU tracking, batch/lot numbers, and bin/rack location.
- **Stock Adjustment**: Manual adjustment of stock levels with audit trails.
- **Transfers**: Transferring stock between warehouses.

### 2. Purchase Manage
- **Purchase Requisitions**: Internal requests for procurement.
- **Purchase Orders**: Formal orders sent to suppliers.
- **Purchase Entry**: Recording received stock and updating inventory automatically.
- **Vendor Payments**: Tracking payables and payment history.

### 3. Sale Manage
- **Quotations**: Creating and sending price quotes to customers.
- **Sales Orders**: Recording orders before fulfillment.
* **POS (Point of Sale)**: Fast, retail-ready interface for quick sales.
- **Sale Entry**: Finalizing sales and generating professional invoices.
- **Delivery Tracking**: Managing shipments and delivery status.

### 4. HR Management (Recently Completed)
- **Department & Designation**: Organizational structure setup.
- **Employee Management**: Profile tracking, joining details, and base salary records.
- **Attendance**: Batch marking system for daily check-ins/check-outs.
- **Payroll**: Automated monthly salary slip generation with allowances and deductions.

### 5. Accounting & Reports
- **Chart of Accounts**: Categorized financial tracking.
- **Expense Tracking**: Managing operational costs.
- **Financial Reports**: Profit & Loss statements, Ledger reports, and Stock reports.

---

## Security & Access Control
- **Role-Based Access Control (RBAC)**: Granular permissions for every action.
- **Admin Role**: The 'Admin' role is configured as a Super Admin with a dynamic bypass in `AppServiceProvider`, granting access to all features regardless of individual permission assignments.
- **Permission Groups**: Permissions are logically grouped (e.g., `hr`, `sale`, `inventory`) for easy management in the Role UI.

---

## Installation & Setup

1. **Clone & Install**:
   ```bash
   composer install
   npm install
   ```

2. **Environment Configuration**:
   - Copy `.env.example` to `.env`.
   - Set database credentials.
   - Run `php artisan key:generate`.

3. **Database Migration & Seeding**:
   ```bash
   php artisan migrate
   php artisan db:seed --class=PermissionMasterSeeder
   ```

4. **Default Credentials**:
   - **Email**: `admin@stocksathi.com`
   - **Password**: `12345678`

---

## Development Guidelines for the Team
- **Routing**: Always use named routes. Group routes by module in `web.php`.
- **Controllers**: Keep controllers thin. Use AJAX for table loading and CRUD operations where possible for a premium user experience.
- **Views**: Extend `admin.admin_master`. Use the `@section('admin')` for content.
- **Styling**: Stick to the unified Bootstrap 5 theme. Avoid ad-hoc CSS; use the design tokens defined in the master layout.
- **Pagination**: Use `{!! $model->links('pagination::bootstrap-5') !!}` for all data tables.

---

## Project Status
**Completion**: ~90%
**Current Focus**: Final verification of accounting reports and fine-tuning UI animations.

---
*Document Version 1.0 - Generated on April 25, 2026*
