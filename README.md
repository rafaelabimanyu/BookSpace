# BookSpace 🌸

Welcome to **BookSpace**, an elegant, modern, and highly professional library management system designed to make library operations delightful. BookSpace features a charming soft-pink aesthetic combined with charming, cute, yet highly readable typography, structured around role-based access controls and dynamic English/Indonesian localization.

---

## 📖 Table of Contents
1. [Project Overview](#-project-overview)
2. [Role-Based Feature Matrix](#-role-based-feature-matrix)
3. [Local Installation Guide](#-local-installation-guide)
4. [Testing Demo Accounts](#-testing-demo-accounts)
5. [Developer Documentation Suite](#-developer-documentation-suite)

---

## 🌸 Project Overview

BookSpace replaces traditional, dry administrative spreadsheets with a modern visual reader portal and a transaction-safe stock control center. Built using **Laravel 11**, **Tailwind CSS**, and **Blade**, BookSpace is organized around custom styled tokens, dynamic multi-language sets, and robust database concurrency locks to protect inventory quantities during concurrent borrowings.

---

## 👑 Role-Based Feature Matrix

BookSpace serves three primary user cohorts, each accessing dedicated, scoped workspaces:

| Role | Target Workspace | Core Operations & Features |
| :--- | :--- | :--- |
| **Peminjam (Borrower)** | [dashboard](file:///c:/laragon/www/BookSpace/resources/views/dashboard.blade.php) | • Custom asymmetrical reader dashboard greeting.<br>• Visual card catalog with instant search & category dropdown filters.<br>• Micro-animated recommendations carousel.<br>• Real-time deadline indicators with pulsing warnings.<br>• Scoped personal transaction history table. |
| **Petugas (Staff)** | [dashboard](file:///c:/laragon/www/BookSpace/resources/views/dashboard.blade.php) | • General library stock counter stats card.<br>• Complete Books CRUD with 2MB validation and dynamic cover uploading.<br>• Complete Categories CRUD with double-entry validation.<br>• Library Circulation recorder (User selector + Book selector + Auto-calculated dates).<br>• Return transaction triggers with active inventory stock incrementing. |
| **Admin** | [reports](file:///c:/laragon/www/BookSpace/resources/views/admin/reports.blade.php) | • All **Petugas** features.<br>• Advanced **Library Reporting Dashboard** featuring monthly, yearly, and category filters.<br>• Print-optimized layout rendering clean physical papers via `@media print`. |

---

## 🚀 Local Installation Guide

BookSpace is optimized to run locally on development platforms like **Laragon** or **XAMPP**.

### Prerequisites
- **PHP 8.2** or higher
- **Composer**
- **Node.js & NPM**
- **MySQL / MariaDB**

### Installation Steps

1. **Clone the Repository** and enter the folder:
   ```bash
   cd c:\laragon\www\BookSpace
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment File**:
   Copy `.env.example` to `.env` and set up your local database credentials:
   ```bash
   copy .env.example .env
   ```
   Modify database configuration details in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bookspace
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Link Public Storage**:
   BookSpace stores cover image uploads securely inside `storage/app/public/covers`. Connect it to the public directory using:
   ```bash
   php artisan storage:link
   ```

6. **Reset Database & Seed Thematic Dummy Data**:
   Prepopulate BookSpace with realistic books, categories, staff accounts, and borrowing history:
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Compile CSS and Bundled Assets**:
   Compile the theme stylesheets and AlpineJS bundles:
   ```bash
   npm run build
   ```

8. **Start Local Development Server**:
   ```bash
   php artisan serve
   ```
   Open `http://127.0.0.1:8000` in your web browser.

---

## 🔑 Testing Demo Accounts

The database seeders configure three default accounts representing distinct roles with password `'password'`:

| Email Username | Role Profile | Key Access Areas |
| :--- | :--- | :--- |
| `admin@bookspace.test` | **Admin** | Catalog, Categories, Books, Borrowings, Printable Reports |
| `petugas@bookspace.test` | **Petugas (Staff)** | Catalog, Categories, Books, Borrowings |
| `peminjam@bookspace.test` | **Peminjam (Borrower)** | Custom Animated Dashboard, Book Catalog, Personal History |

---

## 📚 Developer Documentation Suite

For engineering teams looking to modify, extend, or maintain BookSpace, please refer to the following specialized guides inside the root [docs/](file:///c:/laragon/www/BookSpace/docs) directory:

- 📊 **[docs/ARCHITECTURE.md](file:///c:/laragon/www/BookSpace/docs/ARCHITECTURE.md)**: Details the Enum RBAC model, the dynamic variadic `RoleMiddleware`, database Eloquent relationships, and transaction-safe stock inventory locking systems.
- 🎨 **[docs/FRONTEND_STYLE_GUIDE.md](file:///c:/laragon/www/BookSpace/docs/FRONTEND_STYLE_GUIDE.md)**: Catalogues the theme CSS tokens, typography pairings, standard utility classes (cards, fields, custom buttons), and borrower-dashboard animations.
- 🌐 **[docs/LOCALIZATION_GUIDE.md](file:///c:/laragon/www/BookSpace/docs/LOCALIZATION_GUIDE.md)**: Explains the SetLocale session architecture, JSON translation dictionaries, and blade syntax standard guidelines.
