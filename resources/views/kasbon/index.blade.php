@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Kasbon Pegawai</h2>
        <a href="{{ route('kasbon.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
            + Tambah Kasbon
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
                    <th class="py-3 px-6 text-left">Pegawai</th>
                    <th class="py-3 px-6 text-left">Total Kasbon</th>
                    <th class="py-3 px-6 text-left">Potongan/Bln</th>
                    <th class="py-3 px-6 text-left">Tenor</th>
                    <th class="py-3 px-6 text-left">Sisa</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($kasbon as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left font-medium">
                            {{ $item->user->name ?? '-' }}<br>
                            <span class="text-xs text-gray-400">{{ $item->created_at->format('d/m/Y') }}</span>
                        </td>
                        <td class="py-3 px-6 text-left">Rp {{ number_format($item->jumlah_kasbon, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-left">
                            Rp {{ number_format($item->potongan_per_bulan, 0, ',', '.') }}<br>
                            <span class="text-xs text-blue-500">({{ $item->persentase_potongan }}%)</span>
                        </td>
                        <td class="py-3 px-6 text-left">{{ $item->lama_cicilan }} Bln</td>
                        <td class="py-3 px-6 text-left font-bold">Rp {{ number_format($item->sisa_kasbon, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-left">
                            @php
                                $statusClass = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'aktif' => 'bg-green-100 text-green-700',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                    'lunas' => 'bg-gray-100 text-gray-700',
                                ][$item->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="px-2 py-1 rounded text-xs font-bold {{ $statusClass }}">
                                {{ strtoupper($item->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center gap-2">
                                @if($item->status == 'pending')
                                    <form action="{{ route('kasbon.setujui', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-800 font-bold text-xs" title="Setujui">
                                            SETUJUI
                                        </button>
                                    </form>
                                    <form action="{{ route('kasbon.tolak', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-xs" title="Tolak">
                                            TOLAK
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('kasbon.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-xs">
                                    EDIT
                                </a>

                                <form action="{{ route('kasbon.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data kasbon ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs">
                                        HAPUS
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-gray-500 italic">Data kasbon belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
