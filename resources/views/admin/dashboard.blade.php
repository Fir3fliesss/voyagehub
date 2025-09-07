@extends('layouts.admin')

@section('content')
<div class="content-area">
    <h1>Admin Dashboard</h1>

    <div class="stats">
        <div class="card">Total Users: {{ $totalUsers }}</div>
        <div class="card">Total Trips: {{ $totalTrips }}</div>
        <div class="card">Upcoming Trips: {{ $upcomingTrips }}</div>
    </div>
</div>
@endsection
