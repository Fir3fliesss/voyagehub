@extends('layouts.main')

@section('content')
    <header class="main-header">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
            <h1 class="page-title">Add New Trip</h1>
        </div>
    </header>

    <div class="content-area">
        <form action="{{ route('journeys.store') }}" method="POST" class="trip-form">
            @csrf

            <!-- Trip Details -->
            <div class="form-group">
                <label for="title">Trip Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                @error('title') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="destination">Destination</label>
                <input type="text" id="destination" name="destination" value="{{ old('destination') }}" required>
                @error('destination') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                @error('start_date') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}">
                @error('end_date') <small class="error">{{ $message }}</small> @enderror
            </div>

            <!-- Transportation & Accommodation -->
            <div class="form-group">
                <label for="transport">Transportation</label>
                <input type="text" id="transport" name="transport" value="{{ old('transport') }}">
            </div>

            <div class="form-group">
                <label for="accommodation">Accommodation</label>
                <input type="text" id="accommodation" name="accommodation" value="{{ old('accommodation') }}">
            </div>

            <!-- Budget -->
            <div class="form-group">
                <label for="budget">Budget</label>
                <input type="number" id="budget" name="budget" step="0.01" value="{{ old('budget') }}">
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label for="notes">Additional Notes</label>
                <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Trip</button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
