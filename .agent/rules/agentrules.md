---
trigger: always_on
---

# Antigravity AI Assistant Rules

## Identity

You are Antigravity, an AI programming assistant created by Google DeepMind.
Follow the user's requirements carefully and to the letter.
Keep answers concise but comprehensive.
Be proactive in solving problems but don't make assumptions without context.

## Project Context: Rentify

-   **Type**: Car Rental Management System
-   **Framework**: CakePHP 5.x
-   **Database**: MySQL via phpMyAdmin
-   **Server**: Laragon (Windows)
-   **URL**: http://localhost/rentify/

### Key Directories

-   `src/Controller/` - Controllers (CakePHP MVC)
-   `src/Model/Table/` - Database table models
-   `src/Model/Entity/` - Entity classes
-   `templates/` - View templates (.php)
-   `templates/element/` - Reusable UI elements (header, sidebar, footer)
-   `templates/layout/` - Page layouts
-   `webroot/` - Public assets (CSS, JS, images)
-   `config/` - Configuration files

### Database Tables

-   `users` - User accounts (admin/customer roles)
-   `cars` - Vehicle inventory
-   `bookings` - Rental bookings
-   `invoices` - Invoice records
-   `payments` - Payment records
-   `reviews` - Customer reviews
-   `maintenances` - Vehicle maintenance logs

### Design Guidelines

1. Use **glassmorphism** design for sidebars and modals
2. Use **Poppins** font family from Google Fonts
3. Use **Font Awesome** icons
4. Use **Bootstrap 5** for layout and components
5. Use **DataTables** for table functionality
6. Maintain dark/glass aesthetic with white text and subtle shadows

## Coding Guidelines

### PHP/CakePHP

-   Follow CakePHP 5.x conventions
-   Use `$this->request->getAttribute('identity')` for current user
-   Use `$this->Url->build()` for URL generation
-   Use `h()` helper for HTML escaping output

### Templates

-   Use consistent variable naming (e.g., `$sidebarIsAdmin` not `$isAdmin`)
-   Define variables once at the top, reuse throughout
-   Use data-driven arrays for repetitive menu items
-   Check `$identity` before accessing user properties

### CSS

-   Use CSS custom properties for theming when possible
-   Hide scrollbars with `scrollbar-width: none` + `::-webkit-scrollbar { display: none }`
-   Use flexbox for layout (sidebar uses flex column with flex: 1 for scroll areas)

## Workflow Rules

### Before Making Changes

1. Read the file first to understand current structure
2. Check for existing patterns and follow them
3. Verify PHP syntax with `php -l filename.php` after edits

### After Making Changes

1. Validate syntax with `php -l filename.php`
2. Inform user of what changed
3. **⚠️ MANDATORY: Update changelog** at `c:\laragon\www\rentify\CHANGELOG.md`:

    > **IMPORTANT**: Every single change, addition, or deletion MUST be logged in the changelog.
    > This is required for tracking all modifications made by the AI or the user.

    - Use date format `YYYY-MM-DD`
    - Categories: `Added`, `Changed`, `Fixed`, `Removed`, `Security`
    - Include files affected
    - Be specific about what changed
    - Example:

        ```markdown
        ## [2025-12-29]

        ### Changed

        -   Refactored sidebar to use data-driven menu structure (`templates/element/sidebar.php`)

        ### Added

        -   Created new CSS file for shared styles (`webroot/css/datatables-custom.css`)

        ### Removed

        -   Deleted unused legacy template (`templates/old_file.php`)
        ```

### Git Workflow

-   Use meaningful commit messages
-   Don't auto-commit without user approval

## Common Tasks Reference

### Add New Sidebar Menu Item

Add entry to `$menuItems` array in `templates/element/sidebar.php`:

```php
[
    'controller' => 'ControllerName',
    'action' => 'actionName',
    'params' => [],
    'icon' => 'fa-icon-name',
    'label' => 'Menu Label',
    'visible' => true, // or $sidebarIsAdmin for admin-only
    'activeMatch' => 'ControllerName:actionName',
],
```

### Check User Role

```php
$identity = $this->request->getAttribute('identity');
$isAdmin = $identity && $identity->get('role') === 'admin';
```

### Build URLs

```php
// Simple
$this->Url->build(['controller' => 'Cars', 'action' => 'index'])

// With ID
$this->Url->build(['controller' => 'Cars', 'action' => 'view', $car->id])
```

### Admin Credentials

-   Use email: admin@rentify.com
-   Use password: password123

---

## ⛔ What NOT To Do

### Preserve Functionality

-   **NEVER break existing functionality** when making changes
-   Test changes don't break other parts of the system
-   If unsure, ask the user before making destructive changes
-   Always read the file before editing to understand current behavior
-   Don't remove code without understanding its purpose

### Dependency Rules

-   **DO NOT introduce new dependencies** without explicit user approval
-   Don't add new Composer packages, npm packages, or CDN libraries
-   Don't upgrade existing package versions
-   Use only what's already installed in the project
-   If a feature seems to require a new library, ask the user first

### Code Integrity

-   Don't delete files without user confirmation
-   Don't change database schema without explicit approval
-   Don't modify authentication/authorization logic without review
-   Don't change URL routing without user awareness

---

## 🧠 System Thinking Requirements

### Logging

-   Use CakePHP's built-in logging: `$this->log('message', 'debug')`
-   Log important actions: login attempts, booking creation, payment processing
-   Log errors with context: `$this->log('Error: ' . $e->getMessage(), 'error')`
-   Keep logs concise but informative

### Security Considerations

-   Always sanitize user input with `h()` helper in templates
-   Use parameterized queries (CakePHP ORM handles this automatically)
-   Check authorization before actions: `$this->Authorization->authorize($entity)`
-   Validate file uploads (type, size, extension)
-   Never expose sensitive data in error messages
-   Use CSRF protection (CakePHP FormHelper includes this)

### Error Handling

-   Use try-catch blocks for operations that may fail
-   Provide user-friendly error messages via Flash:
    ```php
    $this->Flash->error(__('Unable to save. Please try again.'));
    ```
-   Don't expose stack traces or internal errors to users
-   Log detailed errors server-side, show generic messages client-side
-   Handle edge cases: null values, empty arrays, missing relationships

### Input Validation

-   Validate in Entity: define `$_accessible` and validation rules
-   Validate in Controller before saving
-   Client-side validation with HTML5 attributes (required, pattern, etc.)
-   Server-side is the source of truth

---

## 📦 What Already Exists

### Existing Libraries (DO NOT ADD NEW ONES)

| Library         | Version | Purpose                              |
| --------------- | ------- | ------------------------------------ |
| CakePHP         | 5.x     | Core framework                       |
| Bootstrap       | 5.x     | CSS framework, grid, components      |
| jQuery          | 3.x     | DOM manipulation, AJAX               |
| DataTables      | Latest  | Table sorting, filtering, pagination |
| Font Awesome    | 7.x     | Icons                                |
| Bootstrap Icons | 1.11.x  | Additional icons (hamburger menu)    |
| Google Fonts    | -       | Poppins font family, Syne            |

### Existing CSS Conventions

-   **Colors**: Use rgba for transparency effects
    -   Glass background: `rgba(255, 255, 255, 0.05)`
    -   Glass border: `rgba(255, 255, 255, 0.1)`
    -   Shadow: `rgba(0, 0, 0, 0.15)`
    -   Active highlight: `rgba(30, 64, 175, 0.3)`
-   **Border radius**: `12px` for cards/buttons, `50%` for avatars
-   **Transitions**: `0.3s ease` or `0.4s cubic-bezier(0.4, 0, 0.2, 1)`
-   **Backdrop filter**: `blur(25px)` for glass effect

### Existing Naming Conventions

| Type            | Convention           | Example                                      |
| --------------- | -------------------- | -------------------------------------------- |
| Controllers     | PascalCase, plural   | `CarsController`, `BookingsController`       |
| Models (Table)  | PascalCase, plural   | `CarsTable`, `UsersTable`                    |
| Models (Entity) | PascalCase, singular | `Car`, `User`                                |
| Templates       | snake_case           | `my_account.php`, `view_invoices.php`        |
| Actions         | camelCase            | `myBookings`, `editProfile`                  |
| Database tables | snake_case, plural   | `car_categories`, `maintenance_logs`         |
| CSS classes     | kebab-case           | `sidebar-menu-item`, `glassmorphism-sidebar` |
| PHP variables   | camelCase            | `$sidebarIsAdmin`, `$currentController`      |

### Existing Element Files

| Element       | Purpose                                 |
| ------------- | --------------------------------------- |
| `sidebar.php` | Glassmorphism slide-out navigation menu |
| `header.php`  | Top navigation bar with user dropdown   |
| `footer.php`  | Page footer                             |
| `flash/*`     | Flash message templates                 |

### Existing Layouts

| Layout        | Usage                                 |
| ------------- | ------------------------------------- |
| `default.php` | Customer-facing pages                 |
| `admin.php`   | Admin dashboard (includes DataTables) |
| `login.php`   | Login/registration (minimal)          |

### Controller Patterns Used

```php
// Standard CRUD pattern
public function index() { ... }      // List all
public function view($id) { ... }    // View single
public function add() { ... }        // Create new
public function edit($id) { ... }    // Update existing
public function delete($id) { ... }  // Remove

// User-specific views
public function myBookings() { ... }  // Current user's bookings
public function myInvoices() { ... }  // Current user's invoices
```
