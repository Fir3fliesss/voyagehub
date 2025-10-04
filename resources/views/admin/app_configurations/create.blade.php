<<<<<<< HEAD
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Konfigurasi Aplikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.app-configurations.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="organization_id" class="block text-sm font-medium text-gray-700">Organisasi</label>
                            <select name="organization_id" id="organization_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                @endforeach
                            </select>
                            @error('organization_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="key" class="block text-sm font-medium text-gray-700">Kunci</label>
                            <input type="text" name="key" id="key" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('key') }}">
                            @error('key')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="value" class="block text-sm font-medium text-gray-700">Nilai</label>
                            <textarea name="value" id="value" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('value') }}</textarea>
                            @error('value')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Simpan
=======
@extends('layouts.admin')

@section('title', 'Create Configuration')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Configuration</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.app-configurations.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="organization_id" class="form-label">Organization ID</label>
                            <input type="number"
                                   class="form-control @error('organization_id') is-invalid @enderror"
                                   id="organization_id"
                                   name="organization_id"
                                   value="{{ old('organization_id', 1) }}"
                                   required>
                            @error('organization_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="key" class="form-label">Configuration Key</label>
                            <select class="form-select @error('key') is-invalid @enderror"
                                    id="key"
                                    name="key"
                                    required
                                    onchange="updateValueInput()">
                                <option value="">Select configuration key</option>
                                <option value="app_name" {{ old('key') == 'app_name' ? 'selected' : '' }}>App Name</option>
                                <option value="primary_color" {{ old('key') == 'primary_color' ? 'selected' : '' }}>Primary Color</option>
                                <option value="secondary_color" {{ old('key') == 'secondary_color' ? 'selected' : '' }}>Secondary Color</option>
                                <option value="logo_path" {{ old('key') == 'logo_path' ? 'selected' : '' }}>Logo Path</option>
                                <option value="footer_text" {{ old('key') == 'footer_text' ? 'selected' : '' }}>Footer Text</option>
                                <option value="custom" {{ old('key') == 'custom' ? 'selected' : '' }}>Custom Key</option>
                            </select>
                            @error('key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="custom-key-group" style="display: none;">
                            <label for="custom_key" class="form-label">Custom Key Name</label>
                            <input type="text"
                                   class="form-control"
                                   id="custom_key"
                                   placeholder="Enter custom key name">
                        </div>

                        <div class="mb-3">
                            <label for="value" class="form-label">Configuration Value</label>
                            <div id="value-input-container">
                                <input type="text"
                                       class="form-control @error('value') is-invalid @enderror"
                                       id="value"
                                       name="value"
                                       value="{{ old('value') }}"
                                       placeholder="Enter configuration value">
                            </div>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text" id="value-help">
                                Enter the value for this configuration.
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.app-configurations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Configuration
>>>>>>> 4b0d94f (feat: implement travel request management system)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
</x-admin-layout>
=======
</div>

<script>
function updateValueInput() {
    const keySelect = document.getElementById('key');
    const valueContainer = document.getElementById('value-input-container');
    const valueHelp = document.getElementById('value-help');
    const customKeyGroup = document.getElementById('custom-key-group');
    const customKeyInput = document.getElementById('custom_key');

    const selectedKey = keySelect.value;

    // Handle custom key input
    if (selectedKey === 'custom') {
        customKeyGroup.style.display = 'block';
        customKeyInput.addEventListener('input', function() {
            keySelect.name = 'key_temp';
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'key';
            hiddenInput.value = this.value;
            hiddenInput.id = 'hidden-key';

            const existingHidden = document.getElementById('hidden-key');
            if (existingHidden) {
                existingHidden.remove();
            }

            keySelect.parentNode.appendChild(hiddenInput);
        });
    } else {
        customKeyGroup.style.display = 'none';
        keySelect.name = 'key';
        const existingHidden = document.getElementById('hidden-key');
        if (existingHidden) {
            existingHidden.remove();
        }
    }

    // Update input type based on selected key
    let inputHtml = '';
    let helpText = '';

    switch(selectedKey) {
        case 'primary_color':
        case 'secondary_color':
            inputHtml = `
                <div class="input-group">
                    <input type="color" class="form-control form-control-color" id="value" name="value" value="{{ old('value', '#2563eb') }}">
                    <input type="text" class="form-control" id="value-text" placeholder="#000000" pattern="^#[0-9A-Fa-f]{6}$">
                </div>
            `;
            helpText = 'Select a color or enter a hex color code (e.g., #2563eb)';
            break;

        case 'app_name':
            inputHtml = `<input type="text" class="form-control" id="value" name="value" value="{{ old('value') }}" placeholder="Your Company Name - VoyageHub">`;
            helpText = 'Enter the application name that will be displayed in the header';
            break;

        case 'logo_path':
            inputHtml = `<input type="text" class="form-control" id="value" name="value" value="{{ old('value') }}" placeholder="/images/logo.png">`;
            helpText = 'Enter the path to your logo image (e.g., /images/logo.png)';
            break;

        case 'footer_text':
            inputHtml = `<textarea class="form-control" id="value" name="value" rows="2" placeholder="© 2025 Your Company. All rights reserved.">{{ old('value') }}</textarea>`;
            helpText = 'Enter the footer text that will appear at the bottom of pages';
            break;

        default:
            inputHtml = `<input type="text" class="form-control" id="value" name="value" value="{{ old('value') }}" placeholder="Enter configuration value">`;
            helpText = 'Enter the value for this configuration';
    }

    valueContainer.innerHTML = inputHtml;
    valueHelp.textContent = helpText;

    // Add color sync functionality
    if (selectedKey.includes('color')) {
        const colorInput = document.getElementById('value');
        const textInput = document.getElementById('value-text');

        colorInput.addEventListener('change', function() {
            textInput.value = this.value;
        });

        textInput.addEventListener('input', function() {
            if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                colorInput.value = this.value;
            }
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateValueInput();
});
</script>
@endsection
>>>>>>> 4b0d94f (feat: implement travel request management system)
