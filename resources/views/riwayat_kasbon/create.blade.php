@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Tambah Riwayat Kasbon</h2>
        <a href="{{ route('riwayat-kasbon.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">&larr; Kembali</a>
    </div>

    <form action="{{ route('riwayat-kasbon.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pegawai</label>
            <select name="pegawai_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">-- Pilih Pegawai --</option>
                @foreach ($pegawai as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Total Kasbon</label>
            <input type="number" name="total_kasbon" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan total kasbon" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kasbon Dibayar</label>
            <input type="number" name="kasbon_dibayar" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan jumlah yang dibayar" required>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tenor (Bulan)</label>
                <input type="number" name="lama_cicilan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: 12" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Sisa Tenor (Bulan)</label>
                <input type="number" name="sisa_cicilan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: 10" required>
            </div>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-200">
                Simpan Riwayat
            </button>
        </div>
    </form>
</div>
@endsection
