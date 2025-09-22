<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
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
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--foreground);
            cursor: pointer;
        }

        /* ====== Card generic (reusable, selaras activity-section) ====== */
.card{
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
  box-shadow: 0 1px 2px rgba(0,0,0,0.04);
}
.card-header{
  padding: 1rem 1.25rem;
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
  background: #f8fafc;
}
.card-body{ padding: 1rem 1.25rem; }

/* ====== Helpers spacing (kompatibel dengan kelas lama) ====== */
.mb-4{ margin-bottom: 1rem; }
.py-3{ padding-top:.75rem; padding-bottom:.75rem; }
.m-0{ margin:0; }
.font-weight-bold{ font-weight: 700; }
.text-primary{ color: var(--primary); }

/* ====== Form (sinkron dengan form styles yg sdh ada) ====== */
.form-row{
  display: grid;
  grid-template-columns: 1fr;
  gap: .75rem;
}
.align-items-end{ align-items: end; }
.col-md-3, .col-md-4, .col-md-5{ width:100%; }
.mb-3{ margin-bottom: .75rem; }
.form-control{
  width:100%;
  padding: 0.65rem 0.9rem;
  border:1px solid var(--border);
  border-radius: var(--radius);
  background: var(--input);
  color: var(--foreground);
  transition: all .2s ease;
}
.form-control:focus{
  outline:none;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(5,150,105,.1);
}

/* grid responsif utk filter bar */
@media (min-width: 768px){
  .form-row{
    grid-template-columns: 1fr 1.6fr .9fr;
  }
}

/* ====== Tabel (reusable) ====== */
.table-responsive{
  width: 100%;
  overflow:auto;
  border:1px solid var(--border);
  border-radius: var(--radius);
}
.table{
  width:100%;
  border-collapse: separate; border-spacing: 0;
  min-width: 640px;
}
.table thead tr{ background: #f1f5f9; }
.table th, .table td{
  padding: .75rem .9rem;
  border-bottom: 1px solid var(--border);
  text-align: left;
}
.table th{
  font-size: .78rem;
  letter-spacing:.04em;
  text-transform: uppercase;
  color: #475569;
  font-weight: 700;
}
.table tbody tr:hover{ background: #f8fafc; }
.table.table-bordered th, .table.table-bordered td{ border-right:1px solid var(--border); }
.table.table-bordered tr th:last-child,
.table.table-bordered tr td:last-child{ border-right:0; }

/* jarak pagination dari tabel */
.table-responsive + *{ margin-top: .9rem; }

/* ====== Header dashboard (rapi) ====== */
.main-header{
  background: var(--card);
}
.page-title{
  letter-spacing: .2px;
}
.mobile-menu-toggle{
  height:40px; width:40px; border-radius: .6rem;
  border: 1px solid var(--border); background: #fff; cursor: pointer;
}
.mobile-menu-toggle:hover{ background:#f1f5f9; }

/* ====== Stats card hover ringan ====== */
.stat-card:hover{
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(0,0,0,0.06);
}
.stat-title{ color: var(--muted-foreground); font-weight: 600; }
.stat-icon{ display:flex; align-items:center; justify-content:center; }
.stat-value{ font-weight: 700; }

        /* Responsive Design */
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

            .mobile-menu-toggle {
                display: block;
            }

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
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="dashboard-container">
        @include('layouts.sidebar')
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <main class="main-content">
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
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
