<<<<<<< HEAD
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Konfigurasi Aplikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.app-configurations.update', $appConfiguration->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="organization_id" class="block text-sm font-medium text-gray-700">Organisasi</label>
                            <select name="organization_id" id="organization_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ $appConfiguration->organization_id == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                                @endforeach
                            </select>
                            @error('organization_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="key" class="block text-sm font-medium text-gray-700">Kunci</label>
                            <input type="text" name="key" id="key" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('key', $appConfiguration->key) }}">
                            @error('key')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="value" class="block text-sm font-medium text-gray-700">Nilai</label>
                            <textarea name="value" id="value" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('value', $appConfiguration->value) }}</textarea>
                            @error('value')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Perbarui
=======
@extends('layouts.admin')

@section('title', 'Edit Configuration')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Configuration: {{ $appConfiguration->key }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.app-configurations.update', $appConfiguration) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="key" class="form-label">Configuration Key</label>
                            <input type="text"
                                   class="form-control @error('key') is-invalid @enderror"
                                   id="key"
                                   name="key"
                                   value="{{ old('key', $appConfiguration->key) }}"
                                   required>
                            @error('key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="value" class="form-label">Configuration Value</label>
                            <div id="value-input-container">
                                @if(str_contains($appConfiguration->key, 'color'))
                                    <div class="input-group">
                                        <input type="color"
                                               class="form-control form-control-color @error('value') is-invalid @enderror"
                                               id="value"
                                               name="value"
                                               value="{{ old('value', $appConfiguration->value) }}">
                                        <input type="text"
                                               class="form-control"
                                               id="value-text"
                                               value="{{ old('value', $appConfiguration->value) }}"
                                               pattern="^#[0-9A-Fa-f]{6}$"
                                               placeholder="#000000">
                                    </div>
                                @elseif($appConfiguration->key === 'footer_text')
                                    <textarea class="form-control @error('value') is-invalid @enderror"
                                              id="value"
                                              name="value"
                                              rows="3">{{ old('value', $appConfiguration->value) }}</textarea>
                                @else
                                    <input type="text"
                                           class="form-control @error('value') is-invalid @enderror"
                                           id="value"
                                           name="value"
                                           value="{{ old('value', $appConfiguration->value) }}">
                                @endif
                            </div>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($appConfiguration->key === 'app_name')
                                <div class="form-text">The application name displayed in the header</div>
                            @elseif(str_contains($appConfiguration->key, 'color'))
                                <div class="form-text">Select a color or enter a hex color code</div>
                            @elseif($appConfiguration->key === 'logo_path')
                                <div class="form-text">Path to your logo image (e.g., /images/logo.png)</div>
                            @elseif($appConfiguration->key === 'footer_text')
                                <div class="form-text">Footer text displayed at the bottom of pages</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Organization ID</label>
                            <input type="text" class="form-control" value="{{ $appConfiguration->organization_id }}" readonly>
                            <div class="form-text">Organization ID cannot be changed</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Last Updated</label>
                            <input type="text" class="form-control" value="{{ $appConfiguration->updated_at->format('Y-m-d H:i:s') }}" readonly>
                        </div>

                        @if(str_contains($appConfiguration->key, 'color') || $appConfiguration->key === 'app_name')
                            <div class="mb-3">
                                <label class="form-label">Preview</label>
                                <div class="preview-container" style="border: 2px dashed #ddd; padding: 15px; border-radius: 8px;">
                                    @if(str_contains($appConfiguration->key, 'color'))
                                        <div class="color-preview d-flex align-items-center">
                                            <div style="width: 50px; height: 50px; background-color: {{ $appConfiguration->value }}; border: 1px solid #ddd; margin-right: 15px; border-radius: 4px;"></div>
                                            <div>
                                                <strong>{{ ucfirst(str_replace('_', ' ', $appConfiguration->key)) }}</strong><br>
                                                <code>{{ $appConfiguration->value }}</code>
                                            </div>
                                        </div>
                                    @elseif($appConfiguration->key === 'app_name')
                                        <div class="app-name-preview" style="background: linear-gradient(135deg, #2563eb, #64748b); color: white; padding: 15px; border-radius: 6px;">
                                            <h4 style="margin: 0;">{{ $appConfiguration->value }}</h4>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.app-configurations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Configuration
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

@if(str_contains($appConfiguration->key, 'color'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorInput = document.getElementById('value');
    const textInput = document.getElementById('value-text');
    const preview = document.querySelector('.color-preview div:first-child');

    function updatePreview(color) {
        if (preview) {
            preview.style.backgroundColor = color;
        }
        const codeElement = document.querySelector('.color-preview code');
        if (codeElement) {
            codeElement.textContent = color;
        }
    }

    if (colorInput && textInput) {
        colorInput.addEventListener('change', function() {
            textInput.value = this.value;
            updatePreview(this.value);
        });

        textInput.addEventListener('input', function() {
            if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                colorInput.value = this.value;
                updatePreview(this.value);
            }
        });
    }
});
</script>
@endif

@if($appConfiguration->key === 'app_name')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('value');
    const preview = document.querySelector('.app-name-preview h4');

    if (nameInput && preview) {
        nameInput.addEventListener('input', function() {
            preview.textContent = this.value || 'VoyageHub';
        });
    }
});
</script>
@endif
@endsection
>>>>>>> 4b0d94f (feat: implement travel request management system)
