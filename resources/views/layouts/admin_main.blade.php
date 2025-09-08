<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoyageHub @hasSection('title') - @yield('title') @endif</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
    <style>
        :root {
            --background: #ffffff;
            --foreground: #334155;
            --card: #f8fafc;
            --primary: #059669;
            --secondary: #10b981;
            --border: #e2e8f0;
            --radius: 0.75rem;
            --sidebar-width: 260px;
            --input: #ffffff;
            --muted-foreground: #64748b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Open Sans', sans-serif;
            background: var(--background);
            color: var(--foreground);
        }

        .dashboard-container { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--card);
            border-right: 1px solid var(--border);
            position: fixed;
            top: 0; left: 0; height: 100vh;
            transition: transform 0.3s ease;
            z-index: 1000;
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
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,0,0,0.08); }H
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
            width: 38px; height: 38px;
            border-radius: 50%;
            background: #e0f2f7;
            color: #007bff;
            display: flex; align-items: center; justify-content: center;
        }
        .activity-details {
            flex: 1;
            font-size: 0.9rem;
        }
        .activity-details span {
            font-weight: 600;
        }
        .activity-time {
            font-size: 0.8rem;
            color: #64748b;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--input);
            color: var(--foreground);
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }
        .form-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }
        .data-table th,
        .data-table td {
            padding: 0.9rem 1.2rem;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }
        .data-table th {
            background: var(--card);
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--muted-foreground);
            text-transform: uppercase;
        }
        .data-table tbody tr:last-child td {
            border-bottom: none;
        }
        .data-table tbody tr:hover {
            background: #f1f5f9;
        }
        .action-buttons .btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }
        .pagination a,
        .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            border-radius: var(--radius);
            text-decoration: none;
            color: var(--foreground);
            border: 1px solid var(--border);
            transition: all 0.2s;
        }
        .pagination a:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        .pagination .active span {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        .pagination .disabled span {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .main-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            .header-actions {
                width: 100%;
                justify-content: flex-end;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .alert-container {
            padding: 1.5rem;
            padding-bottom: 0;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="dashboard-container">
        @include('layouts.sidebar')

        <div class="main-content">
            <div class="main-header">
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>

            </div>

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

            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.querySelector('.sidebar');

        if (mobileMenuToggle && sidebar) {
            mobileMenuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>