@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Data Kasbon</h2>
        <a href="{{ route('kasbon.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">&larr; Kembali</a>
    </div>

    <form action="{{ route('kasbon.update', $kasbon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pegawai</label>
            <select name="pegawai_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @foreach ($pegawai as $p)
                <option value="{{ $p->id }}" {{ $kasbon->pegawai_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Kasbon (Rp)</label>
            <input type="number" name="jumlah_kasbon" value="{{ $kasbon->jumlah_kasbon }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="cicil_30" {{ $kasbon->metode_pembayaran == 'cicil_30' ? 'selected' : '' }}>Cicil (Potong Gaji 30%)</option>
                <option value="sekali_bayar" {{ $kasbon->metode_pembayaran == 'sekali_bayar' ? 'selected' : '' }}>Sekali Bayar (Lunas Bulan Depan)</option>
            </select>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-200">
                Update Kasbon
            </button>
        </div>
    </form>
</div>
@endsection
