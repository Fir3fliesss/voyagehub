@extends('layouts.main')

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
                </div>
            </div>
        </div>
    </div>
@endsection
