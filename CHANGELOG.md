# Changelog

All notable changes to the Rentify project will be documented in this file.

## [2026-01-01]

### Fixed

-   **Dashboard Chart Booking Count** (`src/Controller/AdminsController.php`)
    -   Changed booking count query to use `start_date` instead of `created` date.
    -   Changed revenue calculation to use booking `start_date` and `total_price` instead of payment `payment_date`.
    -   Both metrics are now counted in the month the rental begins, not when booking/payment was made.
    -   This aligns the "Revenue & Bookings Trend" chart with the Booking Interactive Calendar.

### Changed

-   **Dashboard Chart UX Improvements** (`templates/Admins/dashboard.php`)
    -   Changed Revenue to use **bar chart** (shows volume better) instead of area chart.
    -   Bookings displayed as a **line with markers** for clear trend visibility.
    -   **Y-axis now starts at 0** for both metrics (honest scale, prevents misleading visuals).
    -   Changed from smooth curves to **straight lines** for accurate data representation.
    -   Enhanced tooltip to show formatted values ("RM X" and "X bookings").
-   **Footer Updates**
    -   Updated social media links to point to valid URLs (Twitter, Facebook, Instagram).
    -   Updated Twitter icon/label to new "X" branding.
    -   Added GitHub repository link to footer.

## [2025-12-31]

### Changed

-   **Redesign Car Reviews Page**
    -   Implemented modern two-column layout with sticky summary sidebar (`templates/Reviews/car_reviews.php`).
    -   Cleaned up `add_review.php` by removing car image preview.
-   **Flash Message Refinement**
    -   Standardized Bootstrap Toast positioning to top-right across all layouts.
    -   Ensured auto-dismiss functionality (3 seconds) and working close buttons.

## [2025-12-30]

### Added

-   **Structural & Quality Improvements**
    -   Created `BookingService` to handle complex business logic (pricing, tax, invoices) (`src/Service/BookingService.php`)
    -   Created `StatusHelper` for consistent UI badges across templates (`src/View/Helper/StatusHelper.php`)
-   **Policy Engine & Service Integration**

-   **Policy Engine & Service Integration**
    -   Added 7 policy fields to `car_categories`: security_deposit, insurance_tier, insurance_daily_rate, chauffeur_available, chauffeur_daily_rate, gps_available, gps_daily_rate
    -   Added 4 service selection fields to `bookings`: has_chauffeur, has_gps, has_full_insurance, security_deposit_amount
    -   Created virtual properties in Booking entity: `total_calculated_price`, `rental_days`, `price_breakdown`
    -   Added custom validation rules for chauffeur/GPS service availability
    -   Updated CarCategories add/edit forms with policy settings UI
-   Added "Categories" menu item to admin sidebar under Fleet (`fa-layer-group` icon)
-   **Enhanced CarCategories view/edit pages**
    -   View page shows policy settings card (deposit, insurance, chauffeur, GPS availability)
    -   Both pages display cars belonging to the category with status badges
-   **CarCategories Template Refresh**
    -   `index.php`: DataTables with purple theme, column filters for Name/Insurance/Chauffeur/GPS
    -   `view.php`: Card-based layout with Financial Policy and Services cards
    -   `add.php` / `edit.php`: Modern card-based forms grouped by section
-   **Service Add-ons Integration**
    -   Dynamic add-ons in booking form based on category availability/rates
    -   `BookingsController::add()` calculates add-on costs (chauffeur, GPS, insurance)
    -   Invoice displays itemized add-on breakdown with individual costs

### Changed

-   **Architectural Refactoring**
    -   Consolidated `sidebar.php` and `public_sidebar.php` into a single unified element
    -   Refactored `BookingsController` to use `BookingService` for cleaner action logic
    -   Replaced inline status badge logic in templates with `StatusHelper`
-   Updated `CarCategory` entity with new policy fields and `hasMany('Cars')` relationship

-   Updated `CarCategory` entity with new policy fields and `hasMany('Cars')` relationship
-   Updated `CarCategoriesTable` with validation rules for all policy fields
-   Updated `BookingsTable` with service selection validation and application rules

### Removed

-   Deleted redundant `public_sidebar.php` element

## [2025-12-29]

### Changed

-   Refactored sidebar to use data-driven menu structure with `$menuItems` array (`templates/element/sidebar.php`)
-   Updated sidebar layout to use flexbox - menu scrolls independently, footer stays fixed
-   Hidden scrollbar for minimalist design while maintaining scroll functionality
-   Fixed Users menu activeMatch to `Users:index` to prevent conflict with My Account
-   **Extracted inline CSS/JS from template files into shared external files (major cleanup)**
    -   `Cars/index.php`: 539 → 139 lines (74% reduction)
    -   `Bookings/index.php`: 511 → 140 lines (73% reduction)
    -   `Reviews/index.php`: 423 → 128 lines (70% reduction)
    -   `Maintenances/index.php`: 394 → 100 lines (75% reduction)
    -   `Users/index.php`: 445 → 111 lines (75% reduction)
    -   `Payments/index.php`: 417 → 119 lines (71% reduction)

### Added

-   Created Antigravity workflow file with project rules and conventions (`.agent/workflows/antigravity.md`)
-   Added DataTables to Maintenances index with car/status filters and amber theme (`templates/Maintenances/index.php`)
-   Added DataTables to Users index with name/role/month filters and purple theme (`templates/Users/index.php`)
-   Redesigned Maintenances/edit.php with modern card-based layout matching Cars/edit.php
-   Added auto car status sync - scheduled maintenance sets car to "maintenance", completed sets to "available"
-   Added dynamic dashboard alerts for scheduled maintenances and low-rating issue reviews
-   Added "Show Issues Only" filter to Reviews index for low-rating reviews (≤2 stars)
-   Added "Schedule Maintenance" button on low-rating reviews linking to pre-filled maintenance form
-   **Created shared DataTables CSS file** (`webroot/css/datatables-custom.css`) - centralized table styling
-   **Created shared DataTables JS file** (`webroot/js/datatables-init.js`) - reusable auto-initialization
-   Added CSS/JS includes to admin layout (`templates/layout/admin.php`)

### Fixed

-   Fixed missing `<?php` opening tag in sidebar configuration block
-   Fixed variable naming inconsistency (`$isAdmin` vs `$sidebarIsAdmin`)
-   Fixed PHP syntax errors with if/endif blocks in sidebar
-   Fixed InvoicesController missing admin layout causing DataTables not to load

### Removed

-   Deleted unused `webroot/css/sidebar.css` (138 lines) - sidebar uses inline styles in `element/sidebar.php`

## [2025-12-28]

### Changed

-   Updated booking redirect to `view_invoices.php` instead of `view.php`
-   Refined invoice PDF print functionality
-   Fixed dashboard chart to show actual booking counts
