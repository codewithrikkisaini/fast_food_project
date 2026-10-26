<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Foodie Admin') - Restaurant Management System</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5.3 -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}" />

    <style>
        :root {
            --admin-bg: #0b1120;
            --admin-surface: #0f172a;
            --admin-surface-light: #1e293b;
            --admin-border: #334155;
            --admin-primary: #e8281a;
            --admin-primary-gradient: linear-gradient(135deg, #e8281a, #ff6b35);
            --admin-accent: #f59e0b;
            --admin-text-main: #f8fafc;
            --admin-text-muted: #94a3b8;
            --admin-success: #10b981;
            --admin-warning: #f59e0b;
            --admin-danger: #ef4444;
            --admin-info: #06b6d4;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--admin-bg);
            color: var(--admin-text-main);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* SIDEBAR */
        #admin-sidebar {
            width: 270px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--admin-surface);
            border-right: 1px solid var(--admin-border);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(51, 65, 85, 0.6);
            background: linear-gradient(180deg, rgba(232, 40, 26, 0.08) 0%, transparent 100%);
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--admin-primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #fff;
            box-shadow: 0 4px 20px rgba(232, 40, 26, 0.35);
        }

        .brand-text h4 {
            font-size: 1.15rem;
            font-weight: 800;
            color: #fff;
            margin: 0;
            letter-spacing: -0.3px;
        }

        .brand-text h4 span {
            color: var(--admin-accent);
        }

        .brand-text small {
            display: block;
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--admin-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .sidebar-menu {
            padding: 22px 14px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-heading {
            font-size: 0.74rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 700;
            color: #485c7b;
            padding: 24px 16px 10px;
        }

        .nav-item-admin {
            margin-bottom: 7px;
        }

        .nav-link-admin {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 18px;
            color: #8b9cb5;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.98rem;
            transition: all 0.22s ease;
        }

        .nav-link-admin .nav-lead {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .nav-link-admin i {
            width: 22px;
            font-size: 1.05rem;
            text-align: center;
            color: #8b9cb5;
            transition: transform 0.2s ease;
        }

        .nav-link-admin:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(2px);
        }

        .nav-link-admin.active {
            color: #ffffff !important;
            background: linear-gradient(135deg, #ff3c1c 0%, #ea381e 100%);
            box-shadow: 0 4px 18px rgba(234, 56, 30, 0.45);
            font-weight: 700;
        }

        .nav-link-admin.active i {
            color: #ffffff;
        }

        /* Circular white badge with red 'i' for active About item */
        .nav-link-admin.active .nav-icon-badge {
            width: 22px;
            height: 22px;
            background: #ffffff;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
        }

        .nav-link-admin.active .nav-icon-badge i {
            color: #ea381e !important;
            font-size: 0.72rem;
            width: auto;
        }

        .nav-link-admin:not(.active) .nav-icon-badge {
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .nav-link-admin:not(.active) .nav-icon-badge i {
            color: #8b9cb5;
            font-size: 1rem;
        }

        .sidebar-badge {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 22px;
            line-height: 1.4;
        }

        .sidebar-badge-gray {
            background: rgba(255, 255, 255, 0.08);
            color: #94a3b8;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .sidebar-badge-warning {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.35);
        }

        .sidebar-badge-danger {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.35);
        }

        .sidebar-badge-primary {
            background: rgba(232, 40, 26, 0.2);
            color: #ff6b35;
            border: 1px solid rgba(232, 40, 26, 0.35);
        }

        .nav-link-admin.active .sidebar-badge {
            background: #ffffff !important;
            color: #ea381e !important;
            border: none !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
        }

        .sidebar-footer {
            padding: 18px 20px;
            border-top: 1px solid rgba(51, 65, 85, 0.6);
            background: rgba(11, 17, 32, 0.6);
        }

        /* MAIN CONTENT WRAPPER */
        #admin-main {
            margin-left: 270px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        /* TOPBAR */
        #admin-topbar {
            height: 72px;
            background: var(--admin-surface);
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 990;
        }

        .topbar-search {
            position: relative;
            width: 320px;
        }

        .topbar-search input {
            background: var(--admin-surface-light);
            border: 1px solid var(--admin-border);
            border-radius: 10px;
            padding: 8px 14px 8px 36px;
            color: #fff;
            font-size: 0.85rem;
            width: 100%;
        }

        .topbar-search input:focus {
            outline: none;
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(232, 40, 26, 0.15);
        }

        .topbar-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 0.85rem;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-live-site {
            background: rgba(245, 158, 11, 0.12);
            color: var(--admin-accent);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 9px;
            padding: 7px 15px;
            font-size: 0.82rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-live-site:hover {
            background: var(--admin-accent);
            color: #000;
        }

        .admin-profile-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--admin-surface-light);
            padding: 5px 12px 5px 6px;
            border-radius: 30px;
            border: 1px solid var(--admin-border);
        }

        .admin-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--admin-primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 800;
            color: #fff;
        }

        .admin-user-info {
            line-height: 1.2;
        }

        .admin-user-name {
            font-size: 0.82rem;
            font-weight: 700;
            color: #fff;
        }

        .admin-user-role {
            font-size: 0.7rem;
            color: var(--admin-text-muted);
        }

        /* PAGE BODY */
        .admin-page-content {
            padding: 32px;
            flex-grow: 1;
        }

        /* CARDS & SURFACES */
        .admin-card {
            background: var(--admin-surface);
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .admin-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(51, 65, 85, 0.5);
            padding-bottom: 14px;
        }

        .admin-card-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* STATS CARD */
        .stat-card {
            background: var(--admin-surface);
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            padding: 22px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 90px;
            height: 90px;
            background: radial-gradient(circle, rgba(232, 40, 26, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 14px;
        }

        .stat-val {
            font-size: 1.85rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }

        .stat-lbl {
            font-size: 0.82rem;
            color: var(--admin-text-muted);
            font-weight: 500;
        }

        /* TABLE STYLING */
        .table-admin {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-admin th {
            background: var(--admin-surface-light);
            color: var(--admin-text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.6px;
            padding: 12px 16px;
            border: none;
        }

        .table-admin th:first-child {
            border-radius: 10px 0 0 10px;
        }

        .table-admin th:last-child {
            border-radius: 0 10px 10px 0;
        }

        .table-admin td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(51, 65, 85, 0.4);
            color: #e2e8f0;
            font-size: 0.88rem;
            vertical-align: middle;
        }

        .table-admin tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        /* BADGES */
        .badge-pending {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 0.74rem;
            font-weight: 700;
        }

        .badge-confirmed {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 0.74rem;
            font-weight: 700;
        }

        .badge-cancelled {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 0.74rem;
            font-weight: 700;
        }

        /* BUTTONS */
        .btn-admin-primary {
            background: var(--admin-primary-gradient);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 9px 18px;
            font-weight: 700;
            font-size: 0.88rem;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            box-shadow: 0 4px 14px rgba(232, 40, 26, 0.3);
            transition: all 0.2s ease;
        }

        .btn-admin-primary:hover {
            opacity: 0.92;
            color: #fff;
            transform: translateY(-1px);
        }

        /* FORM CONTROLS */
        .form-control-admin {
            background: var(--admin-surface-light);
            border: 1px solid var(--admin-border);
            border-radius: 10px;
            color: #fff;
            padding: 10px 14px;
            font-size: 0.9rem;
        }

        .form-control-admin:focus {
            background: #1e293b;
            color: #fff;
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(232, 40, 26, 0.18);
        }

        .form-label-admin {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--admin-text-muted);
            margin-bottom: 6px;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            #admin-sidebar {
                transform: translateX(-100%);
            }

            #admin-sidebar.show {
                transform: translateX(0);
            }

            #admin-main {
                margin-left: 0;
            }
        }
    </style>
    @stack('admin-styles')
</head>

<body>

    <!-- ========================================================
         SIDEBAR NAVIGATION
         ======================================================== -->
    <aside id="admin-sidebar">
        <!-- BRAND LOGO -->
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="fas fa-utensils"></i>
            </div>
            <div class="brand-text">
                <h4>Foodie<span>Admin</span></h4>
                <small>Restaurant Management</small>
            </div>
        </div>

        @php
            $sidebarStats = app(\App\Services\RestaurantDataService::class)->getStats();
        @endphp
        <!-- MENU ITEMS -->
        <div class="sidebar-menu">
            <!-- DASHBOARD -->
            <div class="nav-item-admin">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link-admin {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <div class="nav-lead"><i class="fas fa-chart-pie"></i> <span>Dashboard</span></div>
                </a>
            </div>

            <!-- HOME -->
            <div class="nav-item-admin">
                <a href="{{ route('admin.home') }}"
                    class="nav-link-admin {{ request()->routeIs('admin.home*') ? 'active' : '' }}">
                    <div class="nav-lead"><i class="fas fa-home"></i> <span>Home</span></div>
                </a>
            </div>

            <!-- 1. ABOUT -->
            <div class="nav-item-admin">
                <a href="{{ route('admin.about') }}"
                    class="nav-link-admin {{ request()->routeIs('admin.about*') ? 'active' : '' }}">
                    <div class="nav-lead">
                        <span class="nav-icon-badge"><i class="fas fa-info"></i></span>
                        <span>About</span>
                    </div>
                </a>
            </div>

            <!-- 2. MENU -->
            <div class="nav-item-admin">
                <a href="{{ route('admin.menu') }}"
                    class="nav-link-admin {{ request()->routeIs('admin.menu*') ? 'active' : '' }}">
                    <div class="nav-lead">
                        <i class="fas fa-hamburger"></i>
                        <span>Menu</span>
                    </div>
                    <span class="sidebar-badge sidebar-badge-gray">{{ $sidebarStats['total_menu_items'] ?? 0 }}</span>
                </a>
            </div>

            <!-- 3. CHEFS -->
            <div class="nav-item-admin">
                <a href="{{ route('admin.chefs') }}"
                    class="nav-link-admin {{ (request()->routeIs('admin.chefs*') || request()->routeIs('admin.chef*')) ? 'active' : '' }}">
                    <div class="nav-lead">
                        <i class="fas fa-user-tie"></i>
                        <span>Chefs</span>
                    </div>
                    <span class="sidebar-badge sidebar-badge-gray">{{ $sidebarStats['total_chefs'] ?? 0 }}</span>
                </a>
            </div>

            <!-- 4. GALLERY -->
            <div class="nav-item-admin">
                <a href="{{ route('admin.gallery') }}"
                    class="nav-link-admin {{ request()->routeIs('admin.gallery*') ? 'active' : '' }}">
                    <div class="nav-lead">
                        <i class="fas fa-images"></i>
                        <span>Gallery</span>
                    </div>
                </a>
            </div>

            <!-- 5. BLOG -->
            <div class="nav-item-admin">
                <a href="{{ route('admin.blog') }}"
                    class="nav-link-admin {{ request()->routeIs('admin.blog*') ? 'active' : '' }}">
                    <div class="nav-lead">
                        <i class="fas fa-newspaper"></i>
                        <span>Blog Stories</span>
                    </div>
                    <span class="sidebar-badge sidebar-badge-gray">{{ $sidebarStats['total_blogs'] ?? 0 }}</span>
                </a>
            </div>

            <!-- OPERATIONS & INQUIRIES -->
            <div class="sidebar-heading">OPERATIONS &amp; INQUIRIES</div>

            <!-- 5. RESERVATIONS -->
            <div class="nav-item-admin">
                <a href="{{ route('admin.reservations') }}"
                    class="nav-link-admin {{ request()->routeIs('admin.reservations*') ? 'active' : '' }}">
                    <div class="nav-lead">
                        <i class="fas fa-calendar-check"></i>
                        <span>Reservations</span>
                    </div>
                    <span class="sidebar-badge {{ ($sidebarStats['pending_reservations'] ?? 0) > 0 ? 'sidebar-badge-warning' : 'sidebar-badge-gray' }}" title="{{ ($sidebarStats['pending_reservations'] ?? 0) }} Pending">
                        {{ $sidebarStats['total_reservations'] ?? 0 }}
                    </span>
                </a>
            </div>

            <!-- 6. REVIEWS -->
            <div class="nav-item-admin">
                <a href="{{ route('admin.reviews') }}"
                    class="nav-link-admin {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                    <div class="nav-lead">
                        <i class="fas fa-star"></i>
                        <span>Reviews</span>
                    </div>
                    <span class="sidebar-badge sidebar-badge-primary">
                        {{ $sidebarStats['total_reviews'] ?? 0 }}
                    </span>
                </a>
            </div>

            <!-- 7. CONTACT INQUIRIES -->
            <div class="nav-item-admin">
                <a href="{{ route('admin.contact') }}"
                    class="nav-link-admin {{ request()->routeIs('admin.contact*') ? 'active' : '' }}">
                    <div class="nav-lead">
                        <i class="fas fa-envelope"></i>
                        <span>Contact Msgs</span>
                    </div>
                    <span class="sidebar-badge {{ ($sidebarStats['unread_contacts'] ?? 0) > 0 ? 'sidebar-badge-danger' : 'sidebar-badge-gray' }}" title="{{ ($sidebarStats['unread_contacts'] ?? 0) }} Unread">
                        {{ $sidebarStats['total_contacts'] ?? 0 }}
                    </span>
                </a>
            </div>
        </div>

        <!-- SIDEBAR FOOTER -->
        <div class="sidebar-footer">
            <a href="{{ route('home') }}" target="_blank"
                class="btn btn-outline-light w-100 btn-sm d-flex align-items-center justify-content-center gap-2 rounded-3">
                <i class="fas fa-external-link-alt"></i> View Live Website
            </a>
        </div>
    </aside>

    <!-- ========================================================
         MAIN APP CONTAINER
         ======================================================== -->
    <div id="admin-main">
        <!-- TOPBAR -->
        <header id="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-dark d-lg-none p-2 rounded-2"
                    onclick="document.getElementById('admin-sidebar').classList.toggle('show')">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-search d-none d-md-block">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search orders, dishes, guests..." />
                </div>
            </div>

            <div class="topbar-actions">
                <a href="{{ route('home') }}" target="_blank" class="btn-live-site">
                    <i class="fas fa-store"></i> Live Restaurant Front
                </a>

                <div class="admin-profile-pill">
                    <div class="admin-avatar">FA</div>
                    <div class="admin-user-info d-none d-sm-block">
                        <div class="admin-user-name">Foodie Admin</div>
                        <div class="admin-user-role">Super Manager</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- FLASH NOTIFICATIONS -->
        @if(session('success'))
            <div class="px-4 pt-3">
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert"
                    style="background:#064e3b;border:1px solid #10b981;color:#a7f3d0;border-radius:12px;">
                    <i class="fas fa-check-circle fa-lg me-3 text-success"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="px-4 pt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert"
                    style="background:#450a0a;border:1px solid #ef4444;color:#fecaca;border-radius:12px;">
                    <strong class="d-flex align-items-center mb-1"><i class="fas fa-exclamation-triangle me-2"></i>Please
                        resolve the following:</strong>
                    <ul class="mb-0 ps-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        <!-- PAGE BODY CONTENT -->
        <main class="admin-page-content">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    @stack('admin-scripts')
</body>

</html>