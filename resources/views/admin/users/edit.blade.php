@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<<<<<<< HEAD
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit User</h1>
    <p class="mb-4">Edit the user details below.</p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="nik">NIK:</label>
                    <input type="text" class="form-control" id="nik" name="nik" value="{{ $user->nik }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
=======
<div class="content-area">
    <div class="main-header">
        <h1 class="page-title">Edit User</h1>
        <div class="header-actions">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                <i class="icon">←</i>
                Back to Users
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <div class="user-avatar-large">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <h2 class="form-title">Edit User: {{ $user->name }}</h2>
                <p class="form-subtitle">Update user information and settings</p>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="user-form">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h3 class="section-title">Basic Information</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-input @error('name') error @enderror"
                                value="{{ old('name', $user->name) }}"
                                placeholder="Enter full name"
                                required
                            >
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nik" class="form-label">NIK (Employee ID) <span class="required">*</span></label>
                            <input
                                type="number"
                                id="nik"
                                name="nik"
                                class="form-input @error('nik') error @enderror"
                                value="{{ old('nik', $user->nik) }}"
                                placeholder="Enter employee NIK"
                                required
                            >
                            @error('nik')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="email" class="form-label">Email Address <span class="required">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input @error('email') error @enderror"
                                value="{{ old('email', $user->email) }}"
                                placeholder="user@company.com"
                                required
                            >
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role" class="form-label">Role <span class="required">*</span></label>
                            <select
                                id="role"
                                name="role"
                                class="form-select @error('role') error @enderror"
                                required
                            >
                                <option value="">Select Role</option>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">Security (Optional)</h3>
                    <p class="section-description">Leave password fields empty to keep current password</p>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="password" class="form-label">New Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input @error('password') error @enderror"
                                placeholder="Enter new password (min. 6 characters)"
                            >
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-input"
                                placeholder="Confirm new password"
                            >
                        </div>
                    </div>
                </div>

                <div class="user-stats">
                    <h3 class="section-title">User Statistics</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value">{{ $user->journeys()->count() }}</div>
                            <div class="stat-label">Total Trips</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $user->travelRequests()->count() }}</div>
                            <div class="stat-label">Travel Requests</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $user->created_at->format('M Y') }}</div>
                            <div class="stat-label">Member Since</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $user->updated_at->diffForHumans() }}</div>
                            <div class="stat-label">Last Updated</div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="history.back()" class="btn btn-outline">
                        Cancel
                    </button>
                    @if($user->id !== Auth::id())
                        <button type="button" onclick="deleteUser()" class="btn btn-danger">
                            <i class="icon">🗑️</i>
                            Delete User
                        </button>
                    @endif
                    <button type="submit" class="btn btn-primary">
                        <i class="icon">✓</i>
                        Update User
                    </button>
                </div>
            </form>
        </div>
>>>>>>> 4b0d94f (feat: implement travel request management system)
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirm Delete</h3>
            <button type="button" onclick="closeDeleteModal()" class="close-btn">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete user <strong>{{ $user->name }}</strong>?</p>
            <p class="warning-text">This action cannot be undone and will also delete all associated data.</p>
        </div>
        <div class="modal-actions">
            <button type="button" onclick="closeDeleteModal()" class="btn btn-outline">Cancel</button>
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete User</button>
            </form>
        </div>
    </div>
</div>

<style>
.form-container {
    max-width: 800px;
    margin: 0 auto;
}

.form-card {
    background: white;
    border-radius: var(--radius);
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid var(--border);
}

.form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.user-avatar-large {
    width: 100px;
    height: 100px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: bold;
    margin: 0 auto 1rem;
}

.form-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0 0 0.5rem;
}

.form-subtitle {
    color: var(--muted-foreground);
    margin: 0;
}

.form-section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0 0 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--border);
}

.section-description {
    color: var(--muted-foreground);
    font-size: 0.875rem;
    margin-bottom: 1rem;
    font-style: italic;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-weight: 500;
    color: var(--foreground);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.required {
    color: #ef4444;
}

.form-input,
.form-select {
    padding: 0.75rem;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    font-size: 0.875rem;
    transition: all 0.2s;
    background: var(--input);
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.2);
}

.form-input.error,
.form-select.error {
    border-color: #ef4444;
}

.error-message {
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.user-stats {
    background: var(--card);
    padding: 1.5rem;
    border-radius: var(--radius);
    margin-bottom: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: bold;
    color: var(--primary);
    margin-bottom: 0.25rem;
}

.stat-label {
    color: var(--muted-foreground);
    font-size: 0.75rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 2rem;
    border-top: 1px solid var(--border);
}

.btn-danger {
    background-color: #ef4444;
    color: white;
    border: 1px solid #ef4444;
}

.btn-danger:hover {
    background-color: #dc2626;
    border-color: #dc2626;
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

.alert ul {
    margin: 0.5rem 0 0 1rem;
}

.alert li {
    margin-bottom: 0.25rem;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal-content {
    background: white;
    margin: 10% auto;
    padding: 2rem;
    border-radius: var(--radius);
    max-width: 500px;
    position: relative;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.close-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--muted-foreground);
}

.warning-text {
    color: #ef4444;
    font-size: 0.875rem;
}

.modal-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 1.5rem;
}

.icon {
    margin-right: 0.5rem;
}

@media (max-width: 768px) {
    .form-grid,
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .form-card {
        padding: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .form-actions .btn {
        justify-content: center;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<script>
function deleteUser() {
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
</script>
@endsection
