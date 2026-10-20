<div align="center">

# 🍔 Fast Food & Restaurant Management System

**A modern, feature-rich, full-stack Restaurant Web Portal and Foodie Admin Dashboard built with Laravel & Bootstrap 5.**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%20%7C%208.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![Vite](https://img.shields.io/badge/Vite-Bundler-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![License: MIT](https://img.shields.io/badge/License-MIT-success.svg?style=for-the-badge)](LICENSE)

[Explore Frontend](http://localhost:8000) • [Admin Dashboard](http://localhost:8000/admin/dashboard) • [Report Bug](https://github.com/codewithrikkisaini/fast_food_project/issues) • [Request Feature](https://github.com/codewithrikkisaini/fast_food_project/issues)

</div>

---

## 📌 Table of Contents

- [Overview](#-overview)
- [Key Features](#-key-features)
  - [Frontend Customer Portal](#1-frontend-customer-portal)
  - [Foodie Admin Dashboard](#2-foodie-admin-dashboard)
- [Technology Stack](#-technology-stack)
- [System Architecture](#-system-architecture)
- [Project Directory Structure](#-project-directory-structure)
- [Installation & Quick Start](#-installation--quick-start)
- [Application Routes](#-application-routes)
- [Live Preview & Highlights](#-live-preview--highlights)
- [Author & Credits](#-author--credits)
- [License](#-license)

---

## 🚀 Overview

**Fast Food Project** is an all-in-one culinary web solution designed for fast-food restaurants, cafes, and gourmet eateries. It bridges the gap between hungry food lovers and restaurant management through:

1. **A Customer-Facing Web Experience:** An interactive, responsive, animated website allowing customers to browse dishes, check live promotional deals, make online table reservations, submit customer reviews, read food blogs, and contact the restaurant.
2. **A Foodie Admin Management System:** An intuitive control room to manage the restaurant's entire online presence without touching any code — update menu items, upload hero images, moderate customer reviews, manage incoming reservations with instant status workflows, and track customer inquiries.

---

## ✨ Key Features

### 1. Frontend Customer Portal

| Feature | Description |
| :--- | :--- |
| 🏠 **Dynamic Home Page** | Eye-catching hero banner, promotional deal counters, featured dishes, and quick navigation. |
| 📋 **Interactive Food Menu** | Filter dishes by categories (Burgers, Pizza, Chicken, Wraps, Desserts, Pasta) with pricing, old price strikethroughs, calorie tags, and cooking preparation time. |
| 📅 **Table Reservation System** | Online booking form taking guest count, date, time slots, and special requests with real-time feedback. |
| ⭐ **Customer Reviews & Feedback** | Interactive customer review submission with star ratings (1 to 5 stars) and dynamic testimonial carousel. |
| 👨‍🍳 **Master Chefs Showcase** | Meet the culinary team with experience badges, specialties, and bios. |
| 🖼️ **Food & Restaurant Gallery** | Filterable gallery with responsive lightbox popup powered by Magnific Popup. |
| 📰 **Food Blog & Recipes** | Highlighting healthy fast food trends, chef masterclasses, and cooking secrets with detailed single-post views. |
| 🛒 **Cart & Checkout Preview** | Clean cart layout displaying order items, pricing summary, and order flow. |
| 📞 **Contact Us & Inquiry Form** | Direct visitor inquiry form, interactive contact details, opening hours, and location. |

---

### 2. Foodie Admin Dashboard

| Module | Capabilities |
| :--- | :--- |
| 📊 **Admin Dashboard** | Real-time overview of menu counts, total bookings, pending reservations, confirmed tables, unread inquiries, and revenue metrics. |
| 🖼️ **Home Page Content Manager** | Change hero titles, highlights, descriptions, promotional announcements, and **upload custom banner & deal images directly**. |
| 📖 **About Page Editor** | Update restaurant heritage story, milestone stats, and core quality value cards. |
| 🍔 **Menu Management (CRUD)** | Add new menu items, upload images, set badges (*Hot*, *New*, *Chef's Pick*), define calories, tags, and delete items. |
| 👨‍🍳 **Chefs Management** | Add and manage culinary team members, roles, experience, and photo uploads. |
| 📸 **Gallery Management** | Add new culinary photos, captions, and categorize them for the public gallery. |
| 🛎️ **Reservations Management** | View all customer table bookings, toggle status (**Pending / Confirmed / Cancelled**), and remove outdated records. |
| 💬 **Reviews Moderation** | Review customer ratings and feedback, approve or delete testimonials before they appear live. |
| ✉️ **Contact Inquiries** | Read messages sent via contact form, mark as read, or delete resolved inquiries. |

---

## 🛠️ Technology Stack

### Backend
- **Framework:** [Laravel 12.x](https://laravel.com)
- **Language:** PHP 8.2+ / 8.3+
- **Architecture:** Model-View-Controller (MVC) + Dedicated Service Layer (`RestaurantDataService`)
- **Data Persistence:** High-Performance JSON Data Store (`storage/app/restaurant_data.json`) with Laravel Eloquent Migration readiness.

### Frontend
- **Templating:** Blade Template Engine
- **CSS Framework:** [Bootstrap 5.3](https://getbootstrap.com) + Custom Responsive Stylesheets (`style.css`)
- **Iconography:** FontAwesome 6 (Solid, Brands, Duotone, Light) & Icomoon Webfonts
- **JavaScript Libraries:**
  - **jQuery 3.7.1**: Core DOM manipulation and AJAX support
  - **Swiper.js**: Touch-enabled modern carousels and sliders
  - **AOS (Animate On Scroll)**: Smooth scroll-triggered visual animations
  - **Magnific Popup**: Responsive lightbox for food gallery & media

### Build & Tooling
- **Bundler:** Vite
- **Package Managers:** Composer & NPM

---

<!-- ## 🏗️ System Architecture

```mermaid
graph TD
    User([Customer / Visitor]) -->|Browses & Books| WebRoutes[routes/web.php]
    Admin([Restaurant Manager]) -->|Manages Content & Bookings| WebRoutes
    
    subgraph "Controllers Layer"
        WebRoutes -->|Public Requests| FrontendCtrl[FrontendController.php]
        WebRoutes -->|Admin /admin/*| AdminCtrl[AdminController.php]
    end
    
    subgraph "Service Layer"
        FrontendCtrl --> Service[RestaurantDataService.php]
        AdminCtrl --> Service
    end
    
    subgraph "Storage & Data"
        Service --> JSONStore[(restaurant_data.json)]
        AdminCtrl --> Uploads[public/img/uploads/]
    end
    
    subgraph "Presentation Layer"
        FrontendCtrl --> FrontendViews[Blade Views: resources/views/frontend/]
        AdminCtrl --> AdminViews[Blade Views: resources/views/admin/]
    end
``` -->

---

## 📁 Project Directory Structure

```text
fast-food/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AdminController.php         # Foodie Admin dashboard & CRUD logic
│   │       ├── Controller.php              # Base controller
│   │       └── FrontendController.php     # Public visitor routes & form handlers
│   └── Services/
│       └── RestaurantDataService.php       # Centralized business logic & data operations
├── config/                                 # Laravel configurations
├── database/                               # Migrations, seeders, factories
├── public/                                 # Web root
│   ├── css/                                # Bootstrap, AOS, Swiper, Magnific & Custom CSS
│   ├── img/                                # Food images, chefs, banners, category icons
│   │   └── uploads/                        # Dynamic admin uploads
│   ├── js/                                 # Swiper, AOS, Magnific Popup, main.js
│   └── webfonts/                           # FontAwesome & Icomoon fonts
├── resources/
│   ├── css/                                # Base stylesheet
│   ├── js/                                 # App scripts
│   └── views/
│       ├── admin/                          # Foodie Admin Blade Templates
│       │   ├── about.blade.php
│       │   ├── chefs.blade.php
│       │   ├── contact.blade.php
│       │   ├── dashboard.blade.php
│       │   ├── gallery.blade.php
│       │   ├── home.blade.php
│       │   ├── menu.blade.php
│       │   ├── reservations.blade.php
│       │   ├── reviews.blade.php
│       │   └── layouts/app.blade.php
│       └── frontend/                       # Public Customer Blade Templates
│           ├── about.blade.php
│           ├── blog.blade.php
│           ├── blog-detail.blade.php
│           ├── cart.blade.php
│           ├── chefs.blade.php
│           ├── contact.blade.php
│           ├── gallery.blade.php
│           ├── home.blade.php
│           ├── menu.blade.php
│           ├── reservation.blade.php
│           ├── reviews.blade.php
│           └── layouts/app.blade.php
├── routes/
│   ├── console.php
│   └── web.php                             # All frontend & admin route definitions
├── storage/
│   └── app/restaurant_data.json            # Centralized restaurant database store
├── composer.json                           # PHP dependencies
├── package.json                            # Node.js dependencies
└── README.md                               # Project documentation
```

---

## 💻 Installation & Quick Start

Follow these straightforward steps to set up the project locally:

### 1. Clone the Repository
```bash
git clone git@github.com:codewithrikkisaini/fast_food_project.git
cd fast_food_project
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Frontend dependencies
npm install
```

### 3. Environment Configuration
```bash
# Duplicate example environment file
cp .env.example .env

# Generate application security key
php artisan key:generate
```

### 4. Create Storage Symlink & Cache Setup
```bash
php artisan storage:link
```

### 5. Start Development Server
Run the Laravel local development server:
```bash
php artisan serve
```

Now open your favorite browser and visit:
- **Public Customer Portal:** `http://127.0.0.1:8000`
- **Foodie Admin Panel:** `http://127.0.0.1:8000/admin/dashboard`

---

## 🛣️ Application Routes

### Frontend Routes
| Method | Endpoint | Controller Action | Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/` | `FrontendController@home` | Restaurant Home page |
| `GET` | `/about` | `FrontendController@about` | Our Story & Highlights |
| `GET` | `/menu` | `FrontendController@menu` | Food Menu & Categories |
| `GET` | `/chefs` | `FrontendController@chefs` | Master Chefs Team |
| `GET` | `/gallery` | `FrontendController@gallery` | Food & Atmosphere Gallery |
| `GET` | `/reservation` | `FrontendController@reservation` | Table Booking View |
| `POST` | `/reservation` | `FrontendController@storeReservation` | Process Table Booking |
| `GET` | `/reviews` | `FrontendController@reviews` | Customer Testimonials |
| `POST` | `/reviews` | `FrontendController@storeReview` | Submit Customer Review |
| `GET` | `/blog` | `FrontendController@blog` | Articles & Recipes |
| `GET` | `/blog/{id}` | `FrontendController@blogDetail` | Single Article View |
| `GET` | `/contact` | `FrontendController@contact` | Contact Page |
| `POST` | `/contact` | `FrontendController@storeContact` | Submit Visitor Message |
| `GET` | `/cart` | `FrontendController@cart` | Cart & Checkout Summary |

### Admin Routes (`/admin/*`)
| Method | Endpoint | Controller Action | Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/admin/dashboard` | `AdminController@dashboard` | Admin Metrics & Overview |
| `GET` | `/admin/home` | `AdminController@home` | Hero Section & Deal Editor |
| `POST` | `/admin/home` | `AdminController@updateHome` | Save Home settings & uploads |
| `GET` | `/admin/about` | `AdminController@about` | About page content manager |
| `POST` | `/admin/about` | `AdminController@updateAbout` | Save About content |
| `GET` | `/admin/menu` | `AdminController@menu` | Menu Items Management |
| `POST` | `/admin/menu/store` | `AdminController@storeMenuItem` | Create / Edit Menu Dish |
| `POST` | `/admin/menu/delete/{id}` | `AdminController@deleteMenuItem` | Delete Menu Dish |
| `GET` | `/admin/chefs` | `AdminController@chefs` | Chefs Management |
| `POST` | `/admin/chefs/store` | `AdminController@storeChef` | Add / Update Chef |
| `POST` | `/admin/chefs/delete/{id}` | `AdminController@deleteChef` | Delete Chef Profile |
| `GET` | `/admin/gallery` | `AdminController@gallery` | Gallery Management |
| `POST` | `/admin/gallery/store` | `AdminController@storeGalleryItem` | Add Gallery Item |
| `POST` | `/admin/gallery/delete/{id}` | `AdminController@deleteGalleryItem` | Delete Gallery Item |
| `GET` | `/admin/reservations` | `AdminController@reservations` | Table Bookings List |
| `POST` | `/admin/reservations/status/{id}` | `AdminController@updateReservationStatus` | Update Status (Confirmed / Cancelled) |
| `POST` | `/admin/reservations/delete/{id}` | `AdminController@deleteReservation` | Delete Reservation |
| `GET` | `/admin/reviews` | `AdminController@reviews` | Review Moderation List |
| `POST` | `/admin/reviews/status/{id}` | `AdminController@updateReviewStatus` | Approve / Unapprove Review |
| `POST` | `/admin/reviews/delete/{id}` | `AdminController@deleteReview` | Delete Review |
| `GET` | `/admin/contact` | `AdminController@contact` | Customer Inquiry Messages |
| `POST` | `/admin/contact/read/{id}` | `AdminController@markContactRead` | Mark message as read |
| `POST` | `/admin/contact/delete/{id}` | `AdminController@deleteContact` | Delete Inquiry |

---

## 👨‍💻 Author & Credits

Developed with ❤️ by **[Code With Rikki Saini](https://github.com/codewithrikkisaini)**

- **GitHub:** [@codewithrikkisaini](https://github.com/codewithrikkisaini)
- **Repository:** [fast_food_project](https://github.com/codewithrikkisaini/fast_food_project)

---

## 📄 License

This project is open-sourced under the **[MIT License](LICENSE)**. Feel free to use, modify, and build upon it!

<div align="center">
⭐ If you find this project helpful or inspirational, please consider giving it a star on GitHub! ⭐
</div>
