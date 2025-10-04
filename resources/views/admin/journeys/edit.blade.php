@extends('layouts.admin')

@section('title', 'Edit Journey')

@section('content')
<div class="content-area">
    <div class="main-header">
        <h1 class="page-title">Edit Journey</h1>
        <div class="header-actions">
            <a href="{{ route('admin.journeys.index') }}" class="btn btn-outline">
                <i class="icon">←</i>
                Back to Journeys
            </a>
            <a href="{{ route('admin.journeys.show', $journey) }}" class="btn btn-outline">
                <i class="icon">👁️</i>
                View Details
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2 class="form-title">Edit Journey: {{ $journey->title }}</h2>
                <p class="form-subtitle">Update journey information and details</p>
            </div>

            <form action="{{ route('admin.journeys.update', $journey) }}" method="POST" class="journey-form">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h3 class="section-title">👤 Traveler Information</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="user_id" class="form-label">Traveler <span class="required">*</span></label>
                            <select
                                id="user_id"
                                name="user_id"
                                class="form-select @error('user_id') error @enderror"
                                required
                            >
                                <option value="">Select Traveler</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', $journey->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} (NIK: {{ $user->nik }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">🌍 Journey Details</h3>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="title" class="form-label">Journey Title <span class="required">*</span></label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                class="form-input @error('title') error @enderror"
                                value="{{ old('title', $journey->title) }}"
                                placeholder="Enter journey title"
                                required
                            >
                            @error('title')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="destination" class="form-label">Destination <span class="required">*</span></label>
                            <input
                                type="text"
                                id="destination"
                                name="destination"
                                class="form-input @error('destination') error @enderror"
                                value="{{ old('destination', $journey->destination) }}"
                                placeholder="Enter destination"
                                required
                            >
                            @error('destination')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="start_date" class="form-label">Start Date <span class="required">*</span></label>
                            <input
                                type="date"
                                id="start_date"
                                name="start_date"
                                class="form-input @error('start_date') error @enderror"
                                value="{{ old('start_date', $journey->start_date->format('Y-m-d')) }}"
                                required
                            >
                            @error('start_date')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="end_date" class="form-label">End Date</label>
                            <input
                                type="date"
                                id="end_date"
                                name="end_date"
                                class="form-input @error('end_date') error @enderror"
                                value="{{ old('end_date', $journey->end_date ? $journey->end_date->format('Y-m-d') : '') }}"
                            >
                            @error('end_date')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <small class="form-hint">Leave empty for open-ended journey</small>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">🚗 Transportation & Accommodation</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="transport" class="form-label">Transportation</label>
                            <input
                                type="text"
                                id="transport"
                                name="transport"
                                class="form-input @error('transport') error @enderror"
                                value="{{ old('transport', $journey->transport) }}"
                                placeholder="e.g., Flight, Train, Car"
                            >
                            @error('transport')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="accommodation" class="form-label">Accommodation</label>
                            <input
                                type="text"
                                id="accommodation"
                                name="accommodation"
                                class="form-input @error('accommodation') error @enderror"
                                value="{{ old('accommodation', $journey->accommodation) }}"
                                placeholder="e.g., Hotel, Hostel, Airbnb"
                            >
                            @error('accommodation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="budget" class="form-label">Budget (Rp)</label>
                            <input
                                type="number"
                                id="budget"
                                name="budget"
                                class="form-input @error('budget') error @enderror"
                                value="{{ old('budget', $journey->budget) }}"
                                placeholder="0"
                                min="0"
                                step="1000"
                            >
                            @error('budget')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">📝 Additional Information</h3>
                    <div class="form-group">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea
                            id="notes"
                            name="notes"
                            class="form-textarea @error('notes') error @enderror"
                            rows="4"
                            placeholder="Add any additional notes or details about the journey..."
                        >{{ old('notes', $journey->notes) }}</textarea>
                        @error('notes')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Journey Statistics -->
                <div class="journey-stats">
                    <h3 class="section-title">📊 Journey Information</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-label">Created</div>
                            <div class="stat-value">{{ $journey->created_at->format('M d, Y') }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Last Updated</div>
                            <div class="stat-value">{{ $journey->updated_at->diffForHumans() }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Status</div>
                            <div class="stat-value">
                                @php
                                    $now = now();
                                    $status = 'upcoming';
                                    $statusClass = 'status-upcoming';

                                    if ($journey->start_date <= $now && ($journey->end_date >= $now || !$journey->end_date)) {
                                        $status = 'active';
                                        $statusClass = 'status-active';
                                    } elseif ($journey->end_date && $journey->end_date < $now) {
                                        $status = 'completed';
                                        $statusClass = 'status-completed';
                                    }
                                @endphp
                                <span class="status-badge {{ $statusClass }}">{{ ucfirst($status) }}</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Duration</div>
                            <div class="stat-value">
                                @if($journey->end_date)
                                    {{ $journey->start_date->diffInDays($journey->end_date) + 1 }} days
                                @else
                                    Ongoing
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="history.back()" class="btn btn-outline">
                        Cancel
                    </button>
                    <button type="button" onclick="deleteJourney()" class="btn btn-danger">
                        <i class="icon">🗑️</i>
                        Delete Journey
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="icon">✓</i>
                        Update Journey
                    </button>
                </div>
            </form>
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
.form-container {
    max-width: 800px;
    margin: 0 auto;
}

.form-card {
    background: white;
    border-radius: var(--radius);
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid var(--border);
}

.form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.form-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0 0 0.5rem;
}

.form-subtitle {
    color: var(--muted-foreground);
    margin: 0;
}

.form-section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0 0 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--border);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-weight: 500;
    color: var(--foreground);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.required {
    color: #ef4444;
}

.form-input,
.form-select,
.form-textarea {
    padding: 0.75rem;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    font-size: 0.875rem;
    transition: all 0.2s;
    background: var(--input);
    font-family: inherit;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.2);
}

.form-input.error,
.form-select.error,
.form-textarea.error {
    border-color: #ef4444;
}

.form-hint {
    color: var(--muted-foreground);
    font-size: 0.75rem;
    margin-top: 0.25rem;
    font-style: italic;
}

.error-message {
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.journey-stats {
    background: var(--card);
    padding: 1.5rem;
    border-radius: var(--radius);
    margin-bottom: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.stat-item {
    text-align: center;
}

.stat-label {
    color: var(--muted-foreground);
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    font-size: 1rem;
    font-weight: bold;
    color: var(--foreground);
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
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

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 2rem;
    border-top: 1px solid var(--border);
}

.btn-danger {
    background-color: #ef4444;
    color: white;
    border: 1px solid #ef4444;
}

.btn-danger:hover {
    background-color: #dc2626;
    border-color: #dc2626;
}

.alert {
    padding: 1rem;
    border-radius: var(--radius);
    margin-bottom: 1.5rem;
}

.alert-success {
    background-color: #d1fae5;
    border: 1px solid #a7f3d0;
    color: #065f46;
}

.alert-error {
    background-color: #fee2e2;
    border: 1px solid #fecaca;
    color: #b91c1c;
}

.alert ul {
    margin: 0.5rem 0 0 1rem;
}

.alert li {
    margin-bottom: 0.25rem;
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
    .form-grid,
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .form-card {
        padding: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .form-actions .btn {
        justify-content: center;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
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

// Auto-calculate duration when dates change
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    function updateDuration() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (startDate && endDate && endDate >= startDate) {
            const diffTime = Math.abs(endDate - startDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            console.log(`Duration: ${diffDays} days`);
        }
    }

    startDateInput.addEventListener('change', updateDuration);
    endDateInput.addEventListener('change', updateDuration);
});
</script>
@endsection