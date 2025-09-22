@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">App Configurations</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.app-configurations.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="app_name" class="block text-gray-700 text-sm font-bold mb-2">App Name:</label>
                <input type="text" name="app_name" id="app_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('app_name', config('app.name')) }}">
                @error('app_name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="items_per_page" class="block text-gray-700 text-sm font-bold mb-2">Items Per Page:</label>
                <input type="number" name="items_per_page" id="items_per_page" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('items_per_page', config('app.items_per_page')) }}">
                @error('items_per_page')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Configurations
                </button>
            </div>
        </form>
    </div>
</div>
@endsection