@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Interpretasi Data</h1>
        <a href="{{ route('interpretasi_data.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="ri-arrow-left-line mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('interpretasi_data.update', $interpretasi->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <x-form-input label="Nama" name="nama" type="text" :value="$interpretasi->nama" required />
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="ri-save-line mr-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
