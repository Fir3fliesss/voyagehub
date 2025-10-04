@extends('layouts.main')

@section('title', 'My Travel Requests')

@section('content')
<div class="content-area">
    <div class="main-header">
        <h1 class="page-title">My Travel Requests</h1>
        <div class="header-actions">
            <a href="{{ route('travel-requests.create') }}" class="btn btn-primary">
                <span>➕</span> New Request
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    @if($travelRequests->count() > 0)
        <div class="activity-section">
            <div class="activity-header">
                <h3 class="activity-title">Your Travel Requests</h3>
                <span class="badge">{{ $travelRequests->total() }}</span>
            </div>
            <div class="activity-list">
                @foreach($travelRequests as $request)
                    <div class="activity-item">
                        <div class="activity-icon">
                            @if($request->status === 'pending')
                                ⏳
                            @elseif($request->status === 'approved')
                                ✅
                            @else
                                ❌
                            @endif
                        </div>
                        <div class="activity-details">
                            <div class="activity-text">
                                <strong>{{ $request->purpose }}</strong> - {{ $request->destination }}
                            </div>
                            <div class="activity-time">
                                {{ $request->start_date->format('M d, Y') }} - {{ $request->end_date->format('M d, Y') }} |
                                Budget: Rp {{ number_format($request->budget, 0, ',', '.') }}
                            </div>
                            <div class="activity-status">
                                <span class="status-badge status-{{ $request->status }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                                @if($request->approved_at)
                                    <span class="text-muted">
                                        {{ $request->status === 'approved' ? 'Approved' : 'Rejected' }}
                                        {{ $request->approved_at->diffForHumans() }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="activity-actions">
                            <a href="{{ route('travel-requests.show', $request) }}" class="btn btn-outline">
                                View
                            </a>
                            @if($request->status === 'pending')
                                <a href="{{ route('travel-requests.edit', $request) }}" class="btn btn-outline">
                                    Edit
                                </a>
                                <form action="{{ route('travel-requests.destroy', $request) }}" method="POST" style="display: inline;"
                                      onsubmit="return confirm('Are you sure you want to delete this request?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline btn-danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="pagination-wrapper">
            {{ $travelRequests->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">✈️</div>
            <h3>No Travel Requests Yet</h3>
            <p>Start by creating your first travel request for approval.</p>
            <a href="{{ route('travel-requests.create') }}" class="btn btn-primary">Create Request</a>
        </div>
    @endif
</div>

<style>
.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-pending {
    background-color: #fef3c7;
    color: #92400e;
}

.status-approved {
    background-color: #d1fae5;
    color: #065f46;
}

.status-rejected {
    background-color: #fee2e2;
    color: #991b1b;
}

.activity-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.activity-actions .btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.btn-danger {
    color: #dc2626;
    border-color: #dc2626;
}

.btn-danger:hover {
    background-color: #dc2626;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.pagination-wrapper {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}
</style>
@endsection