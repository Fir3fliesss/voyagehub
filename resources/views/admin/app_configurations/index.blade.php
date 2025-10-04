<<<<<<< HEAD
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konfigurasi Aplikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.app-configurations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Konfigurasi
                        </a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organisasi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kunci</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($configurations as $config)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $config->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $config->organization->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $config->key }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $config->value }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.app-configurations.edit', $config->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('admin.app-configurations.destroy', $config->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4" onclick="return confirm('Apakah Anda yakin ingin menghapus konfigurasi ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
=======
@extends('layouts.admin')

@section('title', 'App Configurations')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">App Configurations</h3>
                    <a href="{{ route('admin.app-configurations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Configuration
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($configurations->count() > 0)
                        <form action="{{ route('admin.app-configurations.bulk-update') }}" method="POST" id="bulk-form">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Configuration Key</th>
                                            <th>Current Value</th>
                                            <th>New Value</th>
                                            <th>Last Updated</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($configurations as $key => $configs)
                                            @php $config = $configs->first(); @endphp
                                            <tr>
                                                <td>
                                                    <strong>{{ $key }}</strong>
                                                    <input type="hidden" name="configurations[{{ $loop->index }}][key]" value="{{ $key }}">
                                                </td>
                                                <td>
                                                    @if($key === 'primary_color' || $key === 'secondary_color')
                                                        <div class="d-flex align-items-center">
                                                            <div class="color-preview" style="width: 30px; height: 30px; background-color: {{ $config->value }}; border: 1px solid #ddd; margin-right: 10px;"></div>
                                                            <code>{{ $config->value }}</code>
                                                        </div>
                                                    @elseif($key === 'logo_path')
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $config->value }}" alt="Logo" style="max-height: 30px; margin-right: 10px;" onerror="this.style.display='none'">
                                                            <code>{{ $config->value }}</code>
                                                        </div>
                                                    @else
                                                        {{ $config->value }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($key === 'primary_color' || $key === 'secondary_color')
                                                        <input type="color" class="form-control form-control-color"
                                                               name="configurations[{{ $loop->index }}][value]"
                                                               value="{{ $config->value }}"
                                                               style="width: 60px;">
                                                    @else
                                                        <input type="text" class="form-control"
                                                               name="configurations[{{ $loop->index }}][value]"
                                                               value="{{ $config->value }}"
                                                               placeholder="Enter new value">
                                                    @endif
                                                </td>
                                                <td>{{ $config->updated_at->format('Y-m-d H:i') }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.app-configurations.edit', $config) }}"
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.app-configurations.destroy', $config) }}"
                                                              method="POST"
                                                              style="display: inline;"
                                                              onsubmit="return confirm('Are you sure you want to delete this configuration?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update All Configurations
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="location.reload()">
                                    <i class="fas fa-undo"></i> Reset Changes
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-cog fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No Configurations Found</h4>
                            <p class="text-muted">Start by creating your first app configuration.</p>
                            <a href="{{ route('admin.app-configurations.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Configuration
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            @if($configurations->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Live Preview</h4>
                    </div>
                    <div class="card-body">
                        <div class="preview-container" style="border: 2px dashed #ddd; padding: 20px; border-radius: 8px;">
                            <div class="preview-header" style="background: linear-gradient(135deg, {{ $configurations->get('primary_color')?->first()?->value ?? '#2563eb' }}, {{ $configurations->get('secondary_color')?->first()?->value ?? '#64748b' }}); color: white; padding: 15px; border-radius: 6px; margin-bottom: 15px;">
                                <h3 style="margin: 0;">{{ $configurations->get('app_name')?->first()?->value ?? 'VoyageHub' }}</h3>
                            </div>
                            <div class="preview-content">
                                <p><strong>Primary Color:</strong> {{ $configurations->get('primary_color')?->first()?->value ?? '#2563eb' }}</p>
                                <p><strong>Secondary Color:</strong> {{ $configurations->get('secondary_color')?->first()?->value ?? '#64748b' }}</p>
                                <p><strong>Footer:</strong> {{ $configurations->get('footer_text')?->first()?->value ?? '© 2025 Company. All rights reserved.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live preview update for color inputs
    const colorInputs = document.querySelectorAll('input[type="color"]');
    colorInputs.forEach(input => {
        input.addEventListener('change', function() {
            const key = this.name.includes('primary_color') ? 'primary_color' : 'secondary_color';
            updatePreview();
        });
    });

    // Live preview update for text inputs
    const textInputs = document.querySelectorAll('input[type="text"]');
    textInputs.forEach(input => {
        input.addEventListener('input', function() {
            updatePreview();
        });
    });

    function updatePreview() {
        const appName = document.querySelector('input[name*="app_name"]')?.value || 'VoyageHub';
        const primaryColor = document.querySelector('input[name*="primary_color"]')?.value || '#2563eb';
        const secondaryColor = document.querySelector('input[name*="secondary_color"]')?.value || '#64748b';
        const footerText = document.querySelector('input[name*="footer_text"]')?.value || '© 2025 Company. All rights reserved.';

        const previewHeader = document.querySelector('.preview-header');
        const previewContent = document.querySelector('.preview-content');

        if (previewHeader) {
            previewHeader.style.background = `linear-gradient(135deg, ${primaryColor}, ${secondaryColor})`;
            previewHeader.querySelector('h3').textContent = appName;
        }

        if (previewContent) {
            previewContent.innerHTML = `
                <p><strong>Primary Color:</strong> ${primaryColor}</p>
                <p><strong>Secondary Color:</strong> ${secondaryColor}</p>
                <p><strong>Footer:</strong> ${footerText}</p>
            `;
        }
    }
});
</script>
@endsection
>>>>>>> 4b0d94f (feat: implement travel request management system)
