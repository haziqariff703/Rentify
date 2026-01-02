# Changelog

All notable changes to the Rentify project will be documented in this file.

## [2026-01-03]

### Added

-   **User Payment View Page** (`templates/Payments/view_payment.php`)
    -   Created read-only payment confirmation page for users (separate from admin view).
    -   Shows car thumbnail, payment details, and links to related invoice/booking.
    -   No Edit/Delete buttons - user can only view their own payments.
    -   Security check in controller prevents users from viewing other users' payments.
-   **viewPayment Controller Action** (`src/Controller/PaymentsController.php`)
    -   Added `viewPayment()` action with ownership security check.
    -   Fetches payment with booking, car, and invoice data for display.
-   **About Us Team Section** (`templates/Pages/about_us.php`)
    -   Integrated team founders photo into mission statement section.
    -   Added team members: Haziq, Zulfadli, Rasyid, Safa.
    -   Red underline accent on "experiences" with team philosophy paragraph.
    -   Drop shadow effect and responsive two-column layout.

### Changed

-   **My Payments View Button** (`templates/Payments/my_payments.php`)
    -   Changed View button link from `view` (admin) to `viewPayment` (user).
-   **PaymentsController beforeFilter** - Added `viewPayment` to user-accessible actions.
-   **My Account Page Redesign** (`templates/Users/my_account.php`)
    -   Replaced purple gradient header with clean white profile card.
    -   Applied unified design system: Montserrat (headings), Inter (body).
    -   Stats row moved inside profile card with vertical dividers.
    -   Navy card headers (#1e293b) for Personal Information, Address, My Bookings, My Reviews sections.
    -   Updated buttons to pill style with hover effects.
    -   Removed icons from buttons for cleaner look.
-   **Edit Profile Page Redesign** (`templates/Users/edit_profile.php`)
    -   Replaced purple gradient header with clean white profile card.
    -   Navy card headers for Personal Information and Security sections.
    -   Modernized form inputs with Montserrat/Inter fonts.
    -   Pill-style Save/Cancel buttons matching my_account.
    -   Removed icons from buttons for cleaner look.

### Fixed

-   Fixed invisible payment receipt details in `view_invoices.php` by changing layout to block/margin-auto and adding `!important` color overrides.
-   Optimized invoice PDF layout by compacting "Receipt" box width and reducing vertical margins to prevent page splitting.

### Removed

-   Deleted `view_payments.php` (incorrect plural naming) - replaced with `view_payment.php`.

## [2026-01-02]

### Changed

-   **Dashboard Optimization**: Refactored `AdminsController::dashboard` logic into `src/Service/AdminDashboardService.php` to reduce controller complexity and improve maintainability.
-   **Bookings Refactoring**: Extracted all business logic (Booking creation, cancellation, approval, and auto-completion) from `BookingsController` and `AdminsController` into `BookingService`.
-   **API Documentation (PHPDoc)**: Added comprehensive PHPDoc blocks to `BookingService`, `AdminDashboardService`, `BookingsController`, and `AdminsController` for improved code clarity and IDE support.
-   **Dashboard Interactivity**: Added Date Range Filter, Quick Actions, and Inline Approvals (Backend implementation).
    -   **Date Range Filter**: Filter dropdown (Today, This Week, This Month, Last 3 Months) with live filtering of Bookings, Revenue, and Users stats.
    -   **Quick Actions Dropdown**: One-click access to New Booking, Add Car, Add User, Schedule Maintenance, and View Issues.
    -   **Inline Booking Approvals**: Pending bookings mini-list in Action Center with inline ✓ Approve and 👁 View buttons.
-   **Security Hardening**: Enabled `FormProtection` component in `AppController` to prevent form tampering and request forgery.
-   **Dashboard Stat Cards Redesign** (`templates/Admins/dashboard.php`)
    -   Replaced large faded icons with rounded square icon boxes (16px radius, 60x60px).
    -   Percentages now calculate from real data: bookings and revenue compare this month vs last month.
    -   New users count shows actual registrations in the last 7 days.
    -   Changed currency from `$` to `RM` for consistency.
-   **Dashboard Widgets**:
    -   replaced "Hourly Pulse" chart with "Fleet Status" donut chart for better utility in the mini-widget area.
    -   Consolidated layout by moving Fleet Status from bottom row to the main grid.
-   **Action Center "Returns Due Today"**: Button now links to `Bookings/index` instead of being non-functional.
-   **Reviews Management Maintenance Integration** (`templates/Reviews/index.php`)
    -   Added dedicated "Maintenance" column.
    -   Displays "Mark Done" button for cars currently in maintenance (triggers `Maintenances::completeActive`).
    -   Displays "Schedule" button for low-rated cars needing maintenance.
    -   Added `completeActive()` method to `MaintenancesController` to simplified maintenance completion from external views.
    -   Fixed matching logic for "maintenance" status to be case-insensitive.
    -   Implemented smart "Resolved" status: Checks if a maintenance was completed _after_ the review date to prevent re-scheduling resolved issues.
-   **Top Performing Cars**: Fixed image path - now correctly displays car thumbnails instead of placeholder icons.
-   **Month-over-Month Calculations** (`src/Controller/AdminsController.php`)
    -   Added `$bookingsChange`, `$revenueChange`, `$newUsersThisWeek` variables with real database queries.

### Changed

-   **View Page CSS Standardization & Font Upgrade** (`webroot/css/custom.css`)
    -   Created unified `.view-container` component system with ~500 lines of CSS.
    -   **Typography Upgrade**: Switched primary heading and data font to **Poppins** (bold) for a cleaner, more professional look.
    -   Card headers: Premium black gradient with subtle texture overlay.
    -   Includes shared styles for `.page-header`, `.view-grid`, `.form-card`, `.view-table`, `.specs-grid`, `.related-sections`, status badges, and more.
-   **Header Overlay Adjustment**: Updated car info overlay gradient in `custom.css` to use a refined dark gray (`#434343`) for better contrast.

### Refactored

-   **Standardized All View Templates**
    -   `Users/view.php`: Completely refactored to the standardized system. Replaced the unique hero-header with a clean grid-based profile structure matching the rest of the application.
    -   `Bookings/view.php`: Removed ~335 lines of internal CSS, now uses `.view-container`.
    -   `Cars/view.php`: Removed ~310 lines of internal CSS, now uses `.view-container`.
    -   `Payments/view.php`: Removed ~137 lines of internal CSS, now uses `.view-container`.
    -   `Reviews/view.php`: Removed ~140 lines of internal CSS, now uses `.view-container`.
    -   `Maintenances/view.php`: Completely redesigned from CakePHP baked template to modern `.view-container` layout.
    -   `CarCategories/view.php`: Reduced inline CSS significantly, kept page-specific styles only.
-   Standardized container class naming across all view pages.

### Backend Refactoring

-   **Created `ImageUploadService`** (`src/Service/ImageUploadService.php`)
    -   Centralized image upload logic with validation (MIME type, file size).
    -   Convenience methods: `uploadAvatar()` for users, `uploadCarImage()` for cars.
    -   Automatic old file cleanup when uploading replacements.
-   **Refactored `UsersController`**: Removed `_uploadAvatar()` helper, now uses `ImageUploadService`.
-   **Refactored `CarsController`**: Removed duplicated upload logic in `add()` and `edit()`, now uses `ImageUploadService`.
-   **Created Authorization Helper Methods** (`src/Controller/AppController.php`)
    -   `isAdmin()`: Check if current user is admin.
    -   `isAuthenticated()`: Check if user is logged in.
    -   `requireAdmin()`: Redirect non-admins with error message.
    -   `setAdminLayoutIfAdmin()`: Apply admin layout for admin users.
-   **Standardized Authorization** across all controllers:
    -   `AdminsController`, `CarCategoriesController`, `MaintenancesController`: Use `requireAdmin()`.
    -   `UsersController`, `CarsController`, `PaymentsController`, `ReviewsController`, `InvoicesController`, `BookingsController`: Use `isAdmin()` and `setAdminLayoutIfAdmin()`.

### JavaScript Separation

-   **Extracted Inline JS to External Files** (`webroot/js/`)
    -   `webroot/js/components/sidebar.js`: Sidebar toggle logic (~75 lines).
    -   `webroot/js/components/flash.js`: Toast auto-dismiss logic (~24 lines).
    -   `webroot/js/views/Invoices/view.js`: PDF download logic (~32 lines).
    -   `webroot/js/views/Admins/dashboard.js`: FullCalendar, ApexCharts initialization (~280 lines).
    -   `webroot/js/views/Bookings/add.js`: Booking form with Flatpickr, dynamic pricing, add-ons (~265 lines).
    -   `webroot/js/views/Users/auth.js`: Login/register slider toggle (~21 lines).
    -   `webroot/js/components/delete-confirm.js`: Reusable generic delete confirmation with **Capture Phase** event handling (~80 lines).
    -   `webroot/js/views/Cars/form.js`: Image preview and color picker for car forms (~40 lines).
-   Implemented `window.RentifyData` pattern for passing PHP data to external JS files.
-   Created directory structure: `webroot/js/views/Bookings/`, `views/Admins/`, `views/Invoices/`, `components/`.
-   **Consolidated** duplicating inline scripts in `Cars/add.php`, `Cars/edit.php` and `Invoices/view_invoices.php`.
-   **Standardized** Delete Confirmation across `Users`, `Cars`, `Bookings`, `Payments`, and `Invoices` index/edit pages using SweetAlert2.

-   `Users/view.php`: Unique profile card layout, kept as-is.
-   `Invoices/view.php`: Special printable document layout, kept as-is.
-   `Maintenances/view.php`: CakePHP default baked layout, kept as-is.

## [2026-01-01]

### Fixed

-   **Dashboard Chart Booking Count Fix** (`src/Controller/AdminsController.php`)
    -   Changed booking count query to use `start_date` instead of `created` date.
    -   Both metrics now align with the rental activity month.
-   **Premium Design System & Badge Overhaul**
    -   Added **soft-color utilities** (`bg-success-soft`, etc.) to the shared design system for a modern, glassmorphism-inspired look.
    -   Enhanced `StatusHelper` to automatically include **FontAwesome icons** in all status badges (Check-circle, Clock, hourglass, etc.).
    -   Strengthened badge rules in `datatables-custom.css` with **1px borders** and `!important` flags to ensure colors are visible even when overridden by table-cell styles.
    -   Standardized status rendering across `Bookings/view.php` and `index.php` to ensure 100% visual consistency.
    -   Fixed missing badge colors on single-view pages (e.g., `Bookings/view.php`) by implementing internal CSS fallbacks for non-DataTable views.
    -   Removed redundant internal CSS from view templates to lean on the centralized design system.
-   **Enhanced Booking Approval Workflow**
    -   Separated financial confirmation (Payments page) from operational approval (Bookings page).
    -   Added a **Payment** column to `Bookings/index.php` showing real-time invoice status.
    -   Redesigned the "Approve" button to dynamically switch to "Override" (warning style) if payment is pending.
    -   Modified `PaymentsController` to strictly handle financial status, preventing premature booking confirmation.
-   **Styling Standardization & Design System Alignment**
    -   Standardized **action buttons** and **status badges** across Car Categories, Invoices, and Payments.
    -   Refactored `CarCategories/index.php`, `Invoices/index.php`, and `Payments/index.php` to use the shared `datatables-custom.css`.
    -   Updated `StatusHelper` to use high-end `.status-badge` design for all billing statuses.
    -   Centrally managed professional colors for Paid, Unpaid, and Cancelled statuses.
-   **Performance Overview Chart Redesign** (`templates/Admins/dashboard.php`)
    -   Redesigned the main trend chart with a professional "Report" style header.
    -   Added summary stats (Total Revenue, Total Bookings) directly into the chart card.
    -   Enhanced visuals with **12px rounded bars**, gradients, and glowing trend lines.
-   **Professional SweetAlert2 Modals** (`templates/Admins/dashboard.php`)
    -   Replaced native `alert()` browser dialogs with high-end SweetAlert2 modals.
    -   Implemented custom **Glassmorphism** styling for modals to match site theme.
    -   Added colored icons and badges for booking status (Confirmed, Pending, etc.).
    -   Enabled direct navigation to booking details from the calendar modal.
-   **Cash Payment Approval Workflow** (`src/Controller/PaymentsController.php`, `templates/Payments/index.php`)
    -   Implemented a business logic change where **Cash payments** stay `pending` until verified.
    -   Prevented automatic booking confirmation for cash users to ensure financial security.
    -   Added a dedicated **"Confirm Payment"** admin button to manually verify cash receipts.
    -   Manual payment confirmation automatically triggers booking approval and invoice updates.
-   **Footer Updates**
    -   Updated social media links to point to valid URLs (Twitter, Facebook, Instagram).
    -   Updated Twitter icon/label to new "X" branding.
    -   Added GitHub repository link to footer.

### Added

-   **Live Activity Widget** (`templates/Admins/dashboard.php`)
    -   Replaced static "Earnings" sparkline with real-time "Live Activity" chart.
    -   Chart updates every 2 seconds with smooth scrolling animation.
    -   Added pulsing green "LIVE" indicator with CSS animation.
    -   Gives dashboard a premium, dynamic feel.
-   **Hourly Booking Pulse Widget** (`src/Controller/AdminsController.php`, `templates/Admins/dashboard.php`)
    -   Replaced static "Orders" bar chart with a real-time "Hourly Pulse" of the last 24 hours.
    -   Fetches actual database records group by hour to show booking activity peaks.
    -   Enhanced tooltips to show specific hour (e.g., "14:00") and booking count.

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
