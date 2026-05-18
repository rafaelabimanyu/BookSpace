# BookSpace 🌸

Welcome to **BookSpace**, a premium, high-end, and visually stunning library management system. BookSpace features a meticulously crafted, custom soft-pink brand identity and elegant typography. Designed to replace dry administrative spreadsheets, BookSpace combines charming aesthetic warmth with rigorous engineering standards: dynamic English/Indonesian localization, atomic transaction integrity, and robust role-based access security.

---

## 📖 Table of Contents
1. [Core Features & Overview](#-core-features--overview)
2. [Premium Tech Stack](#-premium-tech-stack)
3. [Local Installation Manual](#-local-installation-manual)
4. [Test Demo Accounts Ledger](#-test-demo-accounts-ledger)
5. [Developer Documentation Suite](#-developer-documentation-suite)

---

## ✨ Core Features & Overview

BookSpace provides a tailored workspace for each user role, providing specific capabilities:

*   **Peminjam (Borrower)**: Visual catalogs with search & category filters, interactive timelines showing checkouts, an outstanding denda (fine) ledger, and a customizable member profile where they can upload photos and print a gorgeous, print-isolated digital E-Card.
*   **Petugas (Staff)**: Comprehensive books and category curators, library circulation recorders with automated date calculations, return handlers with active inventory stock incrementing, and outstanding penalty settlement portals.
*   **Admin**: System configuration console to dynamically update loan windows, checkout constraints, and fine accrual values, coupled with deep library reporting analytics (monthly, yearly, and category filters) that render clean physical papers via a custom print-media stylesheet.

---

## 🛠️ Premium Tech Stack

BookSpace is engineered using lightweight yet high-performance modern web technologies:

*   **Framework**: [Laravel 11](https://laravel.com) (PHP 8.3+) utilizing thin controllers, dedicated validation form requests, and an elegant session-based locale switching middleware layer.
*   **Database**: [SQLite](https://sqlite.org) (`database.sqlite`) acting as a fast, local database engine equipped with transaction locks (`lockForUpdate()`) to protect stock quantities.
*   **Frontend**: [Tailwind CSS](https://tailwindcss.com) compiled via **Vite** to run high-fidelity design tokens, custom font integrations, widescreen desktop grids, and frosted glassmorphic card overlays.
*   **Interactivity**: [Alpine.js](https://alpinejs.dev) delivering instant client-side states, reactive modal transitions, slide-over panels, and an interactive late fee simulator widget.

---

## 🚀 Local Installation Manual

BookSpace is optimized to run seamlessly in local development suites like **Laragon** or **XAMPP**. Follow these steps to set up and launch the application:

### 📋 Prerequisites
- **PHP 8.3** or higher (with SQLite extension enabled)
- **Composer** (PHP dependency manager)
- **Node.js (v18+) & NPM**

### 💻 Command Line Setup

1.  **Clone or Move into the Project Directory**:
    ```bash
    cd c:\laragon\www\BookSpace
    ```

2.  **Install PHP and JavaScript Dependencies**:
    ```bash
    composer install
    npm install
    ```

3.  **Configure the Environment Configuration File**:
    Copy the sample environment file to create your active configurations:
    ```bash
    copy .env.example .env
    ```
    BookSpace is preconfigured to use SQLite. Ensure your database configuration block inside `.env` matches the following simplified SQLite setup:
    ```env
    DB_CONNECTION=sqlite
    # DB_HOST, DB_PORT, DB_DATABASE, etc. can remain commented out
    ```

4.  **Generate a Unique Application Security Key**:
    ```bash
    php artisan key:generate
    ```

5.  **Initialize the Local SQLite Database & Prepopulate Seed Data**:
    Run migrations to build all schemas and run seeders to inject thematic book categories, stock records, dummy reviews, system defaults, and user accounts:
    ```bash
    php artisan migrate --seed
    ```
    *(Note: If prompted that the SQLite database does not exist, select **Yes** to allow Laravel to create the `database.sqlite` file automatically.)*

6.  **Create the Storage Symlink**:
    Link Laravel's private storage folder to the public directory so uploaded covers and profiles are accessible:
    ```bash
    php artisan storage:link
    ```

7.  **Compile the Visual Stylesheets and Script Bundles**:
    ```bash
    npm run build
    ```

8.  **Launch the Local Development Server**:
    ```bash
    php artisan serve
    ```
    You can now access your high-fidelity installation at `http://127.0.0.1:8000`!

---

## 🔑 Test Demo Accounts Ledger

Use these default seeded profiles to verify the scoped workspaces, features, and dashboards:

| Email Username | Role Profile | Accessible Capabilities | Default Password |
| :--- | :--- | :--- | :--- |
| `admin@bookspace.test` | **Admin** | Full Settings Control, Printable Statistics & Reports, Circulation, Books/Categories CRUD | `password` |
| `petugas@bookspace.test` | **Petugas (Staff)** | Circulation Recorders, Books & Categories Curation, Fine Audits & Settlements | `password` |
| `peminjam@bookspace.test` | **Peminjam (Borrower)** | Custom Interactive Dashboard, Book Catalogs, Wishlist Curation, E-Card Generator | `password` |

---

## 📚 Developer Documentation Suite

For developers looking to extend or audit the BookSpace codebase, a modular package of production-grade engineering guides is available inside the root [docs/](file:///c:/laragon/www/BookSpace/docs) folder:

*   📊 **[docs/ARCHITECTURE_BACKEND.md](file:///c:/laragon/www/BookSpace/docs/ARCHITECTURE_BACKEND.md)**: Outlines our Route Middleware Guards (RBAC), thin form requests, atomic database transactions (`DB::transaction`), pessimistic concurrency locking (`lockForUpdate()`), eager loading optimizations, and relational Eloquent schemas.
*   🎨 **[docs/FRONTEND_Polish_GUIDE.md](file:///c:/laragon/www/BookSpace/docs/FRONTEND_Polish_GUIDE.md)**: Catalogues the theme CSS design tokens, Fredoka/Quicksand font selections, widescreen grid ratios, premium cubic-bezier transitions, and Alpine.js interactive micro-animations.
*   🌐 **[docs/LOCALIZATION_GUIDE.md](file:///c:/laragon/www/BookSpace/docs/LOCALIZATION_GUIDE.md)**: Explains the SetLocale session architecture, JSON translation dictionaries, and blade translation guidelines.
*   📋 **[docs/USER_FLOWS_SOP.md](file:///c:/laragon/www/BookSpace/docs/USER_FLOWS_SOP.md)**: Guides you through the borrower catalog operations, custom wishlist bookmarks, print-isolated E-Card generator CSS, and admin configurations.
