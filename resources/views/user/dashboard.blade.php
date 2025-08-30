@extends('layouts.main')

@section('content')
    <!-- Header -->
    <header class="main-header">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
            <h1 class="page-title">Dashboard</h1>
        </div>
        <div class="header-actions">
            <a href="{{ route('journeys.create') }}" class="btn btn-primary">➕ New Trip</a>
        </div>
    </header>

    <div class="content-area">
        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Total Trips</span>
                    <div class="stat-icon">✈️</div>
                </div>
                <div class="stat-value">{{ $totalTrips }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Total Expenses</span>
                    <div class="stat-icon">💰</div>
                </div>
                <div class="stat-value">Rp{{ number_format($totalExpenses, 2, ',', '.') }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Active Trips</span>
                    <div class="stat-icon">🚀</div>
                </div>
                <div class="stat-value">{{ $activeTrips }}</div>
            </div>

            {{-- <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Countries Visited</span>
                    <div class="stat-icon">🌍</div>
                </div>
                <div class="stat-value">{{ $countriesVisited }}</div>
            </div> --}}
        </div>

        <!-- Activity -->
        <div class="activity-list">
            @forelse($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-icon">✈️</div>
                    <div>
                        <div class="activity-text">Trip to {{ $activity->destination }} ({{ $activity->title }})</div>
                        <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <p>No recent activity.</p>
            @endforelse
        </div>
            </div>
@endsection
