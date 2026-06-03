@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Laporan Sistem Informasi Kepegawaian</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- LAPORAN PEGAWAI --}}
        <div class="border p-4 rounded-lg shadow-sm">
            <h3 class="text-xl font-bold text-blue-700 mb-3 border-b pb-2">Daftar Pegawai</h3>
            <ul class="space-y-2">
                @foreach($pegawai as $p)
                    <li class="flex justify-between text-sm">
                        <span>{{ $p->name }}</span>
                        <span class="text-gray-500 italic">{{ $p->jabatan ?? 'Karyawan' }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- LAPORAN ABSENSI --}}
        <div class="border p-4 rounded-lg shadow-sm">
            <h3 class="text-xl font-bold text-green-700 mb-3 border-b pb-2">Aktivitas Absensi</h3>
            <ul class="space-y-2">
                @foreach($absensi->take(10) as $a)
                    <li class="flex justify-between text-sm">
                        <span>{{ $a->user->name ?? '-' }}</span>
                        <span class="text-gray-500">{{ $a->tanggal }} ({{ $a->status }})</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- LAPORAN KASBON --}}
        <div class="border p-4 rounded-lg shadow-sm">
            <h3 class="text-xl font-bold text-red-700 mb-3 border-b pb-2">Kasbon Terakhir</h3>
            <ul class="space-y-2">
                @foreach($kasbon->take(10) as $k)
                    <li class="flex justify-between text-sm">
                        <span>{{ $k->user->name ?? '-' }}</span>
                        <span class="font-bold text-red-600">Rp {{ number_format($k->jumlah_kasbon, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- LAPORAN PENGGAJIAN --}}
        <div class="border p-4 rounded-lg shadow-sm">
            <h3 class="text-xl font-bold text-purple-700 mb-3 border-b pb-2">Penggajian Terakhir</h3>
            <ul class="space-y-2">
                @foreach($penggajian->take(10) as $g)
                    <li class="flex justify-between text-sm">
                        <span>{{ $g->user->name ?? '-' }}</span>
                        <span class="font-bold text-green-600">Rp {{ number_format($g->total_gaji, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-10 text-center">
        <button onclick="window.print()" class="bg-gray-800 hover:bg-black text-white px-8 py-2 rounded-lg font-bold transition">
            Cetak Laporan (PDF)
        </button>
    </div>
</div>
@endsection
