@extends('layouts.admin_main')

@section('title', 'Trip Management')

@section('content')
    <div class="content-header mb-4">
        <h1 class="page-title">Trip Management</h1>
        <form action="{{ route('admin.trips.index') }}" method="GET" class="form-inline">
            <div class="form-group mr-2">
                <label for="dateFilter" class="sr-only">Filter by Date</label>
                <input type="date" class="form-control" id="dateFilter" name="date" value="{{ request('date') }}">
            </div>
            <div class="form-group mr-2">
                <label for="searchFilter" class="sr-only">Search</label>
                <input type="text" class="form-control" id="searchFilter" name="search" placeholder="Search by location or description" value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    }

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
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
                    <td>{{ $trip->id }}</td>
                    <td>{{ $trip->user->name }}</td>
                    <td>{{ $trip->date }}</td>
                    <td>{{ $trip->location }}</td>
                    <td>{{ $trip->description }}</td>
                    <td class="action-buttons">
                        <a href="#" class="btn btn-secondary">Edit</a>
                        <form action="#" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this trip?');">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    {{ $trips->links() }}
    </div>
@endsection