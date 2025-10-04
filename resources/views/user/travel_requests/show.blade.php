@extends('layouts.main')

@section('title', 'Travel Request Details')

@section('content')
<div class="content-area">
    <div class="main-header">
        <h1 class="page-title">Travel Request Details</h1>
        <div class="header-actions">
            <a href="{{ route('travel-requests.index') }}" class="btn btn-secondary">
                <span>←</span> Back to Requests
            </a>
            @if($travelRequest->status === 'pending')
                <a href="{{ route('travel-requests.edit', $travelRequest) }}" class="btn btn-outline">
                    Edit Request
                </a>
            @endif
        </div>
    </div>

    <div class="form-container">
        <div class="form-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="form-title">{{ $travelRequest->purpose }}</h2>
                    <p class="form-description">Request #{{ $travelRequest->id }}</p>
                </div>
                <div class="status-badge-large status-{{ $travelRequest->status }}">
                    {{ ucfirst($travelRequest->status) }}
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">
                <span>📋</span> Basic Information
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <label class="info-label">Purpose</label>
                    <div class="info-value">{{ $travelRequest->purpose }}</div>
                </div>
                <div class="info-item">
                    <label class="info-label">Destination</label>
                    <div class="info-value">{{ $travelRequest->destination }}</div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">
                <span>📅</span> Travel Schedule
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <label class="info-label">Start Date</label>
                    <div class="info-value">{{ $travelRequest->start_date->format('l, F d, Y') }}</div>
                </div>
                <div class="info-item">
                    <label class="info-label">End Date</label>
                    <div class="info-value">{{ $travelRequest->end_date->format('l, F d, Y') }}</div>
                </div>
                <div class="info-item">
                    <label class="info-label">Duration</label>
                    <div class="info-value">{{ $travelRequest->start_date->diffInDays($travelRequest->end_date) + 1 }} days</div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">
                <span>💰</span> Budget Information
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <label class="info-label">Estimated Budget</label>
                    <div class="info-value budget-amount">Rp {{ number_format($travelRequest->budget, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        @if($travelRequest->notes)
            <div class="form-section">
                <h3 class="section-title">
                    <span>📝</span> Notes
                </h3>
                <div class="notes-content">
                    {{ $travelRequest->notes }}
                </div>
            </div>
        @endif

        @if($travelRequest->status !== 'pending')
            <div class="form-section">
                <h3 class="section-title">
                    <span>✅</span> Approval Information
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label class="info-label">Status</label>
                        <div class="info-value">
                            <span class="status-badge status-{{ $travelRequest->status }}">
                                {{ ucfirst($travelRequest->status) }}
                            </span>
                        </div>
                    </div>
                    @if($travelRequest->approver)
                        <div class="info-item">
                            <label class="info-label">{{ $travelRequest->status === 'approved' ? 'Approved' : 'Rejected' }} By</label>
                            <div class="info-value">{{ $travelRequest->approver->name }}</div>
                        </div>
                    @endif
                    @if($travelRequest->approved_at)
                        <div class="info-item">
                            <label class="info-label">Date</label>
                            <div class="info-value">{{ $travelRequest->approved_at->format('l, F d, Y \a\t H:i') }}</div>
                        </div>
                    @endif
                    @if($travelRequest->status === 'rejected' && $travelRequest->notes)
                        <div class="info-item full-width">
                            <label class="info-label">Rejection Reason</label>
                            <div class="info-value rejection-reason">{{ $travelRequest->notes }}</div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div class="form-section">
            <h3 class="section-title">
                <span>ℹ️</span> Request Timeline
            </h3>
            <div class="timeline">
                <div class="timeline-item completed">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Request Submitted</div>
                        <div class="timeline-time">{{ $travelRequest->created_at->format('M d, Y \a\t H:i') }}</div>
                    </div>
                </div>
                @if($travelRequest->status !== 'pending')
                    <div class="timeline-item completed">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">
                                Request {{ $travelRequest->status === 'approved' ? 'Approved' : 'Rejected' }}
                            </div>
                            <div class="timeline-time">{{ $travelRequest->approved_at->format('M d, Y \a\t H:i') }}</div>
                        </div>
                    </div>
                @else
                    <div class="timeline-item pending">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Waiting for Approval</div>
                            <div class="timeline-time">Pending admin review</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.status-badge-large {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 1rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-item.full-width {
    grid-column: 1 / -1;
}

.info-label {
    font-weight: 600;
    color: var(--muted-foreground);
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.info-value {
    font-size: 1rem;
    color: var(--foreground);
}

.budget-amount {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary);
}

.notes-content {
    background: var(--card);
    padding: 1rem;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    margin-top: 1rem;
    white-space: pre-wrap;
}

.rejection-reason {
    background: #fef2f2;
    padding: 1rem;
    border-radius: var(--radius);
    border: 1px solid #fecaca;
    color: #991b1b;
}

.timeline {
    margin-top: 1rem;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    position: relative;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 9px;
    top: 20px;
    width: 2px;
    height: calc(100% + 0.5rem);
    background: var(--border);
}

.timeline-dot {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    margin-right: 1rem;
    margin-top: 2px;
    border: 2px solid var(--border);
    background: var(--background);
}

.timeline-item.completed .timeline-dot {
    background: var(--primary);
    border-color: var(--primary);
}

.timeline-item.pending .timeline-dot {
    background: #fbbf24;
    border-color: #fbbf24;
}

.timeline-content {
    flex: 1;
}

.timeline-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.timeline-time {
    font-size: 0.875rem;
    color: var(--muted-foreground);
}

.d-flex {
    display: flex;
}

.justify-content-between {
    justify-content: space-between;
}

.align-items-center {
    align-items: center;
}

@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }

    .d-flex {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
</style>
@endsection