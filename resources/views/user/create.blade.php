@extends('layouts.main')

@section('title', 'Create New User')

@section('content')
<div class="content-area">
    <div class="main-header">
        <h1 class="page-title">Create New User</h1>
        <div class="header-actions">
            <a href="{{ route('users.index') }}" class="btn btn-outline">
                <i class="icon">←</i>
                Back to Profile
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
                <h2 class="form-title">User Information</h2>
                <p class="form-subtitle">Fill in the details for the new user account</p>
            </div>

            <form action="{{ route('users.store') }}" method="POST" class="user-form">
                @csrf

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
                                value="{{ old('name') }}"
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
                                value="{{ old('nik') }}"
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
                                value="{{ old('email') }}"
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
                                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">Security</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="password" class="form-label">Password <span class="required">*</span></label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input @error('password') error @enderror"
                                placeholder="Enter password (min. 6 characters)"
                                required
                            >
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="required">*</span></label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-input"
                                placeholder="Confirm password"
                                required
                            >
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="history.back()" class="btn btn-outline">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="icon">✓</i>
                        Create User
                    </button>
                </div>
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

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 2rem;
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

.alert ul {
    margin: 0.5rem 0 0 1rem;
}

.alert li {
    margin-bottom: 0.25rem;
}

.icon {
    margin-right: 0.5rem;
}

@media (max-width: 768px) {
    .form-grid {
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
}
</style>
@endsection