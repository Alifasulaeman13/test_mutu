@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
            <div>
            <h1 class="text-2xl font-bold text-gray-800">Master Dimensi Mutu</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola data dimensi mutu sistem</p>
        </div>
        <a href="{{ route('dimensi_mutu.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-sm">
            <i class="ri-add-line mr-2"></i>
            Tambah Data
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <x-table-paginate :data="$data">
            <x-slot name="head">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Nama</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @forelse($data as $item)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $loop->iteration + ($data->firstItem() - 1) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $item->nama }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                        <div class="flex justify-end">
                            <x-action-buttons 
                                :edit-url="route('dimensi_mutu.edit', $item->id)" 
                                :delete-url="route('dimensi_mutu.destroy', $item->id)" 
                                confirm="Apakah Anda yakin ingin menghapus data ini?" 
                            />
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 bg-gray-50">
                        <div class="flex flex-col items-center justify-center py-6">
                            <i class="ri-inbox-line text-4xl text-gray-400 mb-2"></i>
                            <p>Data tidak ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </x-slot>
        </x-table-paginate>
    </div>
</div>
<x-sweet-alert />
@endsection
