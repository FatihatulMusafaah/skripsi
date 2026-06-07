@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Riwayat Kasbon Saya</h1>
        <p class="text-gray-500">Daftar seluruh pengajuan kasbon Anda.</p>
    </div>

    <!-- PENCARIAN & FILTER -->
    <form action="{{ route('karyawan.riwayat_kasbon') }}" method="GET" class="flex flex-wrap gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nominal/metode..." class="border rounded-lg px-3 py-2 text-sm focus:ring-blue-500">
        <select name="status" class="border rounded-lg px-3 py-2 text-sm focus:ring-blue-500">
            <option value="">-- Semua Status --</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition">
            Filter
        </button>
        @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('karyawan.riwayat_kasbon') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-300 transition">
                Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-xs uppercase tracking-wider">
                    <th class="py-4 px-4 text-left font-bold">Tanggal</th>
                    <th class="py-4 px-4 text-left font-bold">Total Kasbon</th>
                    <th class="py-4 px-4 text-left font-bold">Dibayar</th>
                    <th class="py-4 px-4 text-left font-bold">Sisa</th>
                    <th class="py-4 px-4 text-center font-bold">Tenor</th>
                    <th class="py-4 px-4 text-center font-bold">Sisa Tenor</th>
                    <th class="py-4 px-4 text-center font-bold">Status</th>
                    <th class="py-4 px-4 text-center font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-200">
                @forelse($riwayat as $row)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-4 px-4 whitespace-nowrap">
                        {{ $row->created_at->format('d/m/Y') }}<br>
                        <span class="text-[10px] text-gray-400 capitalize">{{ str_replace('_', ' ', $row->metode_pembayaran) }}</span>
                    </td>
                    <td class="py-4 px-4 font-bold">Rp {{ number_format($row->jumlah_kasbon, 0, ',', '.') }}</td>
                    <td class="py-4 px-4 text-green-600 font-medium">
                        Rp {{ number_format($row->jumlah_kasbon - $row->sisa_kasbon, 0, ',', '.') }}
                    </td>
                    <td class="py-4 px-4 text-red-600 font-bold">
                        Rp {{ number_format($row->sisa_kasbon, 0, ',', '.') }}
                    </td>
                    <td class="py-4 px-4 text-center">{{ $row->lama_cicilan }} Bln</td>
                    <td class="py-4 px-4 text-center">
                        @if($row->status == 'aktif')
                            {{ ceil($row->sisa_kasbon / $row->potongan_per_bulan) }} Bln
                        @elseif($row->status == 'lunas')
                            0 Bln
                        @else
                            -
                        @endif
                    </td>
                    <td class="py-4 px-4 text-center">
                        @php
                            $statusClass = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'aktif' => 'bg-green-100 text-green-700',
                                'ditolak' => 'bg-red-100 text-red-700',
                                'lunas' => 'bg-gray-100 text-gray-700',
                            ][$row->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="px-2 py-1 rounded-full font-bold text-[10px] {{ $statusClass }}">
                            {{ strtoupper($row->status) }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <a href="{{ route('karyawan.riwayat_kasbon.detail', $row->id) }}" class="text-blue-600 hover:text-blue-900 font-bold text-xs">
                            DETAIL
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-10 text-center text-gray-500 italic">Data riwayat kasbon tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($riwayat->hasPages())
    <div class="px-4 py-4 bg-gray-50 border-t">
        {{ $riwayat->links() }}
    </div>
    @endif
</div>
@endsection
