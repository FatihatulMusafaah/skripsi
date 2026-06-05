@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Pengajuan Cuti</h2>
        <a href="{{ route('cuti.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
            + Ajukan Cuti
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
                    <th class="py-3 px-6 text-left">Nama Pegawai</th>
                    <th class="py-3 px-6 text-left">Mulai</th>
                    <th class="py-3 px-6 text-left">Selesai</th>
                    <th class="py-3 px-6 text-left">Alasan</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($cuti as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6 text-left font-medium">{{ $item->nama_pegawai ?? ($item->user->name ?? '-') }}</td>
                        <td class="py-3 px-6 text-left">{{ $item->tanggal_mulai }}</td>
                        <td class="py-3 px-6 text-left">{{ $item->tanggal_selesai }}</td>
                        <td class="py-3 px-6 text-left">{{ $item->alasan }}</td>
                        <td class="py-3 px-6 text-left">
                            <span class="px-2 py-1 rounded text-xs font-bold 
                                {{ $item->status == 'disetujui' ? 'bg-green-200 text-green-700' : (strtolower($item->status) == 'pending' ? 'bg-yellow-200 text-yellow-700' : 'bg-red-200 text-red-700') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center gap-2">
                                @if($item->status == 'Pending')
                                    <form action="{{ route('cuti.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-bold">
                                            Setujui
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('cuti.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data pengajuan cuti ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold ml-2">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-gray-500 italic">Data pengajuan cuti belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
