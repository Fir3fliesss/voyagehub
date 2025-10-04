<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>VoyageHub @hasSection('title') - @yield('title') @endif</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
=======
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - VoyageHub @hasSection('title') - @yield('title') @endif</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
>>>>>>> 4b0d94f (feat: implement travel request management system)
    <style>
        :root {
            --background: #ffffff;
            --foreground: #334155;
            --card: #f8fafc;
            --primary: #059669;
            --secondary: #10b981;
            --border: #e2e8f0;
            --radius: 0.75rem;
<<<<<<< HEAD
            --sidebar-width: 260px;
            --input: #ffffff;
            --muted-foreground: #64748b;
=======
            --sidebar-width: 280px;
            --admin-primary: #1e40af;
            --admin-secondary: #3b82f6;
>>>>>>> 4b0d94f (feat: implement travel request management system)
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Open Sans', sans-serif;
            background: var(--background);
            color: var(--foreground);
        }

<<<<<<< HEAD
        .dashboard-container { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--card);
            border-right: 1px solid var(--border);
=======
        .admin-container { display: flex; min-height: 100vh; }

        /* Admin Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
>>>>>>> 4b0d94f (feat: implement travel request management system)
            position: fixed;
            top: 0; left: 0; height: 100vh;
            transition: transform 0.3s ease;
            z-index: 1000;
<<<<<<< HEAD
        }
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-logo {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 1.6rem;
            color: var(--primary);
            text-decoration: none;
        }
        .sidebar-nav { padding: 1rem 0; }
        .nav-item { list-style: none; }
        .nav-link {
            display: flex; align-items: center;
            padding: 1rem 1.5rem;
            color: var(--foreground);
            text-decoration: none;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            background: #f1f5f9;
            border-left-color: var(--primary);
            color: var(--primary);
        }
        .nav-link.active {
            background: var(--primary);
            color: white;
            border-left-color: var(--secondary);
        }
        .nav-icon { margin-right: 0.75rem; }

        .sidebar-footer {
            position: absolute; bottom: 0; left: 0; right: 0;
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border);
            display: flex; align-items: center; gap: 0.75rem;
        }
        .user-avatar {
            width: 40px; height: 40px;
            background: var(--primary);
            border-radius: 50%;
            color: white; display: flex;
            align-items: center; justify-content: center;
            font-weight: 600;
        }
        .user-details h4 { font-size: 0.9rem; margin-bottom: 0.2rem; }
        .user-details p { font-size: 0.75rem; color: #64748b; }

        /* Main */
        .main-content {
            flex: 1; margin-left: var(--sidebar-width);
            display: flex; flex-direction: column;
        }
        .main-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
        }
        .page-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.6rem; font-weight: 700;
        }
        .header-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: var(--radius);
            font-weight: 600; font-size: 0.9rem;
            border: 2px solid transparent;
            cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center; gap: 0.4rem;
            transition: all 0.3s ease;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--secondary); }
        .btn-outline {
            border-color: var(--primary);
            color: var(--primary); background: transparent;
        }
        .btn-outline:hover {
            background: var(--primary); color: white;
        }
        .btn-secondary {
            background: #64748b;
            color: white;
        }
        .btn-secondary:hover {
            background: #475569;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: var(--radius);
            font-weight: 600;
        }

        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }

        .content-area { padding: 1.5rem; flex: 1; }

        .alert-container {
            padding: 1.5rem;
        }

        /* Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem; margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--card);
            padding: 1.25rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
        .stat-header { display: flex; justify-content: space-between; margin-bottom: 0.5rem; }
        .stat-title { font-size: 0.9rem; color: #64748b; }
        .stat-icon {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: var(--primary);
            color: white; display: flex; align-items: center; justify-content: center;
        }
        .stat-value { font-size: 1.6rem; font-weight: 700; margin-bottom: 0.3rem; }
        .stat-change { font-size: 0.8rem; color: var(--secondary); }

        /* Activity */
        .activity-section {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }
        .activity-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex; justify-content: space-between; align-items: center;
        }
        .activity-title { font-weight: 600; font-size: 1.1rem; }
        .activity-list .activity-item {
            padding: 0.9rem 1.25rem;
            display: flex; gap: 0.75rem; align-items: center;
            border-bottom: 1px solid var(--border);
            transition: background 0.2s;
        }
        .activity-item:hover { background: #f1f5f9; }
        .activity-item:last-child { border-bottom: none; }
        .activity-icon {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--secondary); /* Changed from primary to secondary for distinction */
            color: white; display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem;
        }
        .activity-text { font-weight: 500; margin-bottom: 0.2rem; }
        .activity-time { font-size: 0.75rem; color: #64748b; }

        /* Form Styles */
        .form-container {
            background-color: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .form-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 1.4rem;
            color: var(--foreground);
            margin-bottom: 0.5rem;
        }

        .form-description {
            color: var(--muted-foreground);
            font-size: 0.95rem;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--foreground);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-weight: 500;
            color: var(--foreground);
            font-size: 0.9rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background-color: var(--input);
            color: var(--foreground);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
        }

        /* Mobile Menu Toggle */
=======
            color: white;
        }

        .admin-sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .admin-logo {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 1.4rem;
            color: white;
            text-decoration: none;
            display: block;
        }

        .admin-logo-subtitle {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.7);
            margin-top: 0.25rem;
        }

        .admin-nav {
            padding: 1rem 0;
            height: calc(100vh - 180px);
            overflow-y: auto;
        }

        .admin-nav ul { list-style: none; }

        .admin-nav-section {
            margin-bottom: 1.5rem;
        }

        .admin-nav-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .admin-nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: rgba(255,255,255,0.5);
        }

        .admin-nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
            border-left-color: white;
        }

        .admin-nav-icon {
            margin-right: 0.75rem;
            width: 1.25rem;
            text-align: center;
        }

        .admin-sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .admin-user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-user-avatar {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .admin-user-details h4 {
            font-size: 0.9rem;
            margin-bottom: 0.2rem;
        }

        .admin-user-details p {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.7);
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
        }

        .admin-header {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-page-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--foreground);
        }

        .admin-header-actions {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .admin-content {
            padding: 1.5rem;
            flex: 1;
            background: #f8fafc;
        }

        /* Mobile Responsive */
>>>>>>> 4b0d94f (feat: implement travel request management system)
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--foreground);
            cursor: pointer;
        }

<<<<<<< HEAD
        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
=======
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
>>>>>>> 4b0d94f (feat: implement travel request management system)
                margin-left: 0;
            }

            .mobile-menu-toggle {
                display: block;
            }

<<<<<<< HEAD
            .main-header {
                padding: 1rem;
            }

            .content-area {
                padding: 1rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 1.4rem;
            }

            .form-title {
                font-size: 1.2rem;
            }

            .section-title {
                font-size: 1rem;
            }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        @media (max-width: 768px) {
            .sidebar-overlay.show {
                display: block;
            }
=======
            .sidebar-overlay.show {
                display: block;
            }

            .admin-header {
                padding: 1rem;
            }

            .admin-content {
                padding: 1rem;
            }
>>>>>>> 4b0d94f (feat: implement travel request management system)
        }
    </style>
    @stack('styles')
</head>
<body>
<<<<<<< HEAD
    <div class="dashboard-container">
        @include('layouts.sidebar')
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <main class="main-content">
            <div class="alert-container">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
=======
    <div class="admin-container">
        <!-- Admin Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="admin-logo">
                    VoyageHub
                </a>
                <div class="admin-logo-subtitle">Admin Panel</div>
            </div>

            <nav class="admin-nav">
                <div class="admin-nav-section">
                    <div class="admin-nav-section-title">Dashboard</div>
                    <ul>
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                               class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="admin-nav-icon fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="admin-nav-section">
                    <div class="admin-nav-section-title">Management</div>
                    <ul>
                        <li>
                            <a href="{{ route('admin.users.index') }}"
                               class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <i class="admin-nav-icon fas fa-users"></i>
                                Users
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.journeys.index') }}"
                               class="admin-nav-link {{ request()->routeIs('admin.journeys.*') ? 'active' : '' }}">
                                <i class="admin-nav-icon fas fa-route"></i>
                                Journeys
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.travel-requests.index') }}"
                               class="admin-nav-link {{ request()->routeIs('admin.travel-requests.*') ? 'active' : '' }}">
                                <i class="admin-nav-icon fas fa-paper-plane"></i>
                                Travel Requests
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="admin-nav-section">
                    <div class="admin-nav-section-title">Configuration</div>
                    <ul>
                        <li>
                            <a href="{{ route('admin.app-configurations.index') }}"
                               class="admin-nav-link {{ request()->routeIs('admin.app-configurations.*') ? 'active' : '' }}">
                                <i class="admin-nav-icon fas fa-cog"></i>
                                App Settings
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="admin-nav-section">
                    <div class="admin-nav-section-title">Reports</div>
                    <ul>
                        <li>
                            <a href="{{ route('admin.reports.index') }}"
                               class="admin-nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                                <i class="admin-nav-icon fas fa-chart-bar"></i>
                                Analytics & Export
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="admin-sidebar-footer">
                <a href="{{ route('users.index') }}" class="admin-nav-link" style="border: none; padding: 1rem 0;">
                    <div class="admin-user-info">
                        <div class="admin-user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="admin-user-details">
                            <h4>{{ Auth::user()->name }}</h4>
                            <p>{{ ucfirst(Auth::user()->role) }} • NIK: {{ Auth::user()->nik }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </aside>

        <!-- Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <div class="d-flex align-items-center">
                    <button class="mobile-menu-toggle me-3" id="mobileMenuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="admin-page-title">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="admin-header-actions">
                    <!-- Notifications Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm position-relative" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false" id="notificationBell">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                  id="notificationCount" style="display: none;">
                                0
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="width: 350px;">
                            <li class="dropdown-header d-flex justify-content-between align-items-center">
                                <span>Notifications</span>
                                <button class="btn btn-link btn-sm p-0" onclick="markAllAsRead()">Mark all read</button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <div id="notificationsList" style="max-height: 300px; overflow-y: auto;">
                                <li class="dropdown-item text-center py-3">
                                    <i class="fas fa-spinner fa-spin"></i> Loading...
                                </li>
                            </div>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-center" href="{{ route('notifications.index') }}">
                                    View All Notifications
                                </a>
                            </li>
                        </ul>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile menu toggle
        const adminSidebar = document.getElementById('adminSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', () => {
                adminSidebar.classList.toggle('open');
                sidebarOverlay.classList.toggle('show');
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                adminSidebar.classList.remove('open');
                sidebarOverlay.classList.remove('show');
            });
        }

        // Notifications functionality
        function loadNotifications() {
            fetch('/notifications/recent')
                .then(response => response.json())
                .then(notifications => {
                    const notificationsList = document.getElementById('notificationsList');

                    if (notifications.length === 0) {
                        notificationsList.innerHTML = '<li class="dropdown-item text-center text-muted py-3">No notifications</li>';
                        return;
                    }

                    let html = '';
                    notifications.forEach(notification => {
                        const data = notification.data;
                        const isUnread = !notification.read_at;
                        const bgClass = isUnread ? 'bg-light' : '';

                        html += `
                            <li>
                                <a class="dropdown-item ${bgClass}" href="/notifications/${notification.id}/read">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="${data.icon} text-${data.color}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold">${data.title}</div>
                                            <div class="small text-muted">${data.message}</div>
                                            <div class="small text-muted">${notification.created_at}</div>
                                        </div>
                                        ${isUnread ? '<div class="ms-2"><span class="badge bg-primary rounded-pill">&nbsp;</span></div>' : ''}
                                    </div>
                                </a>
                            </li>
                        `;
                    });

                    notificationsList.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    document.getElementById('notificationsList').innerHTML =
                        '<li class="dropdown-item text-center text-danger py-3">Error loading notifications</li>';
                });
        }

        function updateNotificationCount() {
            fetch('/notifications/unread-count')
                .then(response => response.json())
                .then(data => {
                    const countElement = document.getElementById('notificationCount');
                    if (data.count > 0) {
                        countElement.textContent = data.count > 99 ? '99+' : data.count;
                        countElement.style.display = 'inline-block';
                    } else {
                        countElement.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error updating notification count:', error));
        }

        function markAllAsRead() {
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                updateNotificationCount();
                loadNotifications();
            })
            .catch(error => console.error('Error marking notifications as read:', error));
        }

        // Load notifications when dropdown is opened
        document.getElementById('notificationBell').addEventListener('click', function() {
            loadNotifications();
        });

        // Initial load
        document.addEventListener('DOMContentLoaded', function() {
            updateNotificationCount();

            // Update every 30 seconds
            setInterval(updateNotificationCount, 30000);
        });
    </script>
    @stack('scripts')
</body>
</html>
>>>>>>> 4b0d94f (feat: implement travel request management system)
