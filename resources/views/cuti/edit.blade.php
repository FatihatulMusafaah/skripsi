@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Pengajuan Cuti</h2>
        <a href="{{ route('cuti.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">&larr; Kembali</a>
    </div>

    <form action="{{ route('cuti.update', $cuti->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pegawai</label>
            <select name="pegawai_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @foreach ($pegawai as $p)
                <option value="{{ $p->id }}" {{ $cuti->nama == $p->id ? 'selected' : '' }}>
                    {{ $p->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ $cuti->tanggal_mulai }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ $cuti->tanggal_selesai }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Alasan</label>
            <textarea name="alasan" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $cuti->alasan }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
            <select name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="pending" {{ $cuti->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="disetujui" {{ $cuti->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ $cuti->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-200">
                Update Pengajuan
            </button>
        </div>
    </form>
</div>
@endsection