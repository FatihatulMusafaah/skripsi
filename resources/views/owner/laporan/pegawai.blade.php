@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center no-print">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Laporan Data Pegawai</h1>
        <p class="text-gray-500">Daftar seluruh karyawan aktif dalam sistem.</p>
    </div>
    <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition flex items-center gap-2">
        <i class="fas fa-print"></i> CETAK LAPORAN
    </button>
</div>

<!-- SEARCH -->
<div class="bg-white p-4 rounded-xl shadow mb-6 no-print">
    <form action="{{ route('owner.laporan.pegawai') }}" method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pegawai..." class="flex-1 border rounded-lg px-4 py-2 focus:ring-blue-500">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">CARI</button>
        @if(request('search'))
            <a href="{{ route('owner.laporan.pegawai') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-300 transition">RESET</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="p-8 print-only hidden">
        <h1 class="text-2xl font-bold text-center uppercase mb-2">Laporan Data Pegawai</h1>
        <p class="text-center text-gray-500 mb-6">Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-xs uppercase font-bold">
                    <th class="py-4 px-6 text-left">No</th>
                    <th class="py-4 px-6 text-left">Nama Pegawai</th>
                    <th class="py-4 px-6 text-left">Jabatan</th>
                    <th class="py-4 px-6 text-left">Email</th>
                    <th class="py-4 px-6 text-left">No. HP</th>
                    <th class="py-4 px-6 text-left">Gaji Pokok</th>
                    <th class="py-4 px-6 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-200">
                @forelse($data as $row)
                <tr>
                    <td class="py-4 px-6">{{ $loop->iteration }}</td>
                    <td class="py-4 px-6 font-bold">{{ $row->name }}</td>
                    <td class="py-4 px-6">{{ $row->jabatan ?? '-' }}</td>
                    <td class="py-4 px-6">{{ $row->email }}</td>
                    <td class="py-4 px-6">{{ $row->no_hp ?? '-' }}</td>
                    <td class="py-4 px-6">Rp {{ number_format($row->gaji_pokok, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-center uppercase font-black text-[10px]">
                        <span class="px-2 py-1 rounded {{ $row->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $row->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-10 text-center text-gray-500 italic">Data pegawai tidak ditemukan.</td>
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
