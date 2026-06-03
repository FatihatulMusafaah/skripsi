@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Pegawai</h2>
        <a href="{{ route('pegawai.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
            + Tambah Pegawai
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">No</th>
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Role</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($pegawai as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6 text-left font-medium">{{ $item->name }}</td>
                        <td class="py-3 px-6 text-left">{{ $item->email }}</td>
                        <td class="py-3 px-6 text-left">
                            <span class="px-2 py-1 rounded text-xs font-bold 
                                {{ $item->role == 'admin' ? 'bg-purple-200 text-purple-700' : 
                                   ($item->role == 'owner' ? 'bg-orange-200 text-orange-700' : 'bg-blue-200 text-blue-700') }}">
                                {{ ucfirst($item->role) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center gap-2">
                                <a href="{{ route('pegawai.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">
                                    Edit
                                </a>
                                <form action="{{ route('pegawai.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500 italic">Data pegawai belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
