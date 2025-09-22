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