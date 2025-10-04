@extends('layouts.' . (Auth::user()->role === 'admin' ? 'admin' : 'main'))

@section('title', 'Notifications')

@section('content')
<div class="{{ Auth::user()->role === 'admin' ? 'container-fluid' : 'content-area' }}">
    @if(Auth::user()->role === 'admin')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-bell me-2"></i>Notifications
                        </h3>
                        @if($notifications->where('read_at', null)->count() > 0)
                            <form action="{{ route('notifications.mark-all-read') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-check-double"></i> Mark All as Read
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="card-body p-0">
    @else
        <div class="main-header">
            <h1 class="page-title">Notifications</h1>
            <div class="header-actions">
                @if($notifications->where('read_at', null)->count() > 0)
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline">
                            Mark All as Read
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show {{ Auth::user()->role === 'admin' ? 'm-3' : '' }}" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($notifications->count() > 0)
        <div class="{{ Auth::user()->role === 'admin' ? '' : 'activity-section' }}">
            @if(Auth::user()->role !== 'admin')
                <div class="activity-header">
                    <h3 class="activity-title">Your Notifications</h3>
                    <span class="badge">{{ $notifications->total() }}</span>
                </div>
            @endif

            <div class="{{ Auth::user()->role === 'admin' ? 'list-group list-group-flush' : 'activity-list' }}">
                @foreach($notifications as $notification)
                    @php $data = $notification->data; @endphp
                    <div class="{{ Auth::user()->role === 'admin' ? 'list-group-item' : 'activity-item' }} {{ $notification->read_at ? '' : (Auth::user()->role === 'admin' ? 'bg-light' : 'unread') }}">
                        @if(Auth::user()->role === 'admin')
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="{{ $data['icon'] ?? 'fas fa-info-circle' }} text-{{ $data['color'] ?? 'primary' }} fa-lg"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $data['title'] ?? 'Notification' }}</h6>
                                        <p class="mb-1">{{ $data['message'] ?? 'You have a new notification' }}</p>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        @if(!$notification->read_at)
                                            <span class="badge bg-primary ms-2">New</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(!$notification->read_at)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('notifications.read', $notification->id) }}">
                                                    <i class="fas fa-eye me-2"></i>Mark as Read
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Are you sure you want to delete this notification?')">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="activity-icon">
                                @if(isset($data['icon']))
                                    <i class="{{ $data['icon'] }}"></i>
                                @else
                                    🔔
                                @endif
                            </div>
                            <div class="activity-details">
                                <div class="activity-text">
                                    <strong>{{ $data['title'] ?? 'Notification' }}</strong>
                                </div>
                                <div class="activity-time">
                                    {{ $data['message'] ?? 'You have a new notification' }}
                                </div>
                                <div class="activity-time">
                                    {{ $notification->created_at->diffForHumans() }}
                                    @if(!$notification->read_at)
                                        <span class="unread-indicator">• New</span>
                                    @endif
                                </div>
                            </div>
                            <div class="activity-actions">
                                @if(!$notification->read_at)
                                    <a href="{{ route('notifications.read', $notification->id) }}" class="btn btn-outline">
                                        Mark Read
                                    </a>
                                @endif
                                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this notification?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="{{ Auth::user()->role === 'admin' ? 'd-flex justify-content-center p-3' : 'pagination-wrapper' }}">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="{{ Auth::user()->role === 'admin' ? 'text-center py-5' : 'empty-state' }}">
            <i class="fas fa-bell fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No Notifications</h4>
            <p class="text-muted">You don't have any notifications yet.</p>
        </div>
    @endif

    @if(Auth::user()->role === 'admin')
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.unread {
    background-color: #f8f9fa;
    border-left: 4px solid var(--primary);
}

.unread-indicator {
    color: var(--primary);
    font-weight: 600;
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

.pagination-wrapper {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .activity-actions {
        flex-direction: column;
        width: 100%;
    }

    .activity-actions .btn {
        width: 100%;
    }
}
</style>
@endsection