@extends('layouts.admin')

@section('title', 'Travel Request Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-0">Travel Request #{{ $travelRequest->id }}</h3>
                        <small class="text-muted">Submitted {{ $travelRequest->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.travel-requests.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        @if($travelRequest->status === 'pending')
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal">
                                <i class="fas fa-check"></i> Approve
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Status Banner -->
                    <div class="alert alert-{{ $travelRequest->status === 'approved' ? 'success' : ($travelRequest->status === 'rejected' ? 'danger' : 'warning') }} mb-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                @if($travelRequest->status === 'pending')
                                    <i class="fas fa-clock fa-2x"></i>
                                @elseif($travelRequest->status === 'approved')
                                    <i class="fas fa-check-circle fa-2x"></i>
                                @else
                                    <i class="fas fa-times-circle fa-2x"></i>
                                @endif
                            </div>
                            <div>
                                <h5 class="mb-1">Status: {{ ucfirst($travelRequest->status) }}</h5>
                                @if($travelRequest->status !== 'pending')
                                    <p class="mb-0">
                                        {{ $travelRequest->status === 'approved' ? 'Approved' : 'Rejected' }} by
                                        {{ $travelRequest->approver->name }} on
                                        {{ $travelRequest->approved_at->format('M d, Y \a\t H:i') }}
                                    </p>
                                @else
                                    <p class="mb-0">Waiting for admin review and approval</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-lg-8">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Request Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted">Purpose</label>
                                            <div class="fw-semibold">{{ $travelRequest->purpose }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted">Destination</label>
                                            <div class="fw-semibold">
                                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                {{ $travelRequest->destination }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted">Start Date</label>
                                            <div class="fw-semibold">{{ $travelRequest->start_date->format('l, F d, Y') }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted">End Date</label>
                                            <div class="fw-semibold">{{ $travelRequest->end_date->format('l, F d, Y') }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted">Duration</label>
                                            <div class="fw-semibold">{{ $travelRequest->start_date->diffInDays($travelRequest->end_date) + 1 }} days</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted">Budget</label>
                                            <div class="fw-semibold text-success fs-5">Rp {{ number_format($travelRequest->budget, 0, ',', '.') }}</div>
                                        </div>
                                        @if($travelRequest->notes)
                                            <div class="col-12">
                                                <label class="form-label text-muted">Additional Notes</label>
                                                <div class="p-3 bg-light rounded">{{ $travelRequest->notes }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Approval Information -->
                            @if($travelRequest->status !== 'pending')
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-{{ $travelRequest->status === 'approved' ? 'check' : 'times' }}-circle me-2"></i>
                                            Approval Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label text-muted">Decision</label>
                                                <div class="fw-semibold">
                                                    <span class="badge bg-{{ $travelRequest->status === 'approved' ? 'success' : 'danger' }} fs-6">
                                                        {{ ucfirst($travelRequest->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted">Reviewed By</label>
                                                <div class="fw-semibold">{{ $travelRequest->approver->name }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted">Date & Time</label>
                                                <div class="fw-semibold">{{ $travelRequest->approved_at->format('l, F d, Y \a\t H:i') }}</div>
                                            </div>
                                            @if($travelRequest->status === 'rejected')
                                                <div class="col-12">
                                                    <label class="form-label text-muted">Rejection Reason</label>
                                                    <div class="p-3 bg-danger bg-opacity-10 border border-danger rounded text-danger">
                                                        {{ $travelRequest->notes }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-4">
                            <!-- User Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Requestor Information</h5>
                                </div>
                                <div class="card-body text-center">
                                    <div class="avatar bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                         style="width: 80px; height: 80px; font-size: 2rem;">
                                        {{ strtoupper(substr($travelRequest->user->name, 0, 2)) }}
                                    </div>
                                    <h5 class="mb-1">{{ $travelRequest->user->name }}</h5>
                                    <p class="text-muted mb-2">NIK: {{ $travelRequest->user->nik }}</p>
                                    <p class="text-muted mb-3">{{ $travelRequest->user->email }}</p>
                                    <span class="badge bg-info">{{ ucfirst($travelRequest->user->role) }}</span>
                                </div>
                            </div>

                            <!-- Timeline -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Request Timeline</h5>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item completed">
                                            <div class="timeline-marker bg-success"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">Request Submitted</h6>
                                                <p class="text-muted mb-0">{{ $travelRequest->created_at->format('M d, Y \a\t H:i') }}</p>
                                            </div>
                                        </div>
                                        @if($travelRequest->status !== 'pending')
                                            <div class="timeline-item completed">
                                                <div class="timeline-marker bg-{{ $travelRequest->status === 'approved' ? 'success' : 'danger' }}"></div>
                                                <div class="timeline-content">
                                                    <h6 class="mb-1">Request {{ ucfirst($travelRequest->status) }}</h6>
                                                    <p class="text-muted mb-0">{{ $travelRequest->approved_at->format('M d, Y \a\t H:i') }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="timeline-item pending">
                                                <div class="timeline-marker bg-warning"></div>
                                                <div class="timeline-content">
                                                    <h6 class="mb-1">Pending Review</h6>
                                                    <p class="text-muted mb-0">Waiting for approval</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Travel Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.travel-requests.approve', $travelRequest) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        You are about to approve this travel request. The user will be notified via email.
                    </div>
                    <div class="mb-3">
                        <label for="approve_notes" class="form-label">Approval Notes (Optional)</label>
                        <textarea name="notes" id="approve_notes" class="form-control" rows="3"
                                  placeholder="Add any notes for the approval..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Approve Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Travel Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.travel-requests.reject', $travelRequest) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        You are about to reject this travel request. Please provide a clear reason.
                    </div>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Rejection Reason *</label>
                        <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="4"
                                  placeholder="Explain why this request is being rejected..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Reject Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.timeline {
    position: relative;
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
    background: #e5e7eb;
}

.timeline-marker {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    margin-right: 1rem;
    margin-top: 2px;
}

.timeline-content {
    flex: 1;
}

.timeline-content h6 {
    margin: 0;
    font-size: 0.9rem;
}

.timeline-content p {
    margin: 0;
    font-size: 0.8rem;
}

.avatar {
    width: 80px;
    height: 80px;
}
</style>
@endpush
@endsection