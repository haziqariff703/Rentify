# 🚀 Rentify Team Developer Handbook

**Project:** Car Rental Management System (IMS566)  
**Framework:** CakePHP 4.x / 5.x  
**Objective:** Deliver a "High Distinction" system in 5 weeks.

---

## 📋 1. Team Roles & Responsibilities

To ensure we finish on time, we are splitting the system into 4 distinct domains. **Stick to your domain** to avoid "Merge Conflicts" (where two people edit the same file and break the code).

| Member       | Role                        | Domain Focus                   | Primary Responsibility                                            |
| :----------- | :-------------------------- | :----------------------------- | :---------------------------------------------------------------- |
| **Member A** | **Frontend & UX Designer**  | **Views (The "Look")**         | Making the Landing Page, Catalog, and Receipts look professional. |
| **Member B** | **Business Logic Engineer** | **Transactions (The "Money")** | Booking calculations, Payment simulation, and PDF generation.     |
| **Member C** | **Admin Operations**        | **Management (The "Staff")**   | Building the Admin Dashboard, Charts, and all CRUD tables.        |
| **Member D** | **System Integrator**       | **Security & Core Logic**      | Authentication, Search Engine, Image Uploads, and Stress Testing. |

---

## 🛠️ 2. The Golden Rules (Read Before Coding)

1.  **Never push to `main`:** Always create a new branch for your task (e.g., `git checkout -b feature/search-bar`).
2.  **Bake First:** Don't write code from scratch if you don't have to. Use `bin/cake bake` to generate the skeleton.
3.  **One Controller Per Person:** Try not to edit the same Controller at the same time.
    - Member A works on `PagesController`.
    - Member B works on `BookingsController`.
    - Member C works on `AdminsController`.
    - Member D works on `AppController`.

---

## 👨‍💻 3. Detailed Member Workflows

### 🎨 Member A: Frontend & UX Specialist

**Goal:** Ensure the system hits the rubric points for "User Interface... Clear, intuitive".

- **Required Libraries:**

  - **Bootstrap 5:** (CSS) For the grid layout.
  - **FontAwesome:** (Icons) For buttons (e.g., 🗑️ Trash, ✏️ Edit).
  - **Toastr:** (JS) For smooth "Success" notifications.
  - **Lightbox2:** (JS) For viewing car images.

- **Key Tasks:**
  1.  **Landing Page (`Pages/home`):** Design a Hero Banner and "Featured Cars" section.
  2.  **Car Catalog (`Cars/index`):** Create the Search Bar HTML and Filter Dropdowns. Use a "Grid Card" layout for cars (not a table).
  3.  **Car Details (`Cars/view`):** Display specs (seats, transmission) using Icons. Add the "Book Now" button.
  4.  **Invoice View (`Invoices/view`):** Design the HTML invoice to look like a real paper receipt (Clean tables, Logo on top).

---

### 💵 Member B: Business Logic Engineer

**Goal:** Handle the complex "System Workflow" (Bookings -> Invoices -> Payments).

- **Required Libraries:**

  - **CakePdf:** (PHP) To convert Member A's HTML invoice into a PDF download.
  - **Flatpickr:** (JS) For the Date Selection calendar (block past dates).

- **Key Tasks:**
  1.  **Booking Logic (`BookingsController`):**
      - Calculate `Total Price = (End - Start) * Price`.
      - Validate that `End Date > Start Date`.
  2.  **Auto-Invoice Logic:**
      - When a booking is saved, **automatically** create a row in the `invoices` table with status 'Unpaid'.
  3.  **Payment Simulation (`PaymentsController`):**
      - Create the "Dummy Credit Card" form.
      - Write logic: If Payment = Success, update Invoice to 'Paid' and Booking to 'Confirmed'.

---

### 📊 Member C: Admin Operations Specialist

**Goal:** Build the backend interface for the company staff.

- **Required Libraries:**

  - **Chart.js:** (JS) To show "Monthly Sales" graphs on the dashboard.
  - **DataTables:** (jQuery) To add Search/Sort/Pagination to admin tables automatically.

- **Key Tasks:**
  1.  **Baking:** You are responsible for running `bin/cake bake all [table]` for every table in the database.
  2.  **Admin Dashboard (`Admins/dashboard`):** Show "Total Bookings", "Pending Reviews", and the Chart.js graph.
  3.  **Management Tables:** Clean up the baked "Index" pages (Cars, Users, Bookings). Add the DataTables plugin to them.
  4.  **Status Management:** Add buttons to the Booking list so Admins can click "Approve" or "Reject".

---

### 🛡️ Member D: Security & Integrator

**Goal:** The "Safety Net." Ensure the system is secure, searchable, and crash-proof.

- **Required Libraries:**

  - **Authentication:** (CakePHP Plugin) For Login/Logout security.
  - **Intervention Image:** (PHP) To resize uploaded car photos.
  - **FakerPHP:** (PHP) To generate 50+ test users for the presentation.

- **Key Tasks:**
  1.  **Security (`AppController`):** Configure the Login logic. **Crucial:** Block non-admins from accessing `/admin` pages.
  2.  **Search Logic (`CarsController`):** Write the backend query that powers Member A's search bar.
      - _Logic:_ `WHERE car_model LIKE %keyword% OR brand LIKE %keyword%`.
  3.  **Upload Logic:** Write the function to handle file uploads when Member C adds a new car. (Rename file -> Move to folder -> Save path to DB).
  4.  **Stress Test:** In Week 4, try to break the system (bad inputs) and fix the validation rules.

---

## 📅 4. The 5-Week Coordinated Schedule

| Week  | Member A (Views)                     | Member B (Logic)                     | Member C (Admin)                    | Member D (Core)                        |
| :---- | :----------------------------------- | :----------------------------------- | :---------------------------------- | :------------------------------------- |
| **1** | Design **Landing Page** & Navbar.    | Setup **CakePdf** engine.            | **Bake** all tables. Setup DB.      | Install **Authentication**.            |
| **2** | Build **Car Catalog** (Grid View).   | Build **Booking Form** (Date logic). | Build **Manage Cars** (Add/Edit).   | Write **Upload Logic** (for Member C). |
| **3** | Design **Invoice** HTML layout.      | Build **Payment Simulation**.        | Build **Admin Dashboard** (Charts). | Write **Search Logic** (for Member A). |
| **4** | Style all forms with **Bootstrap**.  | Connect **Auto-Invoice** trigger.    | Add **DataTables** to lists.        | **Stress Test** & Validation.          |
| **5** | **Final UI Polish** (Toastr, Icons). | **PDF Export** Testing.              | **Presentation** Rehearsal.         | **Seed Data** (FakerPHP).              |

---

## ❓ 5. Troubleshooting (Who to ask?)

- **"My CSS looks ugly!"** -> Ask **Member A**.
- **"The Total Price is wrong!"** -> Ask **Member B**.
- **"I can't add a new car!"** -> Ask **Member C**.
- **"I can't login!"** or **"Database Error!"** -> Ask **Member D**.
