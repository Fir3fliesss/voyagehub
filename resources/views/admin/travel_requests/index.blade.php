@extends('layouts.admin')

@section('title', 'Travel Requests Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Filters Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>Filters & Search
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.travel-requests.index') }}" id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="user_id" class="form-label">User</label>
                                <select name="user_id" id="user_id" class="form-select">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->nik }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">From Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">To Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       placeholder="Search by purpose or destination..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="{{ route('admin.travel-requests.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-plane me-2"></i>Travel Requests
                        <span class="badge bg-primary ms-2">{{ $travelRequests->total() }}</span>
                    </h3>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success btn-sm" id="bulkApproveBtn" disabled>
                            <i class="fas fa-check"></i> Bulk Approve
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" id="bulkRejectBtn" disabled>
                            <i class="fas fa-times"></i> Bulk Reject
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            @foreach($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($travelRequests->count() > 0)
                        <form id="bulkActionForm" method="POST" action="{{ route('admin.travel-requests.bulk-action') }}">
                            @csrf
                            <input type="hidden" name="action" id="bulkAction">
                            <input type="hidden" name="bulk_notes" id="bulkNotes">

                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="50">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                            <th>User</th>
                                            <th>Purpose</th>
                                            <th>Destination</th>
                                            <th>Travel Dates</th>
                                            <th>Budget</th>
                                            <th>Status</th>
                                            <th>Submitted</th>
                                            <th width="150">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($travelRequests as $request)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="request_ids[]" value="{{ $request->id }}"
                                                           class="form-check-input request-checkbox">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar me-2 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                             style="width: 32px; height: 32px; font-size: 12px;">
                                                            {{ strtoupper(substr($request->user->name, 0, 2)) }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ $request->user->name }}</div>
                                                            <small class="text-muted">{{ $request->user->nik }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold">{{ $request->purpose }}</div>
                                                    @if($request->notes)
                                                        <small class="text-muted">{{ Str::limit($request->notes, 50) }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                    {{ $request->destination }}
                                                </td>
                                                <td>
                                                    <div class="small">
                                                        <div><strong>From:</strong> {{ $request->start_date->format('M d, Y') }}</div>
                                                        <div><strong>To:</strong> {{ $request->end_date->format('M d, Y') }}</div>
                                                        <div class="text-muted">{{ $request->start_date->diffInDays($request->end_date) + 1 }} days</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold text-success">
                                                        Rp {{ number_format($request->budget, 0, ',', '.') }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($request->status === 'pending')
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-clock me-1"></i>Pending
                                                        </span>
                                                    @elseif($request->status === 'approved')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>Approved
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times me-1"></i>Rejected
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="small">
                                                        <div>{{ $request->created_at->format('M d, Y') }}</div>
                                                        <div class="text-muted">{{ $request->created_at->format('H:i') }}</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.travel-requests.show', $request) }}"
                                                           class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if($request->status === 'pending')
                                                            <button type="button" class="btn btn-sm btn-outline-success approve-btn"
                                                                    data-id="{{ $request->id }}" data-bs-toggle="modal" data-bs-target="#approveModal">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-outline-danger reject-btn"
                                                                    data-id="{{ $request->id }}" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <div class="d-flex justify-content-between align-items-center p-3">
                            <div class="text-muted">
                                Showing {{ $travelRequests->firstItem() }} to {{ $travelRequests->lastItem() }} of {{ $travelRequests->total() }} results
                            </div>
                            {{ $travelRequests->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-plane fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No Travel Requests Found</h4>
                            <p class="text-muted">No travel requests match your current filters.</p>
                        </div>
                    @endif
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
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to approve this travel request?</p>
                    <div class="mb-3">
                        <label for="approve_notes" class="form-label">Notes (Optional)</label>
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
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Please provide a reason for rejecting this travel request:</p>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Rejection Reason *</label>
                        <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="3"
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const requestCheckboxes = document.querySelectorAll('.request-checkbox');
    const bulkApproveBtn = document.getElementById('bulkApproveBtn');
    const bulkRejectBtn = document.getElementById('bulkRejectBtn');

    selectAllCheckbox.addEventListener('change', function() {
        requestCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkButtons();
    });

    requestCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkButtons);
    });

    function updateBulkButtons() {
        const checkedBoxes = document.querySelectorAll('.request-checkbox:checked');
        const hasChecked = checkedBoxes.length > 0;

        bulkApproveBtn.disabled = !hasChecked;
        bulkRejectBtn.disabled = !hasChecked;

        selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < requestCheckboxes.length;
        selectAllCheckbox.checked = checkedBoxes.length === requestCheckboxes.length;
    }

    // Individual approve/reject buttons
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const requestId = this.dataset.id;
            const form = document.getElementById('approveForm');
            form.action = `/admin/travel-requests/${requestId}/approve`;
        });
    });

    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const requestId = this.dataset.id;
            const form = document.getElementById('rejectForm');
            form.action = `/admin/travel-requests/${requestId}/reject`;
        });
    });

    // Bulk actions
    bulkApproveBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to approve all selected requests?')) {
            document.getElementById('bulkAction').value = 'approve';
            const notes = prompt('Add notes for bulk approval (optional):') || '';
            document.getElementById('bulkNotes').value = notes;
            document.getElementById('bulkActionForm').submit();
        }
    });

    bulkRejectBtn.addEventListener('click', function() {
        const reason = prompt('Enter rejection reason for all selected requests:');
        if (reason && reason.trim()) {
            document.getElementById('bulkAction').value = 'reject';
            document.getElementById('bulkNotes').value = reason;
            document.getElementById('bulkActionForm').submit();
        }
    });
});
</script>
@endpush
@endsection