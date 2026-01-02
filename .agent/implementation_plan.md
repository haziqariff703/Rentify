# Final Polish Implementation Plan

This plan covers the remaining improvements before assignment submission.

---

## Phase 1: Security Audit (Priority: HIGH)

### 1.1 Authorization Check Review

Verify all controllers enforce proper access control.

| Controller               | Action                    | Expected Check   | Status                 |
| ------------------------ | ------------------------- | ---------------- | ---------------------- |
| `AdminsController`       | All actions               | `requireAdmin()` | ✅ Already enforced    |
| `BookingsController`     | `index`                   | Admin only       | ✅ Redirects non-admin |
| `BookingsController`     | `view`                    | Owner OR Admin   | ⚠️ Verify              |
| `BookingsController`     | `edit`, `delete`          | Admin only       | ⚠️ Verify              |
| `PaymentsController`     | `index`, `edit`, `delete` | Admin only       | ⚠️ Verify              |
| `PaymentsController`     | `confirmCashPayment`      | Admin only       | ⚠️ Verify              |
| `UsersController`        | `index`, `edit`, `delete` | Admin only       | ⚠️ Verify              |
| `CarsController`         | `add`, `edit`, `delete`   | Admin only       | ⚠️ Verify              |
| `InvoicesController`     | `index`                   | Admin only       | ⚠️ Verify              |
| `MaintenancesController` | All CRUD                  | Admin only       | ⚠️ Verify              |

### 1.2 Form Protection Verification

-   [x] `BookingsController` - Dynamic fields unlocked
-   [x] `PaymentsController` - Dynamic fields unlocked
-   [ ] Verify all forms use `$this->Form->create()` (not raw HTML forms)

### 1.3 Input Validation

-   [ ] Check all entities have proper validation rules
-   [ ] Verify `h()` helper is used in templates for output escaping

---

## Phase 2: Code Cleanup (Priority: MEDIUM)

### 2.1 Remove Unused Imports

Scan controllers for unused `use` statements.

**Files to check:**

-   `src/Controller/BookingsController.php` - Has `use Cake\I18n\FrozenDate;` (may be unused now)
-   `src/Controller/AdminsController.php`
-   `src/Controller/PaymentsController.php`
-   `src/Controller/UsersController.php`

### 2.2 Type Hints

Add return type hints to controller methods where missing.

```php
// Before
public function index()

// After
public function index(): void
```

### 2.3 Clean Up Comments

-   Remove `// ---` style divider comments
-   Replace with proper PHPDoc if needed

---

## Phase 3: Error Handling (Priority: LOW)

### 3.1 Add Try-Catch to Critical Operations

```php
// Example for payment processing
try {
    // Payment logic
} catch (\Exception $e) {
    $this->log('Payment error: ' . $e->getMessage(), 'error');
    $this->Flash->error(__('Payment processing failed. Please try again.'));
}
```

**Target actions:**

-   `PaymentsController::add()`
-   `BookingService::createBooking()`
-   `BookingService::cancelBooking()`

---

## Phase 4: Final Testing Checklist

### Customer Flow

-   [ ] Register new account
-   [ ] Browse cars
-   [ ] Create a booking
-   [ ] View invoice
-   [ ] Make a payment
-   [ ] Cancel a booking (before start date)
-   [ ] View booking history
-   [ ] Leave a review

### Admin Flow

-   [ ] Login as admin
-   [ ] View dashboard with stats
-   [ ] Filter dashboard by date range
-   [ ] Approve a pending booking
-   [ ] Reject a pending booking
-   [ ] Confirm a cash payment
-   [ ] Add a new car
-   [ ] Edit a car
-   [ ] Schedule maintenance
-   [ ] View all users
-   [ ] View all invoices

---

## Execution Order

1. **Security Audit** - Check authorization in all controllers
2. **Code Cleanup** - Remove unused imports, add type hints
3. **Error Handling** - Add try-catch where needed
4. **Final Testing** - Manual walkthrough of all flows

---

## Files to Modify

| File                                        | Changes                              |
| ------------------------------------------- | ------------------------------------ |
| `src/Controller/BookingsController.php`     | Remove unused import, add type hints |
| `src/Controller/PaymentsController.php`     | Verify auth, add type hints          |
| `src/Controller/UsersController.php`        | Verify auth                          |
| `src/Controller/CarsController.php`         | Verify auth                          |
| `src/Controller/InvoicesController.php`     | Verify auth                          |
| `src/Controller/MaintenancesController.php` | Verify auth                          |
| `src/Controller/ReviewsController.php`      | Verify auth                          |
| `src/Service/BookingService.php`            | Add try-catch to critical methods    |
