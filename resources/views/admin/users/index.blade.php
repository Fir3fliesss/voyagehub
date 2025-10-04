@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<<<<<<< HEAD
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">User Management</h1>
    <p class="mb-4">Manage users in the system.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Users</h6>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm float-right">Add New User</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>NIK</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nik }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
=======
<div class="content-area">
    <div class="main-header">
        <h1 class="page-title">User Management</h1>
        <div class="header-actions">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="icon">👤</i>
                Add New User
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <div class="stat-value">{{ $users->total() }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👑</div>
            <div class="stat-content">
                <div class="stat-value">{{ $users->where('role', 'admin')->count() }}</div>
                <div class="stat-label">Administrators</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👤</div>
            <div class="stat-content">
                <div class="stat-value">{{ $users->where('role', 'user')->count() }}</div>
                <div class="stat-label">Regular Users</div>
            </div>
        </div>
    </div>

    <div class="users-table-container">
        <div class="table-header">
            <h3 class="table-title">All Users</h3>
            <div class="table-filters">
                <select id="roleFilter" class="form-select">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>NIK</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Activity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="user-meta">ID: {{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="nik-cell">{{ $user->nik }}</td>
                            <td class="email-cell">{{ $user->email }}</td>
                            <td>
                                <span class="role-badge {{ $user->role }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="date-cell">{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="activity-stats">
                                    <span class="activity-item">{{ $user->journeys()->count() }} trips</span>
                                    <span class="activity-item">{{ $user->travelRequests()->count() }} requests</span>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline" title="View">
                                        👁️
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary" title="Edit">
                                        ✏️
                                    </a>
                                    @if($user->id !== Auth::id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                              style="display: inline;"
                                              onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                🗑️
                                            </button>
                                        </form>
                                    @else
                                        <span class="disabled-action" title="Cannot delete your own account">
                                            🔒
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-icon">👥</div>
                                <div class="empty-message">No users found</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination">
            {{ $users->links() }}
        </div>
>>>>>>> 4b0d94f (feat: implement travel request management system)
    </div>
</div>

<style>
.stats-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: var(--radius);
    padding: 1.5rem;
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    font-size: 2rem;
    flex-shrink: 0;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--foreground);
    margin-bottom: 0.25rem;
}

.stat-label {
    color: var(--muted-foreground);
    font-size: 0.875rem;
}

.users-table-container {
    background: white;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    overflow: hidden;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border);
}

.table-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0;
}

.table-filters {
    display: flex;
    gap: 1rem;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
}

.modern-table th {
    background: var(--card);
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--foreground);
    border-bottom: 1px solid var(--border);
}

.modern-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.user-name {
    font-weight: 600;
    color: var(--foreground);
}

.user-meta {
    font-size: 0.75rem;
    color: var(--muted-foreground);
}

.nik-cell {
    font-family: monospace;
    font-weight: 600;
    color: var(--primary);
}

.email-cell {
    color: var(--muted-foreground);
}

.role-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.role-badge.admin {
    background: #fef3c7;
    color: #92400e;
}

.role-badge.user {
    background: #dbeafe;
    color: #1e40af;
}

.date-cell {
    color: var(--muted-foreground);
    font-size: 0.875rem;
}

.activity-stats {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.activity-item {
    font-size: 0.75rem;
    color: var(--muted-foreground);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.disabled-action {
    padding: 0.25rem 0.5rem;
    color: var(--muted-foreground);
    cursor: not-allowed;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.empty-message {
    color: var(--muted-foreground);
    font-size: 1rem;
}

.table-pagination {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border);
}

.alert {
    padding: 1rem;
    border-radius: var(--radius);
    margin-bottom: 1.5rem;
}

.alert-success {
    background-color: #d1fae5;
    border: 1px solid #a7f3d0;
    color: #065f46;
}

.alert-error {
    background-color: #fee2e2;
    border: 1px solid #fecaca;
    color: #b91c1c;
}

.icon {
    margin-right: 0.5rem;
}

@media (max-width: 768px) {
    .stats-overview {
        grid-template-columns: 1fr;
    }

    .table-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .modern-table {
        font-size: 0.875rem;
    }

    .action-buttons {
        flex-direction: column;
    }
}
</style>

<script>
document.getElementById('roleFilter').addEventListener('change', function() {
    const filter = this.value;
    const rows = document.querySelectorAll('.modern-table tbody tr');

    rows.forEach(row => {
        if (filter === '') {
            row.style.display = '';
        } else {
            const roleCell = row.querySelector('.role-badge');
            if (roleCell && roleCell.textContent.toLowerCase().includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});
</script>
@endsection
