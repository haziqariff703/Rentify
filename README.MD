<div align="center">

# RENTIFY

**Drive Your Rental Experience Forward, Effortlessly**

[![Status](https://img.shields.io/badge/Status-Active-brightgreen)]()
[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue)]()
[![Framework](https://img.shields.io/badge/Framework-CakePHP%205.x-red)]()
[![License](https://img.shields.io/badge/License-MIT-orange)]()

_Built with the tools and technologies:_

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![CakePHP](https://img.shields.io/badge/CakePHP-D33C43?style=for-the-badge&logo=cakephp&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![FontAwesome](https://img.shields.io/badge/FontAwesome-337ab7?style=for-the-badge&logo=fontawesome&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![DataTables](https://img.shields.io/badge/DataTables-000000?style=for-the-badge&logo=datatable&logoColor=white)

</div>

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Getting Started](#-getting-started)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
    - [Usage](#usage)
- [Features & System Logic](#-features--system-logic)
    - [Auto-Expire Invoices (New)](#auto-expire-invoices-new)
    - [Booking Engine](#booking-engine)
- [Database & Seeders](#-database--seeders)
    - [Squashed Migrations](#squashed-migrations)
    - [Faker Seeding System](#faker-seeding-system)
- [Testing](#-testing)
    - [Stress Testing](#stress-testing)

---

## 🌟 Overview

**Rentify** is a premium web-based Car Rental Management System designed to modernize vehicle booking operations. It eliminates manual errors, prevents double-bookings, and provides a glassmorphism-inspired administrative interface for high-efficiency fleet management.

Developed as part of the **IMS566** course, it demonstrates a complete implementation of the SDLC, featuring robust relational data integrity and modern UX practices.

---

## 🚀 Getting Started

### Prerequisites

- **PHP 8.1+** (8.2/8.3 recommended)
- **Composer** (PHP dependency manager)
- **Laragon/XAMPP** (Local server environment with MySQL)

### Installation

Build Rentify from source and install dependencies:

1. **Clone the repository:**
    ```bash
    git clone https://github.com/haziqariff703/rentify
    ```
2. **Setup Environment:**
    - Copy `config/app_local.example.php` to `config/app_local.php`.
    - Update the `Datasources` array with your database host, username, and password.
3. **Install Dependencies:**
    ```bash
    composer install
    ```

### Usage

Run the project using CakePHP's built-in server:

```bash
bin/cake server
```

Access the application at: `http://localhost:8765`

---

## 💡 Features & System Logic

### 📊 Intelligence Admin Dashboard

A high-density "Command Center" for administrators:

- **Financial KPIs**: Real-time tracking of Total Revenue, Revenue Growth (MoM), and Booking Volume.
- **Fleet Analytics**: Donut charts visualizing car availability and maintenance distribution.
- **Performance Pulse**: Hourly booking trends over the last 24 hours to identify peak rental times.
- **Action Center**: Inline approval system for pending bookings and maintenance alerts.

### 🛡️ Smart Fleet Protection

- **Maintenance Integration**: Automatically hides cars from the booking engine when "Scheduled Maintenance" is active.
- **Health Sync**: Completing maintenance automatically restores a car to "Available" status across the platform.

### ⚡ Auto-Expire Invoices (New)

The system now includes an automated lifecycle manager for unpaid bookings:

- **Past-Due Logic**: Whenever a user views their invoices, the system checks for "Unpaid" invoices where the `booking.start_date` has passed.
- **Automatic Voiding**: Marks expired items as **Cancelled**, preventing users from seeing "Pay Now" for rental periods that have already started.

### 🚗 Professional Booking Engine

- **Overlap Prevention**: Multi-check ORM logic ensures no car can be double-booked for the same time span.
- **Service Add-ons**: Toggleable options for GPS, Chauffeur, and Full Insurance, with costs calculated dynamically based on car category policies.
- **Automatic Invoicing**: One-to-one invoice generation immediately upon booking creation.

### 📄 Document Export System

- **Tax-Compliant Invoices**: Generates professional PDF receipts with itemized breakdowns of rental cost, add-ons, and 6% SST.
- **Digital Receipting**: Powered by **CakePdf**, allowing users to download official documentation for their records.

### 🔐 Multi-Tier Authorization

- **RBAC (Role-Based Access Control)**: Strictly separated portals for Admins and Customers.
- **Ownership Verification**: Customers are locked to viewing only their own bookings, invoices, and payments through high-level authorization policy checks.

---

## 🗄️ Database & Seeders

### Squashed Migrations

The project uses a **Clean Baseline** migration strategy. All previous incremental migrations have been consolidated into a single "Initial Schema".

- **Location**: `config/Migrations/20260111030154_InitialSchema.php`
- **To Setup**: `bin/cake migrations migrate`

### Faker Seeding System

We utilize a sophisticated seeding system based on **FakerPHP** to generate realistic Malaysian data (IC numbers, phone numbers, state-specific addresses).

- **Production Setup** (Admin Only):
    ```bash
    bin/cake migrations seed --seed AdminsSeed
    ```
- **Demo Setup** (Full Data):
    ```bash
    bin/cake migrations seed --seed DatabaseSeeder
    ```

---

## 🧪 Testing

### Stress Testing

Manual and semi-automated stress tests are conducted using the **"Human Swarm"** method and **Postman Collection Runner**.

- **Human Swarm**: Simulating concurrent logins and bookings across multiple browser tabs.
- **Postman Runner**: Iterative GET requests to critical endpoints (`/cars/my-cars`, `/bookings`) to test retrieval speeds under load.

---

<div align="center">
  <sub>Submitted as partial fulfillment of IMS566 requirements. Created by: Haziq, Rasyid, Zulfadli, Safa.</sub>
</div>
