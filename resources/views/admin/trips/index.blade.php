{{-- resources/views/admin/trips/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="content-area">
    <h1>Manage Trips</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Trip Title</th>
                <th>Destination</th>
                <th>User</th>
                <th>Dates</th>
                <th>Budget</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($trips as $trip)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $trip->title }}</td>
                    <td>{{ $trip->destination }}</td>
                    <td>{{ $trip->user->name }}</td>
                    <td>{{ $trip->start_date }} - {{ $trip->end_date ?? '-' }}</td>
                    <td>{{ $trip->budget ? 'Rp '.number_format($trip->budget,0,',','.') : '-' }}</td>
                    <td>
                        <a href="{{ route('admin.trips.show', $trip) }}" class="btn btn-sm btn-primary">View</a>
                        <a href="{{ route('admin.trips.edit', $trip) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form action="{{ route('admin.trips.destroy', $trip) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this trip?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No trips found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:16px;">
        {{ $trips->links() }}
    </div>
</div>
@endsection
