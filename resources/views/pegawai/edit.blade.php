@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Pegawai</h2>
        <a href="{{ route('pegawai.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">&larr; Kembali</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name', $pegawai->name) }}" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" 
                   placeholder="Masukkan nama lengkap">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $pegawai->email) }}" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" 
                   placeholder="Masukkan alamat email">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password (Kosongkan jika tidak ingin diubah)</label>
            <input type="password" name="password" id="password" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" 
                   placeholder="Masukkan password baru">
        </div>

        <div class="mb-6">
            <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role</label>
            <select name="role" id="role" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('role') border-red-500 @enderror">
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role', $pegawai->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="owner" {{ old('role', $pegawai->role) == 'owner' ? 'selected' : '' }}>Owner</option>
                <option value="karyawan" {{ old('role', $pegawai->role) == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
            </select>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-200">
                Update Data
            </button>
        </div>
    </form>
</div>
@endsection
