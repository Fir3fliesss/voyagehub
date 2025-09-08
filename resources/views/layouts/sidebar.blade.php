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
    }

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
      padding: 1rem 1rem;
      border-top: 1px solid var(--border);
      display: flex; align-items: center; gap: 0.75rem;
    }
    .user-avatar {
      width: 40px; height: 40px;
      margin-right: 0.5rem;
      background: var(--primary);
      border-radius: 50%;
      color: white; display: flex;
      align-items: center; justify-content: center;
      font-weight: 600;
    }
    .user-details h4 { font-size: 0.9rem; margin-bottom: 0.2rem; }
    .user-details p { font-size: 0.75rem; color: #64748b; }

    /* Mobile */
    .mobile-menu-toggle { display: none; font-size: 1.5rem; background: none; border: none; cursor: pointer; }
    .sidebar-overlay {
      display: none;
      position: fixed; inset: 0;
      background: rgba(0,0,0,0.5); z-index: 999;
    }

    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.open { transform: translateX(0); }
      .main-content { margin-left: 0; }
      .mobile-menu-toggle { display: block; }
      .sidebar-overlay.show { display: block; }
      .header-actions {
        flex-direction: column;
        align-items: flex-end;
      }
    }
</style>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-logo">VoyageHub</a>
    </div>
    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item">
                @if(Auth::user()->role == 'admin')
                    <a href="/admin/dashboard" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" data-page="home">
                        <span class="nav-icon">🏠</span>Home
                    </a>
                @else
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" data-page="home">
                        <span class="nav-icon">🏠</span>Home
                    </a>
                @endif
            </li>
            <li class="nav-item">
                @if(Auth::user()->role == 'user')
                    <a href="/new-trip" class="nav-link {{ request()->is('new-trip') ? 'active' : '' }}" data-page="add-data">
                        <span class="nav-icon">➕</span>Add Data
                    </a>
                @endif
            </li>
            @if(Auth::user()->role == 'admin')
            <li class="nav-item">
                <a href="/admin/users" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" data-page="user-management">
                    <span class="nav-icon">👥</span>User Management
                </a>
            </li>
            @endif
            <li class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="cursor: pointer;">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a class="nav-link" href="#">
                    <span class="nav-icon">➡️</span>
                    Logout
                </a>
            </li>
        </ul>
    </nav>
        <div class="sidebar-footer">
        <a href="/settings" class="nav-link {{ request()->is('settings') ? 'active' : '' }}">
            <div class="user-avatar">👤</div>
            <div class="user-details">
                <h4>{{ Auth::user()->name }}</h4>
                <p>NIK: {{ Auth::user()->nik }}</p>
            </div>
        </a>
    </div>
</aside>

<!-- Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    mobileMenuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
      sidebarOverlay.classList.toggle('show');
    });
    sidebarOverlay.addEventListener('click', () => {
      sidebar.classList.remove('open');
      sidebarOverlay.classList.remove('show');
    });
</script>
