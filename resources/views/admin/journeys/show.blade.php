@extends('layouts.admin')

@section('title', 'Journey Details')

@section('content')
<div class="content-area">
    <div class="main-header">
        <h1 class="page-title">Journey Details</h1>
        <div class="header-actions">
            <a href="{{ route('admin.journeys.index') }}" class="btn btn-outline">
                <i class="icon">←</i>
                Back to Journeys
            </a>
            <a href="{{ route('admin.journeys.edit', $journey) }}" class="btn btn-primary">
                <i class="icon">✏️</i>
                Edit Journey
            </a>
        </div>
    </div>

    <div class="journey-details-container">
        <!-- Journey Overview Card -->
        <div class="journey-overview-card">
            <div class="journey-header">
                <div class="journey-status">
                    @php
                        $now = now();
                        $status = 'upcoming';
                        $statusClass = 'status-upcoming';
                        $statusIcon = '📅';

                        if ($journey->start_date <= $now && $journey->end_date >= $now) {
                            $status = 'active';
                            $statusClass = 'status-active';
                            $statusIcon = '🚀';
                        } elseif ($journey->end_date < $now) {
                            $status = 'completed';
                            $statusClass = 'status-completed';
                            $statusIcon = '✅';
                        }
                    @endphp
                    <span class="status-badge {{ $statusClass }}">
                        {{ $statusIcon }} {{ ucfirst($status) }}
                    </span>
                </div>
                <h2 class="journey-title">{{ $journey->title }}</h2>
                <p class="journey-destination">📍 {{ $journey->destination }}</p>
            </div>

            <div class="journey-info">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Traveler</div>
                        <div class="info-value">
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($journey->user->name, 0, 2)) }}
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ $journey->user->name }}</div>
                                    <div class="user-nik">NIK: {{ $journey->user->nik }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Duration</div>
                        <div class="info-value">
                            <div class="date-range">
                                <div class="start-date">{{ $journey->start_date->format('M d, Y') }}</div>
                                <div class="date-separator">→</div>
                                <div class="end-date">{{ $journey->end_date ? $journey->end_date->format('M d, Y') : 'Open' }}</div>
                            </div>
                            <div class="duration">
                                @if($journey->end_date)
                                    {{ $journey->start_date->diffInDays($journey->end_date) + 1 }} days
                                @else
                                    Ongoing journey
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Budget</div>
                        <div class="info-value budget-amount">
                            Rp {{ number_format($journey->budget, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Transportation</div>
                        <div class="info-value">
                            {{ $journey->transport ?: 'Not specified' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Accommodation</div>
                        <div class="info-value">
                            {{ $journey->accommodation ?: 'Not specified' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Created</div>
                        <div class="info-value">
                            {{ $journey->created_at->format('M d, Y H:i') }}
                            <div class="time-ago">{{ $journey->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Journey Notes -->
        @if($journey->notes)
            <div class="journey-notes-card">
                <h3 class="section-title">📝 Journey Notes</h3>
                <div class="notes-content">
                    {{ $journey->notes }}
                </div>
            </div>
        @endif

        <!-- Journey Timeline -->
        <div class="journey-timeline-card">
            <h3 class="section-title">📊 Journey Timeline</h3>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-marker created"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Journey Created</div>
                        <div class="timeline-date">{{ $journey->created_at->format('M d, Y H:i') }}</div>
                        <div class="timeline-desc">Journey was created by {{ $journey->user->name }}</div>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker {{ $journey->start_date <= now() ? 'completed' : 'upcoming' }}"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Journey Start</div>
                        <div class="timeline-date">{{ $journey->start_date->format('M d, Y') }}</div>
                        <div class="timeline-desc">
                            @if($journey->start_date > now())
                                Journey will start {{ $journey->start_date->diffForHumans() }}
                            @else
                                Journey started {{ $journey->start_date->diffForHumans() }}
                            @endif
                        </div>
                    </div>
                </div>

                @if($journey->end_date)
                    <div class="timeline-item">
                        <div class="timeline-marker {{ $journey->end_date <= now() ? 'completed' : 'upcoming' }}"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Journey End</div>
                            <div class="timeline-date">{{ $journey->end_date->format('M d, Y') }}</div>
                            <div class="timeline-desc">
                                @if($journey->end_date > now())
                                    Journey will end {{ $journey->end_date->diffForHumans() }}
                                @else
                                    Journey ended {{ $journey->end_date->diffForHumans() }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="admin-actions-card">
            <h3 class="section-title">⚙️ Admin Actions</h3>
            <div class="action-grid">
                <a href="{{ route('admin.journeys.edit', $journey) }}" class="action-card">
                    <div class="action-icon">✏️</div>
                    <div class="action-text">
                        <div class="action-title">Edit Journey</div>
                        <div class="action-desc">Update journey information</div>
                    </div>
                </a>

                <button onclick="deleteJourney()" class="action-card delete-action">
                    <div class="action-icon">🗑️</div>
                    <div class="action-text">
                        <div class="action-title">Delete Journey</div>
                        <div class="action-desc">Remove this journey</div>
                    </div>
                </button>

                <a href="{{ route('admin.journeys.index') }}" class="action-card">
                    <div class="action-icon">📋</div>
                    <div class="action-text">
                        <div class="action-title">All Journeys</div>
                        <div class="action-desc">Back to journey list</div>
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
            <p>Are you sure you want to delete the journey <strong>"{{ $journey->title }}"</strong>?</p>
            <p class="warning-text">This action cannot be undone and will remove all associated data.</p>
        </div>
        <div class="modal-actions">
            <button type="button" onclick="closeDeleteModal()" class="btn btn-outline">Cancel</button>
            <form action="{{ route('admin.journeys.destroy', $journey) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Journey</button>
            </form>
        </div>
    </div>
</div>

<style>
.journey-details-container {
    max-width: 1000px;
    margin: 0 auto;
    display: grid;
    gap: 2rem;
}

.journey-overview-card,
.journey-notes-card,
.journey-timeline-card,
.admin-actions-card {
    background: white;
    border-radius: var(--radius);
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid var(--border);
}

.journey-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border);
}

.journey-status {
    margin-bottom: 1rem;
}

.status-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 1.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-upcoming {
    background: #dbeafe;
    color: #1e40af;
}

.status-active {
    background: #d1fae5;
    color: #065f46;
}

.status-completed {
    background: #f3f4f6;
    color: #374151;
}

.journey-title {
    font-size: 2rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0 0 0.5rem;
}

.journey-destination {
    font-size: 1.125rem;
    color: var(--muted-foreground);
    margin: 0;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--muted-foreground);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-weight: 600;
    color: var(--foreground);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 50px;
    height: 50px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1rem;
    flex-shrink: 0;
}

.user-name {
    font-weight: 600;
    color: var(--foreground);
}

.user-nik {
    font-size: 0.875rem;
    color: var(--muted-foreground);
}

.date-range {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.date-separator {
    color: var(--muted-foreground);
}

.duration,
.time-ago {
    font-size: 0.875rem;
    color: var(--muted-foreground);
    font-weight: normal;
}

.budget-amount {
    font-family: monospace;
    font-size: 1.25rem;
    color: var(--primary);
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0 0 1.5rem;
}

.notes-content {
    background: var(--card);
    padding: 1.5rem;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    white-space: pre-wrap;
    font-family: 'Open Sans', sans-serif;
    line-height: 1.6;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--border);
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
    padding-left: 2rem;
}

.timeline-marker {
    position: absolute;
    left: -2rem;
    top: 0.25rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    border: 2px solid var(--border);
    background: white;
}

.timeline-marker.created {
    background: var(--primary);
    border-color: var(--primary);
}

.timeline-marker.completed {
    background: #065f46;
    border-color: #065f46;
}

.timeline-marker.upcoming {
    background: #1e40af;
    border-color: #1e40af;
}

.timeline-title {
    font-weight: 600;
    color: var(--foreground);
    margin-bottom: 0.25rem;
}

.timeline-date {
    font-size: 0.875rem;
    color: var(--primary);
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.timeline-desc {
    font-size: 0.875rem;
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
    .info-grid {
        grid-template-columns: 1fr;
    }

    .action-grid {
        grid-template-columns: 1fr;
    }

    .journey-title {
        font-size: 1.5rem;
    }

    .date-range {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
}
</style>

<script>
function deleteJourney() {
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