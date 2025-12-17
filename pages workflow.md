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
| **Admin Dashboard**    | `Admins/dashboard`   | Admin    | Overview page with **Charts** (Chart.js) and summary statistics cards.            |

---

## 2. Auto-Generated Views (Low Effort - "Bake")

These pages are standard "CRUD" (Create, Read, Update, Delete) interfaces. You will use the `bin/cake bake` command to generate them instantly, then simply apply Bootstrap classes for styling.

### 👤 User Management Pages

| View Name       | Controller Action | Purpose                                                       |
| :-------------- | :---------------- | :------------------------------------------------------------ |
| **Login**       | `Users/login`     | Standard username/password form.                              |
| **Sign Up**     | `Users/add`       | Registration form.                                            |
| **My Profile**  | `Users/edit/{id}` | Form to update address or phone number.                       |
| **My Bookings** | `Bookings/index`  | Table showing the user's personal booking history and status. |

### 🛠️ Admin Management Pages

| View Name           | Controller Action        | Purpose                                           |
| :------------------ | :----------------------- | :------------------------------------------------ |
| **Manage Cars**     | `Cars/index` (Admin)     | Data table to list all fleet vehicles.            |
| **Add Car**         | `Cars/add`               | Form to upload car images and set specs.          |
| **Edit Car**        | `Cars/edit/{id}`         | Form to update car details.                       |
| **Manage Bookings** | `Bookings/index` (Admin) | Master list to approve/reject reservations.       |
| **Manage Users**    | `Users/index`            | List of registered customers.                     |
| **Manage Reviews**  | `Reviews/index`          | Moderation list to delete inappropriate comments. |
| **Manage Invoices** | `Invoices/index`         | List to track unpaid debts.                       |

---

## 3. Development Priority List

**Week 1:**

1.  Run `bin/cake bake` for all tables to create the "Auto-Generated" pages.
2.  Set up the **Login/Sign Up** pages immediately to handle access control.

**Week 2:**

1.  Design the **Landing Page** and **Car Catalog** (Make them look good).
2.  Build the **Booking Form** logic.

**Week 3:**

1.  Build the **Payment Simulation** page.
2.  Design the **Invoice View** and connect the PDF engine.

**Week 4:**

1.  Build the **Admin Dashboard** with Charts.
