# BPCommerce

A Laravel based eCommerce backend and frontend application built for the **Mid-Level Laravel Developer Technical Assignment — Bangla Puzzle Limited**. 

---

## Quick Start

```bash
# 1. Clone & install
git clone https://github.com/alamincse/bpcommerce bpcommerce && cd bpcommerce
composer install && npm install

# 2. Environment
cp .env.example .env
php artisan key:generate
# → edit .env with your DB credentials

# 3. Database + storage + assets
php artisan migrate --seed
php artisan storage:link

# Development
npm run dev

# Production
npm run build

# 4. Run
php artisan serve
```

Visit: **http://127.0.0.1:8000**

| Area | URL |
|---|---|
| Frontend | `/` |
| Admin Panel | `/login` |
| Demo Admin Credentials | `alamin@gmail.com` / `12345678` |

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Key Features](#2-key-features)
3. [Technology Stack](#3-technology-stack)
4. [Project Architecture](#4-project-architecture)
5. [Database Structure & Relationships](#5-database-structure--relationships)
6. [Category Management](#6-category-management)
7. [Subcategory Management](#7-subcategory-management)
8. [Product Management](#8-product-management)
9. [Form Request Validation](#9-form-request-validation)
10. [Automatic Slug Generation](#10-automatic-slug-generation)
11. [File Management Service](#11-file-management-service)
12. [Frontend Implementation](#12-frontend-implementation)
13. [Routing & Middleware](#13-routing--middleware)
14. [Installation & Setup Guide](#14-installation--setup-guide)
15. [VPS Deployment (LEMP Stack)](#15-vps-deployment-lemp-stack)
16. [Troubleshooting](#16-troubleshooting)
17. [Error Handling & Logging](#17-error-handling--logging)
18. [Security & Data Integrity Considerations](#18-security--data-integrity-considerations)
19. [Performance Considerations](#19-performance-considerations)
20. [Evaluation Criteria Mapping](#20-evaluation-criteria-mapping)
21. [Conclusion](#21-conclusion)
22. [Author](#22-author)
---

## 1. Project Overview

This project is a Laravel-based Product and Category Management System designed to manage categories, subcategories, and products through an authenticated backend interface and a public-facing frontend.

The application follows Laravel's MVC architecture and uses Eloquent ORM for database operations, Form Request classes for validation, reusable services for file and slug management, and resource controllers for CRUD operations.

The system maintains a hierarchical relationship between categories, subcategories, and products while providing a structured way to manage and display product information.

### Main Objectives

- Implement complete CRUD functionality for categories, subcategories, and products.
- Maintain proper relationships between related database entities.
- Ensure reliable input validation and data integrity.
- Implement reusable slug generation functionality.
- Manage product image uploads and file deletion.
- Display active products and subcategories on the public frontend.
- Follow clean code practices and Laravel conventions.

---

## 2. Key Features

### Backend Features

**Category Management**

- Create new categories.
- View all categories.
- View individual category details.
- Update existing categories.
- Delete categories with dependency checks.
- Automatically generate unique slugs.
- Manage active/inactive status.

**Subcategory Management**

- Create subcategories under existing categories.
- View subcategories with their parent categories.
- Update subcategory information.
- Delete subcategories with product dependency checks.
- Automatically generate unique slugs.
- Manage active/inactive status.

**Product Management**

- Create products under categories and subcategories.
- Upload product images.
- Set old price and new price.
- Validate product pricing.
- Update product information and images.
- Delete products and their associated images.
- Manage product visibility through status.

### Frontend Features

- Display active subcategories.
- Display active products under their respective subcategories.
- Show product details.
- Display category and subcategory information.
- Show related products from the same subcategory.
- Hide inactive products from public product details.
- SEO-friendly product URLs via slugs.

---

## 3. Technology Stack

| Technology           | Purpose                               |
| -------------------- | ------------------------------------- |
| PHP                  | Backend programming language          |
| Laravel              | Application framework                 |
| MySQL                | Relational database                   |
| Eloquent ORM         | Database operations and relationships |
| Blade                | Frontend templating                   |
| Tailwind CSS         | UI styling                            |
| Laravel Form Request | Request validation                    |
| Laravel Storage      | File management                       |
| Composer             | PHP dependency management             |
| Vite                 | Frontend asset bundling               |
| JavaScript           | Frontend interactions                 |

---

## 4. Project Architecture

The application follows the MVC (Model-View-Controller) architecture.

### Directory Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Backend/
│   │   │   ├── CategoryController.php
│   │   │   ├── SubcategoryController.php
│   │   │   └── ProductController.php
│   │   ├── HomeController.php
│   │   └── Controller.php
│   │
│   └── Requests/
│       ├── CategoryRequest.php
│       ├── SubcategoryRequest.php
│       └── ProductRequest.php
│
├── Models/
│   ├── Category.php
│   ├── Subcategory.php
│   ├── Product.php
│   └── Traits/
│       └── HasSlug.php
│
└── Services/
    ├── FileService.php
    └── SlugService.php

resources/
└── views/
    ├── backend/
    │   ├── categories/
    │   ├── subcategories/
    │   └── products/
    │
    └── frontend/
        ├── home/
        └── products/

routes/
├── web.php
├── backend.php
└── auth.php
```

### Architectural Responsibilities

**Controllers**

Controllers handle incoming HTTP requests, coordinate application logic, interact with Eloquent models and return appropriate views or redirects.

**Models**

Models represent database entities and define relationships, mass-assignment attributes, attribute casting, and reusable query scopes.

**Form Requests**

Form Request classes centralize validation and authorization logic, keeping controllers cleaner.

**Services**

Reusable business operations are separated into dedicated service classes.

**Traits**

The `HasSlug` trait provides reusable slug generation behavior across multiple models.

**Views**

Blade templates are responsible for rendering backend management interfaces and public-facing pages.

---

## 5. Database Structure & Relationships

The application uses three primary entities:

1. Categories
2. Subcategories
3. Products

### Relationship Structure

```text
Category
   │
   │ 1:N
   │
Subcategory
   │
   │ 1:N
   │
Product
```

A category can have multiple subcategories and products.

A subcategory belongs to one category and can contain multiple products.

A product belongs to one category and one subcategory.

### Database Fields

**categories**

| Field       | Description            |
| ----------- | ---------------------- |
| id          | Primary key            |
| name        | Category name          |
| slug        | Unique URL identifier  |
| description | Category description   |
| status      | Active/inactive status |
| created_at  | Creation timestamp     |
| updated_at  | Update timestamp       |

**subcategories**

| Field       | Description               |
| ----------- | ------------------------- |
| id          | Primary key               |
| category_id | Parent category reference |
| name        | Subcategory name          |
| slug        | Unique URL identifier     |
| description | Subcategory description   |
| status      | Active/inactive status    |
| created_at  | Creation timestamp        |
| updated_at  | Update timestamp          |

**products**

| Field          | Description            |
| -------------- | ---------------------- |
| id             | Primary key            |
| category_id    | Category reference     |
| subcategory_id | Subcategory reference  |
| name           | Product name           |
| slug           | Unique URL identifier  |
| description    | Product description    |
| image          | Product image path     |
| old_price      | Previous product price |
| new_price      | Current product price  |
| status         | Active/inactive status |
| created_at     | Creation timestamp     |
| updated_at     | Update timestamp       |

### Eloquent Relationships

**Category Model**

```php
public function subcategories(): HasMany
{
    return $this->hasMany(Subcategory::class, 'category_id');
}

public function products(): HasMany
{
    return $this->hasMany(Product::class, 'category_id');
}
```

**Subcategory Model**

```php
public function category(): BelongsTo
{
    return $this->belongsTo(Category::class, 'category_id');
}

public function products(): HasMany
{
    return $this->hasMany(Product::class, 'subcategory_id');
}
```

**Product Model**

```php
public function category(): BelongsTo
{
    return $this->belongsTo(Category::class, 'category_id');
}

public function subcategory(): BelongsTo
{
    return $this->belongsTo(Subcategory::class, 'subcategory_id');
}
```

These relationships allow the application to retrieve related records using Eloquent without manually writing repetitive SQL queries.

---

## 6. Category Management

Category management is implemented through `CategoryController`, which provides all seven standard resource-controller actions.

| Method    | Responsibility              |
| --------- | --------------------------- |
| index()   | Display categories          |
| create()  | Show category creation form |
| store()   | Save a new category         |
| show()    | Display category details    |
| edit()    | Show edit form              |
| update()  | Update category             |
| destroy() | Delete category             |

### Category Listing

The listing uses `withCount()` to retrieve related record counts efficiently.

```php
Category::withCount([
    'subcategories',
    'products',
])
->latest()
->paginate($pager);
```

This avoids executing separate count queries for every category.

### Deletion Protection

Before deleting a category, the application checks whether it contains subcategories or products.

```php
if ($category->subcategories()->exists()) {
    return back()->with(
        'error',
        'Cannot delete: category has subcategories.'
    );
}

if ($category->products()->exists()) {
    return back()->with(
        'error',
        'Cannot delete: category has products.'
    );
}
```

The operation uses a database transaction and `lockForUpdate()` to help protect against concurrent deletion operations.

---

## 7. Subcategory Management

Subcategory management is implemented through `SubcategoryController`.

Each subcategory must belong to an existing category.

### Main Operations

- Create subcategories.
- Retrieve subcategories with parent category information.
- Update subcategory details.
- Delete subcategories.
- Prevent deletion when products are associated with a subcategory.

### Parent Category Relationship

```php
$subcategories = Subcategory::with('category')
    ->withCount('products')
    ->latest()
    ->paginate($pager);
```

Eager loading retrieves category information alongside subcategories.

### Deletion Protection

The application prevents deleting a subcategory when products are associated with it.

```php
if ($subcategory->products()->exists()) {
    return back()->with(
        'error',
        'Cannot delete: subcategory has products.'
    );
}
```

This helps maintain referential integrity at the application level.

---

## 8. Product Management

Product management is implemented through `ProductController`. It supports complete CRUD functionality, including image upload and replacement.

### Product Creation Process

1. Validate submitted product information.
2. Retrieve category and subcategory information.
3. Prepare product data.
4. Upload the product image when provided.
5. Create the product record.
6. Commit the database transaction.
7. Redirect with a success message.

### Database Transaction

Product creation and updating use explicit database transactions.

```php
DB::beginTransaction();

try {
    // Prepare product data.

    // Upload image when provided.

    Product::create($data);

    DB::commit();

} catch (Throwable $e) {
    DB::rollBack();

    Log::error('Product store error: ' . $e->getMessage());
}
```

Transactions help ensure database operations are rolled back when an exception occurs.

### Product Image Management

The application uses `FileService` to manage uploaded images.

Image storage directory:

```text
storage/app/public/products/
```

The service generates unique filenames to reduce filename conflicts.

During product updates:

- The existing image path is preserved.
- A new image is uploaded when provided.
- The database record is updated.
- The previous image is deleted after a successful database commit.

During product deletion:

- The product record is deleted.
- Its associated image is removed from storage.

---

## 9. Form Request Validation

Validation logic is separated into dedicated Form Request classes.

### CategoryRequest

- Category name is required and must be unique.
- Slug must be unique when provided.
- Description is optional.
- Status is required and must be boolean.

### SubcategoryRequest

- Parent category must exist.
- Subcategory name is required and must be unique within the same category.
- Slug must be unique.
- Description is optional.
- Status must be boolean.

### ProductRequest

- Category must exist.
- Subcategory must exist.
- Subcategory must belong to the selected category.
- Product name must be unique within the selected subcategory.
- Slug must be unique.
- Image must be a valid JPG, JPEG, PNG or WEBP file.
- Image size must not exceed 1024 KB.
- Old price must be numeric and non-negative.
- New price is required and must be numeric and non-negative.
- New price cannot exceed old price when old price is provided.
- Status must be boolean.

### Important Validation Rule

The product request validates the relationship between category and subcategory.

```php
'subcategory_id' => [
    'required',
    'integer',
    Rule::exists($subcategoryTable, 'id')
        ->where('category_id', $this->input('category_id')),
],
```

This prevents selecting a subcategory that belongs to a different category.

---

## 10. Automatic Slug Generation

The application uses a reusable `HasSlug` trait and `SlugService`.

### HasSlug Trait

The trait automatically generates a slug when a model is created without one. It also regenerates the slug when the model name changes and the slug has not been manually modified.

### SlugService

The service uses Laravel's `Str::slug()` method.

Example:

```text
Product Name       to product-name
Product Name       to product-name-1
Product Name       to product-name-2
```

Before generating a slug, the service checks whether the slug already exists.

It supports:

- Unique slug generation.
- Existing record exclusion during updates.
- Error logging.
- Validation exceptions when a valid slug cannot be generated.

This approach keeps slug generation reusable and consistent across Category, Subcategory, and Product models.

---

## 11. File Management Service

`FileService` provides reusable file management functionality.

### Available Methods

| Method      | Responsibility           |
| ----------- | ------------------------ |
| upload()    | Upload a file            |
| replace()   | Replace an existing file |
| delete()    | Delete a stored file     |
| exists()    | Check file existence     |
| url()       | Generate public file URL |
| filename()  | Retrieve filename        |
| extension() | Retrieve file extension  |
| size()      | Retrieve file size       |
| mimeType()  | Retrieve MIME type       |

### Storage Configuration

The service uses Laravel's public storage disk.

Uploaded files are stored using Laravel Storage APIs instead of hardcoded filesystem paths.

To expose public storage files, run:

```bash
php artisan storage:link
```

---

## 12. Frontend Implementation

The public frontend is managed through `HomeController`.

### Homepage

The homepage displays active subcategories that contain active products.

```php
Subcategory::active()
    ->whereHas('products', fn ($q) => $q->active())
    ->withCount([
        'products' => fn ($q) => $q->active()
    ])
    ->with([
        'category:id,name,slug',
        'products' => fn ($q) => $q->active()->latest(),
    ])
    ->orderBy('name')
    ->paginate($pager);
```

This implementation provides:

- Active subcategories only.
- Subcategories containing active products.
- Active products under each subcategory.
- Related category information.
- Product counts.
- Pagination.

### Product Details

Products are accessed using their slug.

```text
/products/wireless-bluetooth-headphones
```

The controller:

- Resolves products using slug-based route model binding (`{product:slug}`).
- Returns a 404 response for inactive products.
- Loads category and subcategory relationships.
- Retrieves up to four related active products from the same subcategory.

This provides a cleaner URL structure and improves frontend navigation.

---

## 13. Routing & Middleware

The application uses Laravel resource routes.

### Backend Routes

Backend routes are grouped under the `admin` prefix and protected by Laravel's authentication middleware.

```php
Route::middleware('auth')
    ->prefix('admin')
    ->group(function () {

        Route::name('backend.')->group(function () {
            Route::resource('categories', CategoryController::class);
            Route::resource('subcategories', SubcategoryController::class);
            Route::resource('products', ProductController::class);
        });

    });
```

### Public Routes

```php
Route::get('/', [HomeController::class, 'index'])
    ->name('home.index');

Route::get('/products/{product:slug}', [HomeController::class, 'show'])
    ->name('home.products.show');
```

### Route Naming Convention

| Route                    | Purpose                |
| ------------------------ | ---------------------- |
| backend.categories.*     | Category management    |
| backend.subcategories.*  | Subcategory management |
| backend.products.*       | Product management     |
| home.index               | Public home page        |
| home.products.show       | Public Product details        |

---

## 14. Installation & Setup Guide

### Prerequisites

- PHP version compatible with the installed Laravel v12.71.0 version (8.2+ recommended, I used PHP v 8.2.12).
- Composer v2.8.9.
- MySQL.
- Node.js(v22.16.0) and NPM.
- A compatible PHP web server.

### Step 1: Clone the Repository

```bash
git clone https://github.com/alamincse/bpcommerce
cd bpcommerce
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

### Step 3: Configure Environment

```bash
cp .env.example .env
```

Configure database credentials in `.env`.

```env
APP_NAME=BPCommerce
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bpcommerce
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
PAGER=10
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Run Database Migrations

```bash
php artisan migrate
```

To seed sample data:

```bash
php artisan migrate --seed
```

Alternatively, import the provided SQL dump:

```bash
mysql -u root -p your_database < database/bpcommerce.sql
```

### Step 6: Install Frontend Dependencies

```bash
npm install
```

### Step 7: Create Storage Symbolic Link

```bash
php artisan storage:link
```

### Step 8: Clear Application Cache

```bash
php artisan optimize:clear
```

### Step 9: Build Frontend Assets

```bash
# For production:
npm run build

# or for development:
npm run dev
```

### Step 10: Start Development Server

```bash
php artisan serve
```

The application will be available at:

```text
http://127.0.0.1:8000
```

Admin panel:

```text
http://127.0.0.1:8000/login
```

---

## 15. VPS Deployment (LEMP Stack)

The application is designed for a standard **LEMP stack** on Ubuntu 22.04 with Nginx, PHP 8.2-FPM, MySQL 8.0, and Let's Encrypt SSL.

### 15.1 Server Provisioning

```bash
# Create a non-root sudo user
adduser deploy
usermod -aG sudo deploy

# Firewall
ufw allow OpenSSH
ufw allow 'Nginx Full'
ufw enable
```

### 15.2 Install LEMP Stack

```bash
sudo apt update
sudo apt install nginx mysql-server php8.2-fpm php8.2-cli \
    php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-curl \
    php8.2-zip php8.2-mysql unzip git composer

# Secure MySQL
sudo mysql_secure_installation
```

### 15.3 Create Database

```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE bpcommerce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'bpcommerce'@'localhost' IDENTIFIED BY '<strong-password>';
GRANT ALL PRIVILEGES ON bpcommerce.* TO 'bpcommerce'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 15.4 Deploy the Project

```bash
cd /var/www
sudo git clone https://github.com/alamincse/bpcommerce bpcommerce
sudo chown -R deploy:www-data bpcommerce
cd bpcommerce

composer install --no-dev --optimize-autoloader
npm ci && npm run build

cp .env.example .env
php artisan key:generate
```

### 15.5 Configure Production `.env`

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_DATABASE=bpcommerce
DB_USERNAME=bpcommerce
DB_PASSWORD=<strong-password>

FILESYSTEM_DISK=public
PAGER=12
```

### 15.6 Set Permissions

```bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R deploy:www-data storage bootstrap/cache
```

### 15.7 Run Migrations & Optimize

```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 15.8 Nginx Server Block

Create `/etc/nginx/sites-available/bpcommerce`:

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/bpcommerce/public;

    index index.php;
    charset utf-8;
    client_max_body_size 5M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    location ~* \.(jpg|jpeg|png|webp|svg|css|js|woff2)$ {
        expires 30d;
        access_log off;
        add_header Cache-Control "public, immutable";
    }
}
```

Enable and test:

```bash
sudo ln -s /etc/nginx/sites-available/bpcommerce /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 15.9 SSL with Let's Encrypt

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d your-domain.com
sudo systemctl status certbot.timer
```

### 15.10 Post-Deploy Update Workflow

```bash
cd /var/www/bpcommerce
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl reload php8.2-fpm
```

---

## 16. Troubleshooting

| Symptom | Likely Cause | Fix |
| --- | --- | --- |
| `419 Page Expired` on form submit | Missing `APP_KEY` or session issue | `php artisan key:generate` then `php artisan config:clear` |
| Product images return 404 | Storage symlink missing | `php artisan storage:link` |
| `.env` changes have no effect | Config is cached | `php artisan config:clear` |
| Slugs are numeric (`/products/42`) | Route uses `{product}` instead of `{product:slug}` | Update `routes/web.php` |
| Pagination links not visible | Blade `links()` call missing | Add `{{ $paginator->links() }}` in the view |
| `Class not found` after update | Autoloader stale | `composer dump-autoload` |
| Pagination shows old per-page value | `PAGER` cached | `php artisan config:clear` |
| Migration fails on foreign key | Order of migrations | Ensure `categories` runs before `subcategories` / `products` |
| Permission denied on `storage/` | Wrong ownership | `sudo chown -R www-data:www-data storage bootstrap/cache` |

---

## 17. Error Handling & Logging

The application uses Laravel's logging system to record exceptions.

Examples include:

- Category creation and update errors.
- Category deletion errors.
- Subcategory creation and update errors.
- Product creation and update errors.
- Product deletion errors.
- File deletion warnings.
- Slug generation errors.

Example:

```php
Log::error('Product store error: ' . $e->getMessage());
```

This provides useful debugging information without exposing internal exception details directly to end users.

User-facing success and error messages are returned through Laravel session flash messages.

---

## 18. Security & Data Integrity Considerations

The implementation includes several application-level safeguards:

1. Authentication middleware protects backend resource routes.
2. Form Request classes validate incoming data.
3. Unique validation rules prevent duplicate names and slugs.
4. Relationship validation prevents mismatched category and subcategory selection.
5. Image validation restricts accepted formats and file sizes.
6. Database transactions protect product create/update operations.
7. Dependency checks prevent deletion of categories and subcategories that contain related records.
8. Eloquent ORM provides structured database interaction.
9. Error logging helps diagnose application issues.

---

## 19. Performance Considerations

The application uses several Laravel features to improve query efficiency:

- Eager loading with `with()` to reduce unnecessary database queries.
- `withCount()` to retrieve relationship counts efficiently.
- `whereHas()` to filter records based on relationships.
- Pagination to limit the number of records retrieved per request.
- Selective column loading for related models (`with('category:id,name,slug')`).
- Query scopes to reuse active-status filtering logic.

These practices help keep database interactions organized and reduce unnecessary data retrieval.

---

## 20. Evaluation Criteria Mapping

| Evaluation Criteria | Implementation |
| --- | --- |
| **Functionality** | Complete CRUD operations for categories, subcategories, and products |
| **Code Quality** | MVC architecture, reusable services, traits and dedicated Form Requests |
| **Laravel Knowledge** | Resource routing, Eloquent relationships, route model binding (`{product:slug}`), validation, transactions, pagination and storage |
| **Problem-Solving** | Unique slug generation, relationship validation, dependency checks and image lifecycle management |
| **Documentation** | Project architecture, setup instructions, VPS deployment guide and implementation details |

---

## 21. Conclusion

This project demonstrates a structured approach to building a Laravel-based product management application.

It implements CRUD operations, hierarchical Eloquent relationships, centralized validation, reusable service classes, automatic slug generation, file management, database transactions, and public product listing.

The application is organized to maintain readability, reusability, and maintainability while following common Laravel development conventions.

The architecture also provides a foundation for future enhancements such as role-based access control, automated testing, advanced filtering, and API integration.

---

## 22. Author

**Al-Amin Sarker**

- Email: `cseal.amin.09@gmail.com`
- Phone: `+8801717-251095`
- GitHub: `https://github.com/alamincse`