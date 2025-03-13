```
# Business Loyalty Management Portal

## Table of Contents
- [Overview](#overview)
- [Setup Instructions](#setup-instructions)
- [Seeding the Database](#seeding-the-database)
- [Project Structure](#project-structure)
  - [Authentication System](#authentication-system)
  - [Admin Dashboard](#admin-dashboard)
  - [Customer Management](#customer-management)

---

## Overview
This project is a simplified Business Loyalty Management Portal built using the **TALL stack** (Tailwind CSS, Alpine.js, Laravel, Livewire) with **FilamentPHP** as the admin panel. The system allows business owners to manage customers and loyalty points effectively.



## URL (if using Laravel Herd)
www.crm.test/admin

---

## Setup Instructions
Follow these steps to set up the project locally:

1. **Clone the Repository:**
   ```bash
   git clone <repository-url>
   cd project-folder
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Set Up Environment Variables:**
   ```bash
   cp .env.example .env
   ```
   - Update the `.env` file with database credentials.

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Run Database Migrations:**
   ```bash
   php artisan migrate
   ```

6. **Start the Development Server:**
   ```bash
   npm run dev
   ```

---

## Seeding the Database
To add sample data for testing, run:
```bash
php artisan make:filament-user
php artisan db:seed
```
This will populate the database with default customers and points.

---

## Project Structure

### Authentication System
- Implemented using **Filament authentication**.
- Business owners can register and log in using their email and password.

### Admin Dashboard
- Built with **FilamentPHP**.
- Displays key metrics:
  - **Total number of customers** (card widget)
  - **Total points issued** (stats widget)
  - **Recent point transactions** (table widget)

### Customer Management
- Created a **Filament Resource** for customers.
- Features:
  - List view with **search, filters, and bulk actions**.
  - Form view for **adding/editing customers**.
  - **Relation manager** for point transactions.
  - **Custom actions** for issuing/deducting points.
- Required fields for customers:
  - Name
  - Email
  - Phone
  - **Total Points (computed dynamically)**
- Implemented **point transaction history** using tables.


### Bonus
- Implement export functionality for bulk customer management.

---
### Issues 
- When developing this project, I have problem on the relationship of the point and the customer. Since I already create the table between the 2 of them, i create with the idea of one to many relationship, where 1 customer will have many points. But relation manager are best suited for many to many relationship, especially the attach and detach function on the relation manager. Instead of redo my database structure, I decided to manually create new action for the attach and detach point.

This project showcases proficiency in the **TALL stack** and demonstrates best practices in Laravel, Livewire, and FilamentPHP development.

```