# Mini Company Manager

A complete, beginner-friendly corporate web application and catalog management system built with **Laravel**, **PHP 8.3**, **Blade Templates**, **Bootstrap 5**, and **MySQL**.

---

## 🌟 Application Features

### 1. Public Company Website
- **Home (`/`):** Hero section, company value proposition, 4 core specializations, highlighted products, and call-to-action banner.
- **About Us (`/about`):** Company background, mission, vision, operational schedule, and corporate values.
- **Services (`/services`):** Detailed breakdown of service packages and 4-step delivery lifecycle.
- **Products Catalog (`/products`):** Interactive product grid with live keyword search, category filtering, stock availability badges, and pagination.
- **Product Detail (`/products/{product:slug}`):** Dedicated page showing high-resolution product image, SKU, pricing, full description, and related products.
- **Contact Us (`/contact`):** Company contact cards (address, phone, email, hours) and a contact form with server-side validation that stores submissions securely.

### 2. Secure Admin Panel
- **Admin Authentication (`/login`):** Role-checked administrative access with rate limiting against brute-force attacks and session regeneration.
- **Admin Dashboard (`/admin/dashboard`):** Real-time summary metrics (Total Products, Active Online, Featured Count, Total Inquiries, Unread Inquiries) and latest activity feeds.
- **Product CRUD (`/admin/products`):**
  - **Create:** Add new products with automatic slug generation, categorization, pricing, and image upload.
  - **Read:** Search and filter through products with thumbnails and inventory badges.
  - **Update:** Edit product details with preview and safe image replacement.
  - **Delete:** Modal-confirmed deletion with automatic cleanup of stored images.
- **Customer Inquiries (`/admin/messages`):** Review incoming customer messages, mark as read/unread, or delete.
- **Company Settings (`/admin/settings`):** Manage organization name, tagline, email, phone, business hours, and mission/vision directly from the panel.

### 3. Security & Architecture
- **CSRF Protection:** All Blade forms enforce Laravel's `@csrf` token validation.
- **Password Security:** Stored using bcrypt hashing (`BCRYPT_ROUNDS=12`).
- **Authorization Guard:** Custom `admin` middleware restricts administrative actions exclusively to authorized users.
- **Safe File Uploads:** Uploaded images are strictly verified via MIME detection (`jpeg`, `png`, `webp`), size-capped (max 2MB), saved with randomized non-executable filenames, and isolated from executable web directories.
- **SQL Injection Prevention:** 100% parameterized queries via Eloquent ORM.
- **Environment Isolation:** Secrets and database credentials remain exclusively in `.env`, which is ignored by Git.

---

## 💻 System Requirements

- **Operating System:** Windows 10/11 (or macOS / Linux)
- **PHP:** Version **8.2 or 8.3** (ZTS or NTS x64)
- **Required PHP Extensions:**
  - `pdo_mysql`
  - `openssl`
  - `mbstring`
  - `fileinfo`
  - `curl`
  - `tokenizer`
  - `xml`
  - `bcmath`
  - `ctype`
  - `intl`
  - `pdo_sqlite` (used for fast in-memory test execution)
- **Composer:** Version **2.x**
- **Database:** **MySQL 8.0+** or **MariaDB 10.4+**

---

## 🚀 Local Windows Setup Guide (Laragon / XAMPP)

### Step 1: Verify PHP and Composer
Open your terminal (PowerShell, Command Prompt, or Laragon Terminal) and check:
```powershell
php -v
composer -v
```
*(If using Laragon, you can enable global CLI access via **Laragon Menu > Tools > PATH > Add Laragon to PATH**)*

---

### Step 2: Configure Environment Variables
Inside the project root directory (`D:\demo php project`):
1. Copy `.env.example` to `.env` (if not already done):
   ```powershell
   copy .env.example .env
   ```
2. Generate an application encryption key:
   ```powershell
   php artisan key:generate
   ```
3. Open `.env` and verify your MySQL connection settings:
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mini_company_manager
   DB_USERNAME=root
   DB_PASSWORD=
   ```

---

### Step 3: Create the MySQL Database
Ensure your MySQL server is running (e.g. Click **Start All** in Laragon or XAMPP).

Create the database using MySQL CLI or phpMyAdmin:
```sql
CREATE DATABASE IF NOT EXISTS mini_company_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### Step 4: Run Migrations and Seeders
Run the database schema migrations and seed default demo data:
```powershell
php artisan migrate --seed
```

This will automatically create all tables and seed:
- **Default Super Admin:**
  - **Email:** `admin@example.com`
  - **Password:** `password`
- **Company Settings:** Pre-configured corporate profile
- **Sample Products:** 6 realistic enterprise products across various categories

#### Changing the Administrator Password
To securely change or set a new password for the administrator at any time (local or production):
```powershell
php artisan admin:password
```
*(You will be interactively prompted for the new password with input hidden from the terminal screen)*

---

### Step 5: Link Public Storage for Uploads
Generate the symbolic link connecting `storage/app/public` to `public/storage`:
```powershell
php artisan storage:link
```

---

### Step 6: Start the Development Server
Launch the local development server:
```powershell
php artisan serve
```

Visit the application in your browser:
- **Public Website:** [http://localhost:8000](http://localhost:8000)
- **Admin Login:** [http://localhost:8000/login](http://localhost:8000/login)

---

## 🧪 Running Automated Tests

The application includes an automated feature test suite covering:
- Authentication, session validation, and administrative route guards.
- Product CRUD operations, validation rules, image uploads, and security file-type restrictions.
- Public page rendering and contact form submissions.

Tests run against an isolated in-memory SQLite database configured in `phpunit.xml` without touching your MySQL data.

Run the tests with:
```powershell
php artisan test
```
*Or with compact output:*
```powershell
php artisan test --compact
```

---

## 🌐 Future cPanel Deployment Guide

When deploying this project to shared hosting using **cPanel**, follow these industry best practices to ensure security:

### Step 1: Recommended File Directory Structure
**Never** place your whole Laravel application directly inside `public_html`. Doing so risks exposing sensitive files like `.env`, tests, or source code.

Instead, separate application code from the web root:
```text
/home/your_username/
├── mini_company_manager/        <-- Entire Laravel project folder (NOT publicly accessible)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env
│   └── artisan
└── public_html/                 <-- Only the contents of Laravel's /public folder
    ├── index.php
    ├── .htaccess
    ├── robots.txt
    └── storage/ (symlink)
```

### Step 2: Upload Files via cPanel File Manager or FTP
1. On your local machine, zip your project files **excluding**:
   - `vendor/` (run `composer install --no-dev --optimize-autoloader` on server or upload if SSH is not available)
   - `.env`
   - `node_modules/`
   - `.git/`
2. In cPanel File Manager, create folder `/home/your_username/mini_company_manager` and extract your project files there.
3. Move all contents inside `/mini_company_manager/public/` directly into `/home/your_username/public_html/`.

### Step 3: Update `public_html/index.php`
Edit `/home/your_username/public_html/index.php` so the paths point to your project directory:
```php
// Change lines:
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// To:
require __DIR__.'/../mini_company_manager/vendor/autoload.php';
$app = require_once __DIR__.'/../mini_company_manager/bootstrap/app.php';
```

### Step 4: Configure Production `.env` on cPanel
In `/home/your_username/mini_company_manager/`, create a new `.env` file:
```dotenv
APP_NAME="Mini Company Manager"
APP_ENV=production
APP_KEY=base64:your_production_key_here
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yourusername_minicompany
DB_USERNAME=yourusername_dbuser
DB_PASSWORD=your_strong_password
```
> [!IMPORTANT]
> Always set `APP_DEBUG=false` in production to prevent leaking database credentials and stack traces to visitors.

### Step 5: Database Setup on cPanel
1. In cPanel, navigate to **MySQL Databases**.
2. Create a database: e.g. `yourusername_minicompany`.
3. Create a MySQL user with a strong password and assign **All Privileges** to that database.
4. Export your local MySQL database using phpMyAdmin or HeidiSQL, and import it into cPanel via **phpMyAdmin**.
   *(Alternatively, if you have SSH access, run `php artisan migrate --force --seed`)*.

### Step 6: Create Storage Symlink on cPanel
To ensure product images are accessible via `https://yourdomain.com/storage/...`:

- **Option A (via SSH Terminal in cPanel):**
  ```bash
  ln -s /home/your_username/mini_company_manager/storage/app/public /home/your_username/public_html/storage
  ```
- **Option B (via a One-Time Cron Job in cPanel):**
  Add a cron job scheduled once:
  ```bash
  /usr/local/bin/php /home/your_username/mini_company_manager/artisan storage:link
  ```
  *(Delete the cron job after it runs)*.

### Step 7: Folder Permissions
Ensure the following directories have write permissions (typically `775` or `755` depending on server setup):
- `/home/your_username/mini_company_manager/storage`
- `/home/your_username/mini_company_manager/bootstrap/cache`

---

## 📁 Project Structure Highlights

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── CompanyController.php            # Public site pages & contact submission
│   │   ├── AuthController.php               # Admin login & session logout
│   │   └── Admin/
│   │       ├── DashboardController.php      # Admin metrics & recent activity
│   │       ├── ProductController.php        # Product CRUD & image handling
│   │       ├── CompanySettingController.php # Organization configuration
│   │       └── ContactMessageController.php # Inquiries handling
│   ├── Middleware/
│   │   └── EnsureUserIsAdmin.php            # Admin authorization guard
│   └── Requests/
│       ├── LoginRequest.php                 # Throttled authentication request
│       ├── ProductRequest.php               # Product validation & image restrictions
│       ├── ContactRequest.php               # Contact form validation
│       └── CompanySettingRequest.php        # Profile validation
├── Models/
│   ├── User.php                             # User model with isAdmin() method
│   ├── Product.php                          # Product model with image URL accessor
│   ├── CompanySetting.php                   # Singleton company settings
│   └── ContactMessage.php                   # Contact inquiry model
database/
├── migrations/                              # Database schemas
├── factories/                               # Model test factories
└── seeders/                                 # Initial admin & demo data
resources/views/
├── layouts/
│   ├── public.blade.php                     # Responsive customer layout with Bootstrap 5
│   └── admin.blade.php                      # Admin portal sidebar layout
├── public/                                  # Public website pages (home, about, services, products, contact)
├── auth/                                    # Authentication views (login)
└── admin/                                   # Admin dashboard & management interfaces
tests/Feature/
├── AuthenticationTest.php                   # Feature tests for login/logout/guards
├── ProductCrudTest.php                      # Feature tests for full CRUD & upload safety
└── PublicPagesTest.php                      # Feature tests for website & contact form
```

---

## 📜 License
This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
