@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Kasbon</h1>
        <a href="/dashboard" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Kembali ke Dashboard</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Pegawai</th>
                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Kasbon</th>
                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Metode Pembayaran</th>
                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($riwayat as $item)
                <tr>
                    <td class="py-3 px-4 text-sm">{{ $loop->iteration }}</td>
                    <td class="py-3 px-4 text-sm">{{ $item->pegawai->nama ?? 'Pegawai Terhapus' }}</td>
                    <td class="py-3 px-4 text-sm text-green-600 font-medium">Rp {{ number_format($item->jumlah_kasbon, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 text-sm">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs uppercase font-semibold">
                            {{ $item->metode_pembayaran }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-gray-500 italic">Belum ada data riwayat kasbon.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
