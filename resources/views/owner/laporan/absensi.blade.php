@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center no-print">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Laporan Absensi Pegawai</h1>
        <p class="text-gray-500">Rekapitulasi kehadiran harian seluruh karyawan.</p>
    </div>
    <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition flex items-center gap-2">
        <i class="fas fa-print"></i> CETAK LAPORAN
    </button>
</div>

<!-- SEARCH & FILTER -->
<div class="bg-white p-4 rounded-xl shadow mb-6 no-print">
    <form action="{{ route('owner.laporan.absensi') }}" method="GET" class="flex flex-wrap gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pegawai..." class="flex-1 min-w-[200px] border rounded-lg px-4 py-2 focus:ring-blue-500">
        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="border rounded-lg px-4 py-2 focus:ring-blue-500">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">FILTER</button>
        @if(request()->hasAny(['search', 'tanggal']))
            <a href="{{ route('owner.laporan.absensi') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-300 transition">RESET</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="p-8 print-only hidden">
        <h1 class="text-2xl font-bold text-center uppercase mb-2">Laporan Absensi Pegawai</h1>
        <p class="text-center text-gray-500 mb-6">Periode: {{ request('tanggal') ? \Carbon\Carbon::parse(request('tanggal'))->format('d/m/Y') : 'Seluruh Waktu' }}</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-xs uppercase font-bold">
                    <th class="py-4 px-6 text-left">No</th>
                    <th class="py-4 px-6 text-left">Tanggal</th>
                    <th class="py-4 px-6 text-left">Nama Pegawai</th>
                    <th class="py-4 px-6 text-left">Jam Masuk</th>
                    <th class="py-4 px-6 text-left">Jam Keluar</th>
                    <th class="py-4 px-6 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-200">
                @forelse($data as $row)
                <tr>
                    <td class="py-4 px-6">{{ $loop->iteration }}</td>
                    <td class="py-4 px-6 font-medium">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                    <td class="py-4 px-6 font-bold uppercase">{{ $row->user->name ?? $row->nama_pegawai }}</td>
                    <td class="py-4 px-6 text-green-600 font-bold">{{ $row->jam_masuk ?? '-' }}</td>
                    <td class="py-4 px-6 text-red-600 font-bold">{{ $row->jam_keluar ?? '-' }}</td>
                    <td class="py-4 px-6 text-center">
                        <span class="px-2 py-1 rounded text-[10px] font-black uppercase {{ $row->status == 'hadir' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $row->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-10 text-center text-gray-500 italic">Data absensi tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
    .print-only { display: block !important; }
    body { background: white; }
    .shadow { shadow: none !important; }
}
</style>
@endsection
