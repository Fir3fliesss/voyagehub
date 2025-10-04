@extends('layouts.admin')

<<<<<<< HEAD
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Reports</h1>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-4">Filter Reports</h2>
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ request('start_date', \Carbon\Carbon::now()->subMonths(6)->format('Y-m-d')) }}">
            </div>
            <div>
                <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ request('end_date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Apply Filter
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Trips and Expenses Over Time</h2>
            <div id="tripsExpensesChart"></div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">User Registration Growth</h2>
            <div id="userRegistrationChart"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Top 10 Users by Trips</h2>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">User</th>
                        <th class="py-2 px-4 border-b">Total Trips</th>
                        <th class="py-2 px-4 border-b">Total Expenses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topUsers as $user)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->trips_count }}</td>
                        <td class="py-2 px-4 border-b">{{ number_format($user->trips_sum_cost, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Trip Status Distribution</h2>
            <div id="tripStatusChart"></div>
=======
@section('title', 'Reports & Analytics')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Total Journeys</div>
                            <div class="h4">{{ $stats['total_journeys'] }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-route fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Total Requests</div>
                            <div class="h4">{{ $stats['total_requests'] }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-paper-plane fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Pending</div>
                            <div class="h4">{{ $stats['pending_requests'] }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Approved</div>
                            <div class="h4">{{ $stats['approved_requests'] }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">Total Budget</div>
                            <div class="h6">Rp {{ number_format($stats['total_budget'], 0, ',', '.') }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-money-bill fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small">This Month</div>
                            <div class="h4">{{ $stats['this_month_journeys'] }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Export Section -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-download me-2"></i>Quick Export
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            @foreach($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Export Journeys -->
                    <form action="{{ route('admin.reports.export-journeys') }}" method="POST" class="mb-4">
                        @csrf
                        <h6 class="mb-3">Export Journeys</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="journey_start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="journey_start_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="journey_end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="journey_end_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="journey_user_id" class="form-label">User</label>
                                <select name="user_id" id="journey_user_id" class="form-select">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->nik }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="journey_destination" class="form-label">Destination</label>
                                <input type="text" name="destination" id="journey_destination" class="form-control"
                                       placeholder="Enter destination...">
                            </div>
                            <div class="col-md-6">
                                <label for="journey_format" class="form-label">Format</label>
                                <select name="format" id="journey_format" class="form-select" required>
                                    <option value="excel">Excel (.xlsx)</option>
                                    <option value="pdf">PDF</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-download me-1"></i>Export Journeys
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- Export Travel Requests -->
                    <form action="{{ route('admin.reports.export-requests') }}" method="POST">
                        @csrf
                        <h6 class="mb-3">Export Travel Requests</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="request_status" class="form-label">Status</label>
                                <select name="status" id="request_status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="request_user_id" class="form-label">User</label>
                                <select name="user_id" id="request_user_id" class="form-select">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->nik }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="request_start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="request_start_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="request_end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="request_end_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="request_format" class="form-label">Format</label>
                                <select name="format" id="request_format" class="form-select" required>
                                    <option value="excel">Excel (.xlsx)</option>
                                    <option value="pdf">PDF</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-download me-1"></i>Export Requests
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Advanced Reports Section -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Advanced Reports
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reports.generate') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="report_type" class="form-label">Report Type</label>
                            <select name="report_type" id="report_type" class="form-select" required>
                                <option value="summary">Summary Report</option>
                                <option value="detailed">Detailed Report</option>
                                <option value="budget_analysis">Budget Analysis</option>
                            </select>
                            <div class="form-text">
                                <small>
                                    <strong>Summary:</strong> Overview statistics<br>
                                    <strong>Detailed:</strong> Complete journey and request data<br>
                                    <strong>Budget Analysis:</strong> Budget breakdown by user and destination
                                </small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="period" class="form-label">Period</label>
                            <select name="period" id="period" class="form-select" required>
                                <option value="this_month">This Month</option>
                                <option value="last_month">Last Month</option>
                                <option value="this_year">This Year</option>
                                <option value="custom">Custom Date Range</option>
                            </select>
                        </div>

                        <div id="customDateRange" style="display: none;">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="custom_start_date" class="form-label">Start Date</label>
                                    <input type="date" name="start_date" id="custom_start_date" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="custom_end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" id="custom_end_date" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="advanced_format" class="form-label">Format</label>
                            <select name="format" id="advanced_format" class="form-select" required>
                                <option value="excel">Excel (.xlsx)</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-file-alt me-1"></i>Generate Report
                        </button>
                    </form>
                </div>
            </div>

            <!-- Report Templates Section -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-contract me-2"></i>Report Templates
                    </h5>
                </div>
                <div class="card-body">
                    @if($reportTemplates->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($reportTemplates as $template)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $template->name }}</h6>
                                        <small class="text-muted">
                                            {{ ucfirst($template->type) }} template
                                            @if($template->is_default)
                                                <span class="badge bg-primary ms-1">Default</span>
                                            @endif
                                        </small>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#templateModal{{ $template->id }}">
                                            <i class="fas fa-download"></i> Use Template
                                        </button>
                                    </div>
                                </div>

                                <!-- Template Modal -->
                                <div class="modal fade" id="templateModal{{ $template->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.reports.template') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="template_id" value="{{ $template->id }}">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Generate from {{ $template->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="template_start_date_{{ $template->id }}" class="form-label">Start Date (Optional)</label>
                                                        <input type="date" name="start_date" id="template_start_date_{{ $template->id }}" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="template_end_date_{{ $template->id }}" class="form-label">End Date (Optional)</label>
                                                        <input type="date" name="end_date" id="template_end_date_{{ $template->id }}" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="template_user_id_{{ $template->id }}" class="form-label">User Filter (Optional)</label>
                                                        <select name="user_id" id="template_user_id_{{ $template->id }}" class="form-select">
                                                            <option value="">All Users</option>
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->nik }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-download me-1"></i>Generate {{ ucfirst($template->type) }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-file-contract fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No report templates configured</p>
                        </div>
                    @endif
                </div>
            </div>
>>>>>>> 4b0d94f (feat: implement travel request management system)
        </div>
    </div>
</div>

@push('scripts')
<<<<<<< HEAD
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Trips and Expenses Over Time Chart
        var tripsExpensesOptions = {
            series: [{
                name: 'Total Trips',
                data: @json($tripsOverTime->pluck('total_trips'))
            }, {
                name: 'Total Expenses',
                data: @json($tripsOverTime->pluck('total_expenses'))
            }],
            chart: {
                height: 350,
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: @json($tripsOverTime->pluck('date'))
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy'
                },
            },
        };
        var tripsExpensesChart = new ApexCharts(document.querySelector("#tripsExpensesChart"), tripsExpensesOptions);
        tripsExpensesChart.render();

        // User Registration Growth Chart
        var userRegistrationOptions = {
            series: [{
                name: 'New Users',
                data: @json($userRegistrations->pluck('total_users'))
            }],
            chart: {
                height: 350,
                type: 'bar'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($userRegistrations->pluck('date'))
            },
            yaxis: {
                title: {
                    text: '# of Users'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " users"
                    }
                }
            }
        };
        var userRegistrationChart = new ApexCharts(document.querySelector("#userRegistrationChart"), userRegistrationOptions);
        userRegistrationChart.render();

        // Trip Status Distribution Chart
        var tripStatusOptions = {
            series: @json($tripStatus->pluck('count')),
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: @json($tripStatus->pluck('status')),
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var tripStatusChart = new ApexCharts(document.querySelector("#tripStatusChart"), tripStatusOptions);
        tripStatusChart.render();
    });
</script>
@endpush
=======
<script>
document.addEventListener('DOMContentLoaded', function() {
    const periodSelect = document.getElementById('period');
    const customDateRange = document.getElementById('customDateRange');

    periodSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            customDateRange.style.display = 'block';
            document.getElementById('custom_start_date').required = true;
            document.getElementById('custom_end_date').required = true;
        } else {
            customDateRange.style.display = 'none';
            document.getElementById('custom_start_date').required = false;
            document.getElementById('custom_end_date').required = false;
        }
    });

    // Set default dates
    const today = new Date();
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);

    document.getElementById('journey_start_date').value = firstDayOfMonth.toISOString().split('T')[0];
    document.getElementById('journey_end_date').value = today.toISOString().split('T')[0];
    document.getElementById('request_start_date').value = firstDayOfMonth.toISOString().split('T')[0];
    document.getElementById('request_end_date').value = today.toISOString().split('T')[0];
});
</script>
@endpush
@endsection
>>>>>>> 4b0d94f (feat: implement travel request management system)
