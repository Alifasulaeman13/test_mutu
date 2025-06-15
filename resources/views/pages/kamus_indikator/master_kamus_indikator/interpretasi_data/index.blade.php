@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Master Interpretasi Data</h1>
        <a href="{{ route('interpretasi_data.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="ri-add-line mr-2"></i>Tambah Data
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <x-table-paginate :data="$data">
            <x-slot name="head">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @forelse($data as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration + ($data->firstItem() - 1) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <x-action-buttons :edit-url="route('interpretasi_data.edit', $item->id)" :delete-url="route('interpretasi_data.destroy', $item->id)" confirm="Apakah Anda yakin ingin menghapus data ini?" />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500 py-4">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </x-slot>
        </x-table-paginate>
    </div>
</div>
<x-sweet-alert />
@endsection
