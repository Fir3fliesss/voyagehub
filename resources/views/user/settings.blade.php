@extends('layouts.main')

@section('title', 'User Settings')

@section('content')
<header class="main-header">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
        <h1 class="page-title">User Settings</h1>
    </div>
</header>

<div class="content-area">
    <div class="form-container">
        <div class="form-header">
            <h2 class="form-title">Update Profile</h2>
        </div>

        @if(session('success'))
            <div style="color: green; margin-bottom: 1rem;">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                @error('name') <small style="color:red">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">NIK</label>
                <input type="text" name="nik" class="form-input" value="{{ old('nik', $user->nik) }}" required>
                @error('nik') <small style="color:red">{{ $message }}</small> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
