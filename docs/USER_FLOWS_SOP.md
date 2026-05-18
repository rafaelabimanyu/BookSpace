# 📋 User Flows & Operations Master Manual (SOP)

This manual provides the step-by-step Standard Operating Procedures (SOP) for the **BookSpace** system, guiding developers and operators through borrower activities, staff circulations, and global administrative controls.

---

## 📖 Table of Contents
1. [Borrower (Peminjam) Operations](#-borrower-peminjam-operations)
2. [Staff (Petugas & Admin) Circulation Workflows](#-staff-petugas--admin-circulation-workflows)
3. [Global System Configurations (Admin Console)](#-global-system-configurations-admin-console)

---

## 🌸 Borrower (Peminjam) Operations

Borrowers access an engaging visual workspace centered around discovery and simple, seamless circulation operations.

```
[ Catalog Search ] ---> [ Add to Wishlist ] ---> [ Click Reserve ] ---> [ Active Loan Log ]
        |                                                                      |
        v                                                                      v
[ "Ready to Borrow!" ]                                                  [ Track Overdue Fines ]
```

### 1. Catalog Browsing & Search Discovery
- **Action**: Borrowers navigate to `/catalog` to view a card-based inventory of literary assets.
- **Search Filters**: The top navigation bar houses an integrated text search input and category selection dropdown. The page filters results without page-reload parameters, checking book titles, writers, and categories.
- **Eloquent Optimization**: The catalog runs on optimized eager loading (`with(['category', 'reviews.user'])`) to prevent database load, returning book details instantly.

### 2. Wishlist Bookmarking & "Ready to Borrow!" Indicator
- **Action**: When browsing, a borrower can click the bookmark icon on any book card to add/remove it from their personal wishlist.
- **Relationship Matrix**: Under the hood, this uses a robust `belongsToMany` relationship in [User.php](file:///c:/laragon/www/BookSpace/app/Models/User.php#L27) pointing to a pivot `wishlists` table via the `toggleWishlist` method inside [BorrowerCatalogController.php](file:///c:/laragon/www/BookSpace/app/Http/Controllers/BorrowerCatalogController.php#L131-L140).
- **Reactive Indicator Badge**: If a wishlisted book has stock greater than 0, the card displays a pink **"Ready to Borrow!"** badge. If out of stock, the badge changes to a gray **"Out of Stock"** indicator.

### 3. Profile Uploads & The Print-Isolated Digital E-Card
- **Action**: Under `/profile`, borrowers can update their full name, email address, and upload a profile picture.
- **Upload Storage**: Profile pictures are securely processed and saved inside `public/uploads/profiles/`.
- **E-Card Representation**: The system displays a library member E-Card featuring a custom design gradient (`from-secondary-blush to-primary-rose`), user avatar, registration timestamp, formatted Member ID (`BSP-0000XX`), and a mock security barcode.
- **Print-Isolated Stylesheet**: To print a physical card, the borrower clicks **"Print Member Card"** (`window.print()`). BookSpace isolates the E-Card using a custom media query block inside [profile.blade.php](file:///c:/laragon/www/BookSpace/resources/views/peminjam/profile.blade.php#L9-L29):
  ```css
  @media print {
      body * {
          visibility: hidden; /* Hides entire layout header, side index, and buttons */
      }
      #print-member-card, #print-member-card * {
          visibility: visible; /* Keeps card content readable */
      }
      #print-member-card {
          position: fixed;
          left: 50%;
          top: 50%;
          transform: translate(-50%, -50%) scale(1.3); /* Centered and scaled up */
          border: none !important;
          box-shadow: none !important;
          background: linear-gradient(135deg, #FCEAEA 0%, #F3C5C5 100%) !important;
          -webkit-print-color-adjust: exact;
          print-color-adjust: exact; /* Enforces pink backgrounds on physical paper */
      }
  }
  ```

---

## 👑 Staff (Petugas & Admin) Circulation Workflows

Staff and admin users manage the library circulation desk using a high-fidelity control center.

### 1. Administrative Quick Action Center Widgets
The dashboard features unified metric grids that calculate core library statistics at a glance:
- **Total Books**: Direct count of all catalog records.
- **Active Loans**: Count of borrowing circulation rows with `status = 'borrowed'`.
- **Overdue Checkouts**: Count of active borrowings where the deadline is past today's date.
- **Quick Links**: Layout buttons that allow staff to trigger a new book entry, record a checkout transaction, or view monthly reports instantly.

### 2. Vertical Activity Timeline Feed
- **Action**: The circulation center lists active checkouts in chronological order.
- **Overdue Tracker**: If a loan's return deadline is past today's date and its status is still marked `'borrowed'`, the dashboard highlights the record with an animate-ping red badge to alert staff.
- **Stock Automation**: Clicking **"Return"** on any timeline entry runs a transaction that updates the circulation row status to `'returned'`, stamps the actual return date, and increments the book stock in the database automatically.

### 3. Dynamic Fine Calculations & Simulator Policies
- **Calculation Rules**: Fines accrue based on late days: `Late Days = Today - Return Deadline`. If a borrowing becomes late, the system multiplies the late days by the global setting rate (`daily_fine_rate`) dynamically.
- **Simulator Widget**: Borrowers and staff can preview estimated fees using an interactive Alpine.js simulator. Keying in a hypothetical overdue count updates the estimated cost instantly.
- **Cash Fine Settlement**: If an overdue book is returned, the accrued fine is calculated and saved. Staff can settle outstanding payments by clicking **"Pay Fine"**, updating the payment state to `'paid'` inside a transaction.

---

## ⚙️ Global System Configurations (Admin Console)

Administrators control the entire operational behavior of BookSpace using a System Settings console, eliminating the need to modify source code.

```
[ Admin Settings Board ]
   |
   +---> Max Books Allowed      (e.g., 3 books max per borrower)
   +---> Default Loan Window    (e.g., 7 days checkout window)
   +---> Daily Overdue Rate     (e.g., Rp 1,000 fine per day)
```

### 1. Settings Schema
Settings parameters are stored in a simple relational database schema using a key-value registry:
```php
Schema::create('settings', function (Blueprint $table) {
    $table->id();
    $table->string('key')->unique();
    $table->text('value')->nullable();
    $table->timestamps();
});
```

### 2. Live Configuration Updates
Administrators can configure parameters via the web console under `/management/settings`:
1.  **Max Books Allowed** (`max_books_allowed`): Controls checkout limits. If a borrower has active borrowings equal to this limit, the system blocks new checkouts.
2.  **Default Borrow Duration** (`default_borrow_duration`): Configures return window limits.
3.  **Daily Fine Rate** (`daily_fine_rate`): Sets late fee rates per book per day.

### 3. Real-Time Application Impact
These configurations take effect immediately across the application:
- **During Checkout Checkout**: The system retrieves settings to block reservations if checkout limits are met:
  ```php
  $maxBooksAllowed = (int)Setting::get('max_books_allowed', 3);
  if ($activeBorrowingsCount >= $maxBooksAllowed) {
      return back()->with('error', __('Limit exceeded!'));
  }
  ```
- **During Fine Settlement**: The fine ledger calculates and updates outstanding penalties using settings values:
  ```php
  $dailyFineRate = (double)Setting::get('daily_fine_rate', 1000);
  $fineAmount = $daysLate * $dailyFineRate;
  ```
This ensures administrators can easily adapt library policies to meet operational needs.
