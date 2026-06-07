@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center no-print">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Laporan Cuti Pegawai</h1>
        <p class="text-gray-500">Daftar pengajuan cuti seluruh karyawan.</p>
    </div>
    <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition flex items-center gap-2">
        <i class="fas fa-print"></i> CETAK LAPORAN
    </button>
</div>

<!-- SEARCH & FILTER -->
<div class="bg-white p-4 rounded-xl shadow mb-6 no-print">
    <form action="{{ route('owner.laporan.cuti') }}" method="GET" class="flex flex-wrap gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pegawai..." class="flex-1 min-w-[200px] border rounded-lg px-4 py-2 focus:ring-blue-500">
        <select name="status" class="border rounded-lg px-4 py-2 focus:ring-blue-500">
            <option value="">-- Semua Status --</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>PENDING</option>
            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>DISETUJUI</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>DITOLAK</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">FILTER</button>
        @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('owner.laporan.cuti') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-300 transition">RESET</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="p-8 print-only hidden">
        <h1 class="text-2xl font-bold text-center uppercase mb-2">Laporan Cuti Pegawai</h1>
        <p class="text-center text-gray-500 mb-6">Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-xs uppercase font-bold">
                    <th class="py-4 px-6 text-left">No</th>
                    <th class="py-4 px-6 text-left">Nama Pegawai</th>
                    <th class="py-4 px-6 text-left">Mulai</th>
                    <th class="py-4 px-6 text-left">Selesai</th>
                    <th class="py-4 px-6 text-left">Alasan</th>
                    <th class="py-4 px-6 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-200">
                @forelse($data as $row)
                <tr>
                    <td class="py-4 px-6">{{ $loop->iteration }}</td>
                    <td class="py-4 px-6 font-bold uppercase">{{ $row->user->name ?? $row->nama_pegawai }}</td>
                    <td class="py-4 px-6">{{ \Carbon\Carbon::parse($row->tanggal_mulai)->format('d/m/Y') }}</td>
                    <td class="py-4 px-6">{{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('d/m/Y') }}</td>
                    <td class="py-4 px-6 text-xs text-gray-600">{{ $row->alasan }}</td>
                    <td class="py-4 px-6 text-center uppercase font-black text-[10px]">
                        @php
                            $statusClass = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'disetujui' => 'bg-green-100 text-green-700',
                                'ditolak' => 'bg-red-100 text-red-700',
                            ][$row->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="px-2 py-1 rounded {{ $statusClass }}">
                            {{ $row->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-10 text-center text-gray-500 italic">Data cuti tidak ditemukan.</td>
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
