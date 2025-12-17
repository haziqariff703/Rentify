# 📄 Rentify System: Page & View Requirements

**Total Estimated Views:** ~17 Pages  
**Development Strategy:** Hybrid (Custom Design + Auto-Generated Baking)

---

## 1. Custom Design Views (High Effort)

These pages require manual coding (`HTML/CSS/PHP`) to ensure a high-quality User Experience (UX). They are critical for scoring marks on interface design and system flow.

| View Name              | Controller Action    | Audience | Purpose & Features                                                                |
| :--------------------- | :------------------- | :------- | :-------------------------------------------------------------------------------- |
| **Landing Page**       | `Pages/home`         | Public   | Welcome banner, "About Us", and "Featured Cars" grid.                             |
| **Car Catalog**        | `Cars/index`         | Public   | Main search page. Needs **Search Bar** and **Filter Dropdowns** (Category/Price). |
| **Car Details**        | `Cars/view/{id}`     | Public   | Detailed specs, image gallery, reviews list, and the **"Book Now"** button.       |
| **Booking Form**       | `Bookings/add`       | User     | Date selection inputs with **Auto-Price Calculation** logic.                      |
| **Payment Simulation** | `Payments/add`       | User     | Dummy credit card form. Redirects to success/failure based on logic.              |
| **The Invoice**        | `Invoices/view/{id}` | User     | HTML receipt styled like a real paper bill. **Must convert to PDF**.              |
| **Admin Dashboard**    | `Admins/dashboard`\* | Admin    | Overview page with **Charts** (Chart.js) and summary statistics cards.            |

_Note: `AdminsController` here is a custom controller for the dashboard logic, not a database table._

---

## 2. Auto-Generated Views (Low Effort - "Bake")

These pages are standard "CRUD" (Create, Read, Update, Delete) interfaces. You will use the `bin/cake bake` command to generate them instantly, then simply apply Bootstrap classes for styling.

### 👤 User Management Pages

| View Name       | Controller Action | Purpose                                                       |
| :-------------- | :---------------- | :------------------------------------------------------------ |
| **Login**       | `Users/login`     | Standard email/password form.                                 |
| **Sign Up**     | `Users/add`       | Registration form (Name, Email, **IC Number**).               |
| **My Profile**  | `Users/view/{id}` | View profile details.                                         |
| **My Bookings** | `Bookings/index`  | Table showing the user's personal booking history and status. |

### 🛠️ Admin Management Pages (RBAC Protected)

| View Name             | Controller Action        | Purpose                                           |
| :-------------------- | :----------------------- | :------------------------------------------------ |
| **Manage Cars**       | `Cars/index` (Admin)     | Data table to list all fleet vehicles.            |
| **Add Car**           | `Cars/add`               | Form to upload car images and set `category_id`.  |
| **Manage Categories** | `CarCategories/index`    | Add/Edit types of cars (SUV, MPV).                |
| **Manage Bookings**   | `Bookings/index` (Admin) | Master list to approve/reject reservations.       |
| **Manage Users**      | `Users/index`            | List of registered customers (Filtered by Role).  |
| **Manage Reviews**    | `Reviews/index`          | Moderation list to delete inappropriate comments. |
| **Maintenance Log**   | `Maintenances/index`     | Track repair costs and schedule dates.            |

---

## 3. Development Priority List

**Week 1:**

1.  Run `bin/cake bake` for all 8 tables to create the "Auto-Generated" pages.
2.  **Member D:** Set up the **Login/Sign Up** logic. Ensure the `role` column defaults to 'customer'.

**Week 2:**

1.  **Member A:** Design the **Landing Page** and **Car Catalog**.
2.  **Member B:** Build the **Booking Form** logic.
3.  **Member C:** Set up the **Car Categories** so cars can be added properly.

**Week 3:**

1.  **Member B:** Build the **Payment Simulation** page.
2.  **Member A:** Design the **Invoice View** and connect the PDF engine.
3.  **Member D:** Implement the `category_id` fix in `CarsTable.php`.

**Week 4:**

1.  **Member C:** Build the **Admin Dashboard** with Charts.
2.  **Member D:** Run Stress Tests (Invalid IC numbers, Overlapping dates).
