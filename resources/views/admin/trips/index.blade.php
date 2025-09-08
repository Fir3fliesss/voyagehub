@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Trip Management</h1>
    <p class="mb-4">Manage all trips in the system.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Trips</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.trips.index') }}" method="GET" class="form-inline mb-3">
                <div class="form-group mr-2">
                    <label for="start_date" class="sr-only">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="form-group mr-2">
                    <label for="end_date" class="sr-only">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary ml-2">Clear Filter</a>
            </form>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trips as $trip)
                        <tr>
                            <td>{{ $trip->user->name }}</td>
                            <td>{{ $trip->date }}</td>
                            <td>{{ $trip->location }}</td>
                            <td>{{ $trip->description }}</td>
                            <td>
                                {{-- Add actions here if needed, e.g., view details, edit, delete --}}
                                <a href="#" class="btn btn-info btn-sm">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $trips->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
