@extends('layouts.admin')

@section('title', 'Journey Management')

@section('content')
<div class="content-area">
    <div class="main-header">
        <h1 class="page-title">Journey Management</h1>
        <div class="header-actions">
            <button class="btn btn-outline" onclick="exportJourneys()">
                <i class="icon">📊</i>
                Export Data
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistics Overview -->
    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-icon">🌍</div>
            <div class="stat-content">
                <div class="stat-value">{{ $totalJourneys }}</div>
                <div class="stat-label">Total Journeys</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🚀</div>
            <div class="stat-content">
                <div class="stat-value">{{ $activeJourneys }}</div>
                <div class="stat-label">Active Journeys</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-content">
                <div class="stat-value">{{ $upcomingJourneys }}</div>
                <div class="stat-label">Upcoming Journeys</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-content">
                <div class="stat-value">Rp {{ number_format($totalBudget, 0, ',', '.') }}</div>
                <div class="stat-label">Total Budget</div>
            </div>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="filter-container">
        <div class="filter-card">
            <form method="GET" action="{{ route('admin.journeys.index') }}" id="filterForm">
                <div class="filter-header">
                    <h3 class="filter-title">🔍 Search & Filter Journeys</h3>
                    <button type="button" onclick="resetFilters()" class="btn btn-outline btn-sm">
                        Reset Filters
                    </button>
                </div>

                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="search" class="filter-label">Search User/Title</label>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            class="filter-input"
                            value="{{ request('search') }}"
                            placeholder="Search by user name or journey title..."
                        >
                    </div>

                    <div class="filter-group">
                        <label for="start_date" class="filter-label">From Date</label>
                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            class="filter-input"
                            value="{{ request('start_date') }}"
                        >
                    </div>

                    <div class="filter-group">
                        <label for="end_date" class="filter-label">To Date</label>
                        <input
                            type="date"
                            id="end_date"
                            name="end_date"
                            class="filter-input"
                            value="{{ request('end_date') }}"
                        >
                    </div>

                    <div class="filter-group">
                        <label for="min_budget" class="filter-label">Min Budget</label>
                        <input
                            type="number"
                            id="min_budget"
                            name="min_budget"
                            class="filter-input"
                            value="{{ request('min_budget') }}"
                            placeholder="0"
                            min="0"
                        >
                    </div>

                    <div class="filter-group">
                        <label for="max_budget" class="filter-label">Max Budget</label>
                        <input
                            type="number"
                            id="max_budget"
                            name="max_budget"
                            class="filter-input"
                            value="{{ request('max_budget') }}"
                            placeholder="100000000"
                            min="0"
                        >
                    </div>

                    <div class="filter-group">
                        <button type="submit" class="btn btn-primary filter-btn">
                            <i class="icon">🔍</i>
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Journeys Table -->
    <div class="journeys-table-container">
        <div class="table-header">
            <h3 class="table-title">
                Journey List
                @if(request()->hasAny(['search', 'start_date', 'end_date', 'min_budget', 'max_budget']))
                    <span class="filter-indicator">(Filtered)</span>
                @endif
            </h3>
            <div class="table-info">
                Showing {{ $journeys->firstItem() ?? 0 }} to {{ $journeys->lastItem() ?? 0 }}
                of {{ $journeys->total() }} journeys
            </div>
        </div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Journey Title</th>
                        <th>Destination</th>
                        <th>Duration</th>
                        <th>Budget</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($journeys as $journey)
                        @php
                            $now = now();
                            $status = 'upcoming';
                            $statusClass = 'status-upcoming';

                            $startDate = $journey->start_date instanceof \Carbon\Carbon
                                ? $journey->start_date
                                : \Carbon\Carbon::parse($journey->start_date);

                            $endDate = $journey->end_date
                                ? ($journey->end_date instanceof \Carbon\Carbon
                                    ? $journey->end_date
                                    : \Carbon\Carbon::parse($journey->end_date))
                                : null;

                            if ($startDate <= $now && ($endDate >= $now || !$endDate)) {
                                $status = 'active';
                                $statusClass = 'status-active';
                            } elseif ($endDate && $endDate < $now) {
                                $status = 'completed';
                                $statusClass = 'status-completed';
                            }
                        @endphp
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($journey->user->name, 0, 2)) }}
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">{{ $journey->user->name }}</div>
                                        <div class="user-nik">NIK: {{ $journey->user->nik }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="journey-title">{{ $journey->title }}</div>
                                <div class="journey-meta">Created {{ $journey->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="destination-cell">
                                <i class="icon">📍</i>
                                {{ $journey->destination }}
                            </td>
                            <td>
                                <div class="date-range">
                                    <div class="start-date">
                                        @if($journey->start_date instanceof \Carbon\Carbon)
                                            {{ $journey->start_date->format('M d, Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($journey->start_date)->format('M d, Y') }}
                                        @endif
                                    </div>
                                    <div class="date-separator">→</div>
                                    <div class="end-date">
                                        @if($journey->end_date)
                                            @if($journey->end_date instanceof \Carbon\Carbon)
                                                {{ $journey->end_date->format('M d, Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($journey->end_date)->format('M d, Y') }}
                                            @endif
                                        @else
                                            Open
                                        @endif
                                    </div>
                                </div>
                                <div class="duration">
                                    @if($journey->end_date)
                                        @php
                                            $startDate = $journey->start_date instanceof \Carbon\Carbon
                                                ? $journey->start_date
                                                : \Carbon\Carbon::parse($journey->start_date);
                                            $endDate = $journey->end_date instanceof \Carbon\Carbon
                                                ? $journey->end_date
                                                : \Carbon\Carbon::parse($journey->end_date);
                                        @endphp
                                        {{ $startDate->diffInDays($endDate) + 1 }} days
                                    @else
                                        Ongoing
                                    @endif
                                </div>
                            </td>
                            <td class="budget-cell">
                                <div class="budget-amount">Rp {{ number_format($journey->budget, 0, ',', '.') }}</div>
                            </td>
                            <td>
                                <span class="status-badge {{ $statusClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.journeys.show', $journey) }}"
                                       class="btn btn-sm btn-outline" title="View Details">
                                        👁️
                                    </a>
                                    <a href="{{ route('admin.journeys.edit', $journey) }}"
                                       class="btn btn-sm btn-primary" title="Edit">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.journeys.destroy', $journey) }}"
                                          method="POST" style="display: inline;"
                                          onsubmit="return confirm('Are you sure you want to delete this journey?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-icon">🌍</div>
                                <div class="empty-message">
                                    @if(request()->hasAny(['search', 'start_date', 'end_date', 'min_budget', 'max_budget']))
                                        No journeys found matching your filters
                                    @else
                                        No journeys found
                                    @endif
                                </div>
                                @if(request()->hasAny(['search', 'start_date', 'end_date', 'min_budget', 'max_budget']))
                                    <button onclick="resetFilters()" class="btn btn-outline">Clear Filters</button>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination">
            {{ $journeys->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<style>
.stats-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
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
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--foreground);
    margin-bottom: 0.25rem;
}

.stat-label {
    color: var(--muted-foreground);
    font-size: 0.875rem;
}

.filter-container {
    margin-bottom: 2rem;
}

.filter-card {
    background: white;
    border-radius: var(--radius);
    padding: 1.5rem;
    border: 1px solid var(--border);
}

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.filter-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-label {
    font-weight: 500;
    color: var(--foreground);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.filter-input {
    padding: 0.75rem;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    font-size: 0.875rem;
    background: var(--input);
}

.filter-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.2);
}

.filter-btn {
    height: fit-content;
    margin-top: auto;
}

.journeys-table-container {
    background: white;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    overflow: hidden;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border);
}

.table-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--foreground);
    margin: 0;
}

.filter-indicator {
    color: var(--primary);
    font-size: 0.875rem;
    font-weight: normal;
}

.table-info {
    color: var(--muted-foreground);
    font-size: 0.875rem;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
}

.modern-table th {
    background: var(--card);
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--foreground);
    border-bottom: 1px solid var(--border);
}

.modern-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.user-name {
    font-weight: 600;
    color: var(--foreground);
}

.user-nik {
    font-size: 0.75rem;
    color: var(--muted-foreground);
}

.journey-title {
    font-weight: 600;
    color: var(--foreground);
    margin-bottom: 0.25rem;
}

.journey-meta {
    font-size: 0.75rem;
    color: var(--muted-foreground);
}

.destination-cell {
    color: var(--foreground);
}

.date-range {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.start-date, .end-date {
    font-size: 0.875rem;
    font-weight: 500;
}

.date-separator {
    color: var(--muted-foreground);
}

.duration {
    font-size: 0.75rem;
    color: var(--muted-foreground);
}

.budget-cell {
    font-family: monospace;
    font-weight: 600;
    color: var(--primary);
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

.action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.empty-message {
    color: var(--muted-foreground);
    font-size: 1rem;
    margin-bottom: 1rem;
}

.table-pagination {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border);
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

.icon {
    margin-right: 0.5rem;
}

@media (max-width: 768px) {
    .stats-overview {
        grid-template-columns: repeat(2, 1fr);
    }

    .filter-grid {
        grid-template-columns: 1fr;
    }

    .table-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .modern-table {
        font-size: 0.875rem;
    }

    .action-buttons {
        flex-direction: column;
    }

    .date-range {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
}

@media (max-width: 480px) {
    .stats-overview {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function resetFilters() {
    window.location.href = '{{ route("admin.journeys.index") }}';
}

function exportJourneys() {
    // Get current filters
    const params = new URLSearchParams(window.location.search);
    const exportUrl = '{{ route("admin.reports.export-journeys") }}?' + params.toString();
    window.open(exportUrl, '_blank');
}

// Auto-submit form on input change for better UX
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filterForm');
    const inputs = form.querySelectorAll('input[type="text"], input[type="date"], input[type="number"]');

    inputs.forEach(input => {
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                form.submit();
            }, 1000); // Wait 1 second after user stops typing
        });
    });
});
</script>
@endsection