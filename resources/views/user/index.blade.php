@extends('layouts.main')

@section('title', 'My Profile')

@section('content')
<div class="content-area">
    <div class="main-header">
        <h1 class="page-title">My Profile</h1>
        <div class="header-actions">
            <a href="{{ route('users.edit', Auth::user()) }}" class="btn btn-outline">
                <i class="icon">✏️</i>
                Edit Profile
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-container">
        <!-- Profile Card -->
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="profile-info">
                    <h2 class="profile-name">{{ Auth::user()->name }}</h2>
                    <p class="profile-role">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>

            <div class="profile-details">
                <div class="detail-item">
                    <div class="detail-label">NIK</div>
                    <div class="detail-value">{{ Auth::user()->nik }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ Auth::user()->email }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Member Since</div>
                    <div class="detail-value">{{ Auth::user()->created_at->format('F d, Y') }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Last Updated</div>
                    <div class="detail-value">{{ Auth::user()->updated_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">✈️</div>
                <div class="stat-content">
                    <div class="stat-value">{{ Auth::user()->journeys()->count() }}</div>
                    <div class="stat-label">Total Trips</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📋</div>
                <div class="stat-content">
                    <div class="stat-value">{{ Auth::user()->travelRequests()->count() }}</div>
                    <div class="stat-label">Travel Requests</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <div class="stat-value">{{ Auth::user()->travelRequests()->where('status', 'approved')->count() }}</div>
                    <div class="stat-label">Approved</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-content">
                    <div class="stat-value">Rp {{ number_format(Auth::user()->journeys()->sum('budget'), 0, ',', '.') }}</div>
                    <div class="stat-label">Total Budget</div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="activity-section">
            <div class="activity-header">
                <h3 class="activity-title">Recent Activity</h3>
            </div>

            <div class="activity-list">
                @php
                    $recentJourneys = Auth::user()->journeys()->latest()->take(5)->get();
                    $recentRequests = Auth::user()->travelRequests()->latest()->take(5)->get();
                    $activities = collect()
                        ->merge($recentJourneys->map(function($journey) {
                            return (object)[
                                'type' => 'journey',
                                'title' => $journey->title,
                                'subtitle' => 'Trip to ' . $journey->destination,
                                'date' => $journey->created_at,
                                'icon' => '✈️'
                            ];
                        }))
                        ->merge($recentRequests->map(function($request) {
                            return (object)[
                                'type' => 'request',
                                'title' => $request->purpose,
                                'subtitle' => 'Travel request - ' . ucfirst($request->status),
                                'date' => $request->created_at,
                                'icon' => $request->status === 'approved' ? '✅' : ($request->status === 'rejected' ? '❌' : '⏳')
                            ];
                        }))
                        ->sortByDesc('date')
                        ->take(8);
                @endphp

                @if($activities->count() > 0)
                    @foreach($activities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon">{{ $activity->icon }}</div>
                            <div class="activity-details">
                                <div class="activity-text">
                                    <strong>{{ $activity->title }}</strong>
                                </div>
                                <div class="activity-time">
                                    {{ $activity->subtitle }} • {{ $activity->date->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-icon">📝</div>
                        <p>No recent activity. Start by creating your first travel request!</p>
                        <a href="{{ route('travel-requests.create') }}" class="btn btn-primary">Create Travel Request</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3 class="section-title">Quick Actions</h3>
            <div class="action-grid">
                <a href="{{ route('travel-requests.create') }}" class="action-card">
                    <div class="action-icon">📋</div>
                    <div class="action-text">
                        <div class="action-title">New Travel Request</div>
                        <div class="action-desc">Submit a new travel request</div>
                    </div>
                </a>

                <a href="{{ route('new-trip') }}" class="action-card">
                    <div class="action-icon">➕</div>
                    <div class="action-text">
                        <div class="action-title">Add Trip</div>
                        <div class="action-desc">Add trip from approved request</div>
                    </div>
                </a>

                <a href="{{ route('travel-requests.index') }}" class="action-card">
                    <div class="action-icon">📊</div>
                    <div class="action-text">
                        <div class="action-title">My Requests</div>
                        <div class="action-desc">View all travel requests</div>
                    </div>
                </a>

                <a href="{{ route('notifications.index') }}" class="action-card">
                    <div class="action-icon">🔔</div>
                    <div class="action-text">
                        <div class="action-title">Notifications</div>
                        <div class="action-desc">View notifications</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    gap: 2rem;
    grid-template-columns: 1fr 2fr;
    grid-template-areas:
        "profile stats"
        "actions activity";
}

.profile-card {
    grid-area: profile;
    background: white;
    border-radius: var(--radius);
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid var(--border);
    height: fit-content;
}

.profile-header {
    text-align: center;
    margin-bottom: 2rem;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: bold;
    margin: 0 auto 1rem;
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0 0 0.5rem;
    color: var(--foreground);
}

.profile-role {
    color: var(--muted-foreground);
    font-size: 0.9rem;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.profile-details {
    space-y: 1rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 500;
    color: var(--muted-foreground);
}

.detail-value {
    font-weight: 600;
    color: var(--foreground);
}

.stats-grid {
    grid-area: stats;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.stat-card {
    background: white;
    border-radius: var(--radius);
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    font-size: 2rem;
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

.activity-section {
    grid-area: activity;
    background: white;
    border-radius: var(--radius);
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid var(--border);
}

.activity-header {
    margin-bottom: 1.5rem;
}

.activity-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0;
}

.activity-list {
    space-y: 1rem;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    transition: all 0.2s;
}

.activity-item:hover {
    background: var(--card);
    border-color: var(--primary);
}

.activity-icon {
    font-size: 1.25rem;
    flex-shrink: 0;
}

.activity-details {
    flex: 1;
}

.activity-text {
    margin-bottom: 0.25rem;
}

.activity-time {
    color: var(--muted-foreground);
    font-size: 0.875rem;
}

.quick-actions {
    grid-area: actions;
    background: white;
    border-radius: var(--radius);
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid var(--border);
    height: fit-content;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0 0 1.5rem;
}

.action-grid {
    display: grid;
    gap: 1rem;
}

.action-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    text-decoration: none;
    color: var(--foreground);
    transition: all 0.2s;
}

.action-card:hover {
    background: var(--card);
    border-color: var(--primary);
    transform: translateY(-1px);
}

.action-icon {
    font-size: 1.5rem;
    flex-shrink: 0;
}

.action-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.action-desc {
    color: var(--muted-foreground);
    font-size: 0.875rem;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .profile-container {
        grid-template-columns: 1fr;
        grid-template-areas:
            "profile"
            "stats"
            "actions"
            "activity";
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .profile-card,
    .activity-section,
    .quick-actions {
        padding: 1.5rem;
    }
}
</style>
@endsection
