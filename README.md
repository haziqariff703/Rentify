# 🚗 Rentify: Car Rental Management System

**Program:** Bachelor of Information Science (Hons.) Information System Management (CDIM262)  
**Course:** Information Systems Development (IMS566)  
**Student Name:** Haziq Ariff, Amirul Rasyid, Zulfadli, Safa Raziq

**Framework:** CakePHP 4.x / 5.x

---

## 📖 Project Description

**Rentify** is a web-based Car Rental Management System designed to digitalize and automate the manual vehicle booking process. The system addresses common operational inefficiencies such as double-booking, manual invoicing errors, and unorganized fleet management.

Targeting two distinct user groups—**Customers** and **Administrators**—Rentify provides a seamless platform for checking vehicle real-time availability, processing automated reservations, and managing financial records (Invoices/Payments) dynamically. The core objective is to demonstrate a robust **System Development Life Cycle (SDLC)** with a focus on data integrity, relational database design, and user experience (UX).

---

## ⚙️ System Logic & Workflow (The "Business Rules")

The system operates on strict logic controls to ensure data accuracy. The following workflows are hard-coded into the `BookingsController` and `PaymentsController`:

### 1. The Booking Engine Logic

-   **Date Validation:** The system prevents logical errors by enforcing `End_Date > Start_Date`. If a user selects an invalid return date, the booking is blocked.
-   **Overlap Prevention:** Before saving a booking, the system queries the `bookings` table for the selected `car_id`. If an existing _Confirmed_ booking overlaps with the requested dates, the system returns an "Unavailable" error.
-   **Price Automation:** The system automatically calculates the Total Price: `(End Date - Start Date) * Price Per Day`.

### 2. The Auto-Invoice Logic

-   **Trigger:** Immediately upon a successful booking (Status: _Pending_).
-   **Action:** The system generates a unique record in the `invoices` table.
-   **Status:** The invoice defaults to **'Unpaid'**. This ensures that a financial debt record exists even if the user abandons the payment process.

### 3. The Payment Logic (Simulated)

-   **Process:** The user inputs dummy credit card details via the Payment Simulation module.
-   **Success Scenario:**
    1.  **Creates** a new record in the `payments` table.
    2.  **Updates** the linked `invoices` status to **'PAID'**.
    3.  **Updates** the linked `bookings` status to **'CONFIRMED'**.
    4.  **Unlocks** the "Download PDF Receipt" feature for the user.
-   **Failure Scenario:**
    -   No data is changed. The Invoice remains 'Unpaid', and the Booking remains 'Pending'.

---

## 🗄️ Database Architecture (ERD)

The system utilizes a **9-Table Relational Structure** optimized for data normalization (3NF).

### Core Entities

-   **`users`**: Stores customer authentication data.
-   **`admins`**: Separate authentication table for staff/managers to ensure role separation.
-   **`cars`**: The main inventory table containing vehicle specs, status, and image paths.
-   **`car_categories`**: Categorizes vehicles (e.g., SUV, Economy).
    -   _Relationship:_ **One-to-Many** (One Category has Many Cars). Allows efficient filtering/searching.

### Transaction Entities

-   **`bookings`**: The central hub linking Users and Cars.
    -   _Relationship:_ **One-to-Many** (One User can have multiple Bookings).
-   **`invoices`**: The official billing document.
    -   _Relationship:_ **One-to-One** (Structurally linked to one specific Booking ID).
-   **`payments`**: Records of financial transactions.
    -   _Relationship:_ **One-to-Many** (One Booking can technically have multiple partial payments, though simulated as one-off here).

### Support Entities

-   **`maintenances`**: Tracks vehicle repairs.
    -   _Logic:_ Cars listed here with 'Active' status are excluded from search results.
-   **`reviews`**: Stores user feedback.
    -   _Relationship:_ Links User ID + Car ID to ensure only actual customers can review.

---

## 🛠️ Tech Stack & Libraries

To achieve "Excellent" functionality and UX marks, the following libraries are integrated:

| Library          | Purpose                                                   | Rubric Requirement Met                     |
| :--------------- | :-------------------------------------------------------- | :----------------------------------------- |
| **CakePdf**      | Converts Invoice Views to downloadable PDF files.         | _Export to PDF (for at least one dataset)_ |
| **Bootstrap 5**  | Provides a responsive, mobile-ready Grid layout.          | _User Interface Design / Responsive_       |
| **SweetAlert2**  | Replaces default browser alerts with professional popups. | _User Interface... Clear, intuitive_       |
| **FullCalendar** | Visualizes booking schedules on the dashboard.            | _Advanced Features_                        |
| **FakerPHP**     | Generates realistic test data for presentation.           | _System Functionality_                     |
| **Toastr**       | Non-blocking "Success/Error" notifications.               | _User Experience (UX)_                     |

---

## 🚀 Installation & Setup

1.  **Database Configuration:**

    -   Create a database named `rentify`.
    -   Import the `rentify_final_master.sql` script.
    -   Update `config/app_local.php` with your DB credentials.

2.  **Installation:**

    ```bash
    composer install
    ```

3.  **Generating Code (Bake):**

    ```bash
    bin/cake bake all users
    bin/cake bake all cars
    bin/cake bake all bookings
    bin/cake bake all invoices
    bin/cake bake all payments
    bin/cake bake all car_categories
    bin/cake bake all reviews
    bin/cake bake all maintenances
    bin/cake bake all admins
    ```

4.  **Running the Server:**
    ```bash
    bin/cake server
    ```
    Access the system at: `http://localhost:8765`

---

## 👥 User Roles & Features

### Customer (User)

-   **Sign Up/Login:** Secure account creation.
-   **Search & Filter:** Find cars by Category or Price range.
-   **Book Vehicle:** Select dates and view automated total price.
-   **My Dashboard:** View booking history and payment status.
-   **Payment Simulation:** Process dummy payments.
-   **Download Invoice:** Export official receipts as PDF.

### Administrator (Admin)

-   **Dashboard:** View total sales and monthly booking stats.
-   **Fleet Management:** Add/Edit/Delete cars and upload images.
-   **Booking Management:** Approve pending bookings or mark cars as returned.
-   **User Oversight:** Manage customer accounts and moderate reviews.

---

_This project is submitted in partial fulfillment of the requirements for the course IMS566._
