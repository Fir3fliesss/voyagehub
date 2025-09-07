{{-- resources/views/admin/trips/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="content-area">
    <h1>Trip Detail</h1>

    <div class="card">
        <div class="card-header">
            <h2>{{ $trip->title }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Destination:</strong> {{ $trip->destination }}</p>
            <p><strong>User:</strong> {{ $trip->user->name }} ({{ $trip->user->email }})</p>
            <p><strong>Dates:</strong> {{ $trip->start_date }} → {{ $trip->end_date ?? 'Ongoing' }}</p>
            <p><strong>Transport:</strong> {{ $trip->transport ?? '-' }}</p>
            <p><strong>Accommodation:</strong> {{ $trip->accommodation ?? '-' }}</p>
            <p><strong>Budget:</strong> {{ $trip->budget ? 'Rp '.number_format($trip->budget,0,',','.') : '-' }}</p>
            <p><strong>Notes:</strong> {{ $trip->notes ?? '-' }}</p>
        </div>
    </div>

    <div style="margin-top:20px;">
        <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('admin.trips.edit', $trip) }}" class="btn btn-primary">Edit</a>
    </div>
</div>
@endsection
