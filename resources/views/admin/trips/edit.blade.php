{{-- resources/views/admin/trips/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="content-area">
    <h1>Edit Trip</h1>

    <form action="{{ route('admin.trips.update', $trip) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Trip Title</label>
            <input type="text" name="title" value="{{ old('title', $trip->title) }}" required>
        </div>

        <div class="form-group">
            <label>Destination</label>
            <input type="text" name="destination" value="{{ old('destination', $trip->destination) }}" required>
        </div>

        <div class="form-group">
            <label>Start Date</label>
            <input type="date" name="start_date" value="{{ old('start_date', $trip->start_date) }}" required>
        </div>

        <div class="form-group">
            <label>End Date</label>
            <input type="date" name="end_date" value="{{ old('end_date', $trip->end_date) }}">
        </div>

        <div class="form-group">
            <label>Transportation</label>
            <input type="text" name="transport" value="{{ old('transport', $trip->transport) }}">
        </div>

        <div class="form-group">
            <label>Accommodation</label>
            <input type="text" name="accommodation" value="{{ old('accommodation', $trip->accommodation) }}">
        </div>

        <div class="form-group">
            <label>Budget (IDR)</label>
            <input type="number" name="budget" value="{{ old('budget', $trip->budget) }}">
        </div>

        <div class="form-group">
            <label>Assign to User</label>
            <select name="user_id">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $trip->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->role }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Notes</label>
            <textarea name="notes" rows="4">{{ old('notes', $trip->notes) }}</textarea>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Trip</button>
        </div>
    </form>
</div>
@endsection
