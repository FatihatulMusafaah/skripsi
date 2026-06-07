@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center no-print">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Laporan Penggajian</h1>
        <p class="text-gray-500">Rekapitulasi pembayaran gaji seluruh karyawan.</p>
    </div>
    <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition flex items-center gap-2">
        <i class="fas fa-print"></i> CETAK LAPORAN
    </button>
</div>

<!-- SEARCH & FILTER -->
<div class="bg-white p-4 rounded-xl shadow mb-6 no-print">
    <form action="{{ route('owner.laporan.penggajian') }}" method="GET" class="flex flex-wrap gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pegawai..." class="flex-1 min-w-[200px] border rounded-lg px-4 py-2 focus:ring-blue-500">
        
        <select name="bulan" class="border rounded-lg px-4 py-2 focus:ring-blue-500">
            <option value="">-- Semua Bulan --</option>
            @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bln)
                <option value="{{ $bln }}" {{ request('bulan') == $bln ? 'selected' : '' }}>{{ $bln }}</option>
            @endforeach
        </select>

        <select name="tahun" class="border rounded-lg px-4 py-2 focus:ring-blue-500">
            <option value="">-- Semua Tahun --</option>
            @for($y = date('Y'); $y >= 2024; $y--)
                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">FILTER</button>
        @if(request()->hasAny(['search', 'bulan', 'tahun']))
            <a href="{{ route('owner.laporan.penggajian') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-300 transition">RESET</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="p-8 print-only hidden">
        <h1 class="text-2xl font-bold text-center uppercase mb-2">Laporan Penggajian Pegawai</h1>
        <p class="text-center text-gray-500 mb-6">Periode: {{ request('bulan') ?? '' }} {{ request('tahun') ?? 'Seluruh Waktu' }}</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-[10px] uppercase font-bold">
                    <th class="py-4 px-4 text-left">No</th>
                    <th class="py-4 px-4 text-left">Bulan/Tahun</th>
                    <th class="py-4 px-4 text-left">Nama Pegawai</th>
                    <th class="py-4 px-4 text-left">Gaji Pokok</th>
                    <th class="py-4 px-4 text-left">Lembur</th>
                    <th class="py-4 px-4 text-left">P. Kasbon</th>
                    <th class="py-4 px-4 text-left">P. Cuti</th>
                    <th class="py-4 px-4 text-left">Total Gaji</th>
                </tr>
            </thead>
            <tbody class="text-xs divide-y divide-gray-200">
                @forelse($data as $row)
                <tr>
                    <td class="py-4 px-4">{{ $loop->iteration }}</td>
                    <td class="py-4 px-4 font-medium">{{ $row->bulan }} {{ $row->tahun }}</td>
                    <td class="py-4 px-4 font-bold uppercase">{{ $row->user->name ?? '-' }}</td>
                    <td class="py-4 px-4">Rp {{ number_format($row->gaji_pokok, 0, ',', '.') }}</td>
                    <td class="py-4 px-4 text-green-600 font-medium">+{{ number_format($row->lembur, 0, ',', '.') }}</td>
                    <td class="py-4 px-4 text-red-600">-{{ number_format($row->potongan_kasbon, 0, ',', '.') }}</td>
                    <td class="py-4 px-4 text-red-600">-{{ number_format($row->potongan_cuti, 0, ',', '.') }}</td>
                    <td class="py-4 px-4 font-black text-blue-600">Rp {{ number_format($row->total_gaji, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-10 text-center text-gray-500 italic">Data penggajian tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-6 bg-gray-50 border-t flex justify-between items-center">
        <span class="font-bold text-gray-600 uppercase text-xs">Total Seluruh Pengeluaran Gaji:</span>
        <span class="text-xl font-black text-blue-700">Rp {{ number_format($data->sum('total_gaji'), 0, ',', '.') }}</span>
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
    .print-only { display: block !important; }
    body { background: white; }
    .shadow { shadow: none !important; }
    .overflow-x-auto { overflow: visible !important; }
}
</style>
@endsection
