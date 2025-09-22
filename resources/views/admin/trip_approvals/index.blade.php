<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Persetujuan Perjalanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Perjalanan Menunggu Persetujuan</h3>

                    @if ($trips->isEmpty())
                        <p>Tidak ada perjalanan yang menunggu persetujuan.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perjalanan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biaya</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($trips as $trip)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $trip->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $trip->journey->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $trip->date->format('d M Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $trip->destination }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($trip->cost, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($trip->status) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('admin.trip_approvals.approve', $trip) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Setujui</button>
                                                </form>
                                                <form action="{{ route('admin.trip_approvals.reject', $trip) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>