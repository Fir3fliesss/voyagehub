@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="content-area">
    <div class="main-header">
        <h1 class="page-title">User Details</h1>
        <div class="header-actions">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                <i class="icon">←</i>
                Back to Users
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                <i class="icon">✏️</i>
                Edit User
            </a>
        </div>
    </div>

    <div class="user-details-container">
        <!-- User Profile Card -->
        <div class="user-profile-card">
            <div class="user-header">
                <div class="user-avatar-large">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div class="user-info">
                    <h2 class="user-name">{{ $user->name }}</h2>
                    <span class="user-role {{ $user->role }}">{{ ucfirst($user->role) }}</span>
                    <p class="user-email">{{ $user->email }}</p>
                </div>
            </div>

            <div class="user-details">
                <div class="detail-section">
                    <h3 class="detail-title">Account Information</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">NIK (Employee ID)</div>
                            <div class="detail-value">{{ $user->nik }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Email Address</div>
                            <div class="detail-value">{{ $user->email }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Role</div>
                            <div class="detail-value">
                                <span class="role-badge {{ $user->role }}">{{ ucfirst($user->role) }}</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Member Since</div>
                            <div class="detail-value">{{ $user->created_at->format('F d, Y') }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Last Updated</div>
                            <div class="detail-value">{{ $user->updated_at->diffForHumans() }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Account Status</div>
                            <div class="detail-value">
                                <span class="status-badge active">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-section">
            <h3 class="section-title">Activity Statistics</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">✈️</div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $user->journeys()->count() }}</div>
                        <div class="stat-label">Total Trips</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $user->travelRequests()->count() }}</div>
                        <div class="stat-label">Travel Requests</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $user->travelRequests()->where('status', 'approved')->count() }}</div>
                        <div class="stat-label">Approved Requests</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-content">
                        <div class="stat-value">Rp {{ number_format($user->journeys()->sum('budget'), 0, ',', '.') }}</div>
                        <div class="stat-label">Total Budget</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        @if($user->journeys()->count() > 0 || $user->travelRequests()->count() > 0)
            <div class="activity-section">
                <h3 class="section-title">Recent Activity</h3>
                <div class="activity-list">
                    @php
                        $recentJourneys = $user->journeys()->latest()->take(3)->get();
                        $recentRequests = $user->travelRequests()->latest()->take(3)->get();
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
                            ->take(6);
                    @endphp

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
                </div>
            </div>
        @else
            <div class="empty-activity">
                <div class="empty-icon">📝</div>
                <h3>No Activity Yet</h3>
                <p>This user hasn't created any trips or travel requests yet.</p>
            </div>
        @endif

        <!-- Admin Actions -->
        <div class="admin-actions">
            <h3 class="section-title">Admin Actions</h3>
            <div class="action-grid">
                <a href="{{ route('admin.users.edit', $user) }}" class="action-card">
                    <div class="action-icon">✏️</div>
                    <div class="action-text">
                        <div class="action-title">Edit User</div>
                        <div class="action-desc">Update user information</div>
                    </div>
                </a>

                @if($user->id !== Auth::id())
                    <button onclick="deleteUser()" class="action-card delete-action">
                        <div class="action-icon">🗑️</div>
                        <div class="action-text">
                            <div class="action-title">Delete User</div>
                            <div class="action-desc">Remove user account</div>
                        </div>
                    </button>
                @else
                    <div class="action-card disabled">
                        <div class="action-icon">🔒</div>
                        <div class="action-text">
                            <div class="action-title">Cannot Delete</div>
                            <div class="action-desc">Own account protection</div>
                        </div>
                    </div>
                @endif

                <a href="{{ route('admin.users.create') }}" class="action-card">
                    <div class="action-icon">👤</div>
                    <div class="action-text">
                        <div class="action-title">Add New User</div>
                        <div class="action-desc">Create another user</div>
                    </div>
                </a>
            </div>
        </div>
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
.user-details-container {
    max-width: 1000px;
    margin: 0 auto;
    display: grid;
    gap: 2rem;
}

.user-profile-card {
    background: white;
    border-radius: var(--radius);
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid var(--border);
}

.user-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border);
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
    flex-shrink: 0;
}

.user-info {
    flex: 1;
}

.user-name {
    font-size: 2rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0 0 0.5rem;
}

.user-role {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.user-role.admin {
    background: #fef3c7;
    color: #92400e;
}

.user-role.user {
    background: #dbeafe;
    color: #1e40af;
}

.user-email {
    color: var(--muted-foreground);
    margin: 0.5rem 0 0;
    font-size: 1.1rem;
}

.detail-section {
    margin-bottom: 2rem;
}

.detail-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0 0 1rem;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.detail-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--muted-foreground);
}

.detail-value {
    font-weight: 600;
    color: var(--foreground);
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

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-badge.active {
    background: #d1fae5;
    color: #065f46;
}

.stats-section,
.activity-section,
.admin-actions {
    background: white;
    border-radius: var(--radius);
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid var(--border);
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0 0 1.5rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.stat-card {
    background: var(--card);
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
    font-size: 1.25rem;
    font-weight: bold;
    color: var(--foreground);
    margin-bottom: 0.25rem;
}

.stat-label {
    color: var(--muted-foreground);
    font-size: 0.875rem;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    background: var(--card);
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

.empty-activity {
    background: white;
    border-radius: var(--radius);
    padding: 3rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid var(--border);
    text-align: center;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-activity h3 {
    color: var(--foreground);
    margin-bottom: 0.5rem;
}

.empty-activity p {
    color: var(--muted-foreground);
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.action-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    text-decoration: none;
    color: var(--foreground);
    transition: all 0.2s;
    background: var(--card);
    cursor: pointer;
}

.action-card:hover {
    border-color: var(--primary);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.action-card.delete-action:hover {
    border-color: #ef4444;
    background: #fef2f2;
}

.action-card.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.action-card.disabled:hover {
    transform: none;
    border-color: var(--border);
    box-shadow: none;
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
    .user-header {
        flex-direction: column;
        text-align: center;
    }

    .user-avatar-large {
        margin: 0 auto;
    }

    .detail-grid {
        grid-template-columns: 1fr;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .action-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
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