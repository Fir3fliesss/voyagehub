@extends('layouts.main')

@section('title', 'Edit Travel Request')

@section('content')
<div class="content-area">
    <div class="main-header">
        <h1 class="page-title">Edit Travel Request</h1>
        <div class="header-actions">
            <a href="{{ route('travel-requests.show', $travelRequest) }}" class="btn btn-secondary">
                <span>←</span> Back to Details
            </a>
        </div>
    </div>

    <div class="form-container">
        <div class="form-header">
            <h2 class="form-title">Edit: {{ $travelRequest->purpose }}</h2>
            <p class="form-description">
                Request #{{ $travelRequest->id }} | Status:
                <span class="status-badge status-{{ $travelRequest->status }}">{{ ucfirst($travelRequest->status) }}</span>
            </p>
        </div>

        @if($travelRequest->status !== 'pending')
            <div class="alert alert-warning">
                <strong>Note:</strong> This request has already been {{ $travelRequest->status }}. You can only edit pending requests.
            </div>
        @else
            <form action="{{ route('travel-requests.update', $travelRequest) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h3 class="section-title">
                        <span>📋</span> Basic Information
                    </h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="purpose" class="form-label">Purpose *</label>
                            <input type="text" id="purpose" name="purpose" class="form-input @error('purpose') error @enderror"
                                   value="{{ old('purpose', $travelRequest->purpose) }}" placeholder="e.g., Business Meeting, Training, Conference" required>
                            @error('purpose')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="destination" class="form-label">Destination *</label>
                            <input type="text" id="destination" name="destination" class="form-input @error('destination') error @enderror"
                                   value="{{ old('destination', $travelRequest->destination) }}" placeholder="e.g., Jakarta, Surabaya, Bali" required>
                            @error('destination')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">
                        <span>📅</span> Travel Dates
                    </h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="start_date" class="form-label">Start Date *</label>
                            <input type="date" id="start_date" name="start_date" class="form-input @error('start_date') error @enderror"
                                   value="{{ old('start_date', $travelRequest->start_date->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                            @error('start_date')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="end_date" class="form-label">End Date *</label>
                            <input type="date" id="end_date" name="end_date" class="form-input @error('end_date') error @enderror"
                                   value="{{ old('end_date', $travelRequest->end_date->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                            @error('end_date')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">
                        <span>💰</span> Budget & Notes
                    </h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="budget" class="form-label">Estimated Budget (IDR) *</label>
                            <input type="number" id="budget" name="budget" class="form-input @error('budget') error @enderror"
                                   value="{{ old('budget', $travelRequest->budget) }}" placeholder="e.g., 2500000" min="0" step="1000" required>
                            @error('budget')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-help">Enter amount in Indonesian Rupiah (IDR)</div>
                        </div>

                        <div class="form-group full-width">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea id="notes" name="notes" class="form-textarea @error('notes') error @enderror"
                                      rows="4" placeholder="Additional information, special requirements, etc.">{{ old('notes', $travelRequest->notes) }}</textarea>
                            @error('notes')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('travel-requests.show', $travelRequest) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Request</button>
                </div>
            </form>
        @endif
    </div>
</div>

<style>
.alert {
    padding: 1rem;
    border-radius: var(--radius);
    margin-bottom: 2rem;
    border: 1px solid;
}

.alert-warning {
    background-color: #fef3c7;
    border-color: #fbbf24;
    color: #92400e;
}

.error {
    border-color: #ef4444;
    background-color: #fef2f2;
}

.error-message {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-help {
    color: var(--muted-foreground);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-grid .form-group.full-width {
    grid-column: 1 / -1;
}

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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        if (endDateInput.value && endDateInput.value < this.value) {
            endDateInput.value = this.value;
        }
    });

    endDateInput.addEventListener('change', function() {
        if (this.value < startDateInput.value) {
            this.value = startDateInput.value;
            alert('End date cannot be earlier than start date');
        }
    });

    // Format budget input
    const budgetInput = document.getElementById('budget');
    budgetInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Set initial minimum end date
    endDateInput.min = startDateInput.value;
});
</script>
@endsection