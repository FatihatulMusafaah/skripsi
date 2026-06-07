@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Riwayat Kasbon</h2>
        {{-- Tombol tambah dimatikan karena sudah otomatis dari menu Kasbon --}}
        <span class="text-sm text-gray-500 italic">* Data otomatis terupdate dari menu Kasbon</span>
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
                    <th class="py-3 px-4 text-left">No</th>
                    <th class="py-3 px-4 text-left">Nama Pegawai</th>
                    <th class="py-3 px-4 text-left">Total Kasbon</th>
                    <th class="py-3 px-4 text-left">Dibayar</th>
                    <th class="py-3 px-4 text-left">Sisa Kasbon</th>
                    <th class="py-3 px-4 text-center">Tenor (Bulan)</th>
                    <th class="py-3 px-4 text-center">Sisa Tenor</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($riwayatKasbon as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-4 text-left whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 text-left font-medium">{{ $item->pegawai->name ?? '-' }}</td>
                        <td class="py-3 px-4 text-left">Rp {{ number_format($item->total_kasbon, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-left">Rp {{ number_format($item->kasbon_dibayar, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-left font-bold text-red-600">
                            Rp {{ number_format($item->sisa_kasbon, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-center">{{ $item->lama_cicilan }} Bln</td>
                        <td class="py-3 px-4 text-center">
                            <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-bold">
                                {{ $item->sisa_cicilan }} Bln lagi
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex item-center justify-center gap-2">
                                <form action="{{ route('riwayat-kasbon.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data riwayat ini?')">
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
                        <td colspan="8" class="py-6 text-center text-gray-500 italic">Data riwayat belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
