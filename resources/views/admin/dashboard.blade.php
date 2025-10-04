@extends('layouts.main')

<<<<<<< HEAD
@section('content')
    <!-- Header -->
    <header class="main-header">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
            <h1 class="page-title">Dashboard</h1>
        </div>
        <div class="header-actions">
            <a href="{{ route('journeys.create') }}" class="btn btn-primary">➕ New Trip</a>
        </div>
    </header>

    <div class="content-area">
        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Total Trips</span>
                    <div class="stat-icon">✈️</div>
                </div>
                <div class="stat-value">{{ $totalTrips }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Total Expenses</span>
                    <div class="stat-icon">💰</div>
                </div>
                <div class="stat-value">Rp{{ number_format($totalExpenses, 2, ',', '.') }}</div>
            </div>

            {{-- <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Countries Visited</span>
                    <div class="stat-icon">🌍</div>
                </div>
                <div class="stat-value">{{ $countriesVisited }}</div>
            </div> --}}
        </div>

        <!-- Recent Activities Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent Activities</h6>
            </div>
            <div class="card-body">
                 <form action="{{ route('admin.dashboard') }}" method="GET" class="mb-4">
                     <div class="form-row align-items-end">
                         <div class="col-md-3 mb-3">
                             <label for="date_filter">Filter by Date:</label>
                             <input type="date" name="date" id="date_filter" class="form-control" value="{{ request('date') }}">
                         </div>
                         <div class="col-md-5 mb-3">
                             <label for="search_filter">Search:</label>
                             <input type="text" name="search" id="search_filter" class="form-control" placeholder="Search by destination or title..." value="{{ request('search') }}">
                         </div>
                         <div class="col-md-4 mb-3">
                             <button type="submit" class="btn btn-primary">Apply Filter</button>
                             <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary ml-2">Clear Filter</a>
                         </div>
                     </div>
                 </form>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Destination</th>
                                <th>Title</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities as $activity)
                                <tr>
                                    <td>{{ $activity->user->name }}</td>
                                    <td>{{ $activity->destination }}</td>
                                    <td>{{ $activity->title }}</td>
                                    <td>{{ $activity->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No recent activity.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $recentActivities->links() }}
=======
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Total Users</div>
                            <div class="h4 mb-0">{{ number_format($stats['total_users']) }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Total Journeys</div>
                            <div class="h4 mb-0">{{ number_format($stats['total_journeys']) }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-route fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Total Requests</div>
                            <div class="h4 mb-0">{{ number_format($stats['total_requests']) }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-paper-plane fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Pending</div>
                            <div class="h4 mb-0">{{ number_format($stats['pending_requests']) }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
            <div class="card bg-dark text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Total Budget</div>
                            <div class="h6 mb-0">Rp {{ number_format($stats['total_budget'], 0, ',', '.') }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-money-bill fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
            <div class="card bg-secondary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">This Month</div>
                            <div class="h4 mb-0">{{ number_format($stats['this_month_journeys']) }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Monthly Journey Trends -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Journey Trends (Last 12 Months)
                    </h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <input type="radio" class="btn-check" name="chartType" id="journeyCount" value="journeys" checked>
                        <label class="btn btn-outline-primary" for="journeyCount">Count</label>

                        <input type="radio" class="btn-check" name="chartType" id="journeyBudget" value="budget">
                        <label class="btn btn-outline-primary" for="journeyBudget">Budget</label>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Travel Request Status -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Request Status Distribution
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Charts Row -->
    <div class="row mb-4">
        <!-- Budget by User -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Budget by User (This Year)
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="budgetChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Destinations -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>Top Destinations (This Year)
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="destinationChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.travel-requests.index') }}?status=pending"
                               class="btn btn-warning w-100">
                                <i class="fas fa-clock me-2"></i>Review Pending Requests
                                @if($stats['pending_requests'] > 0)
                                    <span class="badge bg-light text-dark ms-2">{{ $stats['pending_requests'] }}</span>
                                @endif
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('users.index') }}" class="btn btn-primary w-100">
                                <i class="fas fa-users me-2"></i>Manage Users
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.reports.index') }}" class="btn btn-success w-100">
                                <i class="fas fa-file-export me-2"></i>Export Reports
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.app-configurations.index') }}" class="btn btn-info w-100">
                                <i class="fas fa-cog me-2"></i>App Settings
                            </a>
                        </div>
                    </div>
>>>>>>> 4b0d94f (feat: implement travel request management system)
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
@endsection
=======
</div>

@push('styles')
<style>
.chart-container {
    position: relative;
    height: 300px;
}

.card-header .btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.775rem;
}

.opacity-75 {
    opacity: 0.75;
}
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data from Laravel
    const monthlyData = @json($monthlyData);
    const budgetAnalysis = @json($budgetAnalysis);
    const statusDistribution = @json($statusDistribution);
    const topDestinations = @json($topDestinations);

    // Chart.js default settings
    Chart.defaults.font.family = "'Open Sans', sans-serif";
    Chart.defaults.color = '#6c757d';

    // Monthly Journey Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyData.labels,
            datasets: [{
                label: 'Number of Journeys',
                data: monthlyData.journeys,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Chart type switcher for monthly chart
    document.querySelectorAll('input[name="chartType"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'journeys') {
                monthlyChart.data.datasets[0] = {
                    label: 'Number of Journeys',
                    data: monthlyData.journeys,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4,
                    fill: true
                };
            } else {
                monthlyChart.data.datasets[0] = {
                    label: 'Budget (IDR)',
                    data: monthlyData.budget,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4,
                    fill: true
                };
            }
            monthlyChart.update();
        });
    });

    // Status Distribution Pie Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusDistribution.labels,
            datasets: [{
                data: statusDistribution.data,
                backgroundColor: statusDistribution.colors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Budget by User Bar Chart
    const budgetCtx = document.getElementById('budgetChart').getContext('2d');
    new Chart(budgetCtx, {
        type: 'bar',
        data: {
            labels: budgetAnalysis.labels,
            datasets: [{
                label: 'Total Budget (IDR)',
                data: budgetAnalysis.data,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });

    // Top Destinations Horizontal Bar Chart
    const destinationCtx = document.getElementById('destinationChart').getContext('2d');
    new Chart(destinationCtx, {
        type: 'bar',
        data: {
            labels: topDestinations.labels,
            datasets: [{
                label: 'Number of Trips',
                data: topDestinations.data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(201, 203, 207, 0.8)',
                    'rgba(255, 99, 255, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Auto-refresh charts every 5 minutes
    setInterval(function() {
        fetch('{{ route("admin.dashboard") }}')
            .then(response => response.text())
            .then(html => {
                // Charts will be refreshed when page reloads
                console.log('Dashboard data refreshed');
            })
            .catch(error => console.error('Error refreshing dashboard:', error));
    }, 300000); // 5 minutes
});
</script>
@endpush
@endsection
>>>>>>> 4b0d94f (feat: implement travel request management system)
