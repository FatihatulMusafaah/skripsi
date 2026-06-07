@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Detail Riwayat Kasbon</h1>
        <p class="text-gray-500">Informasi lengkap pengajuan kasbon.</p>
    </div>
    <a href="{{ route('karyawan.riwayat_kasbon') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
        &larr; Kembali
    </a>
</div>

<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <!-- HEADER -->
    <div class="bg-blue-600 p-6 text-white text-center">
        <h2 class="text-xl font-bold uppercase tracking-widest">Detail Kasbon Karyawan</h2>
        <p class="text-blue-100 text-sm">ID Pengajuan: #KSB-{{ str_pad($kasbon->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="p-8">
        <!-- STATUS -->
        <div class="flex justify-center mb-8">
            @php
                $statusClass = [
                    'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                    'aktif' => 'bg-green-100 text-green-700 border-green-200',
                    'ditolak' => 'bg-red-100 text-red-700 border-red-200',
                    'lunas' => 'bg-gray-100 text-gray-700 border-gray-200',
                ][$kasbon->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
            @endphp
            <div class="px-6 py-2 rounded-full border-2 font-black text-sm {{ $statusClass }}">
                STATUS: {{ strtoupper($kasbon->status) }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- DATA KARYAWAN -->
            <div class="space-y-4">
                <h3 class="font-bold border-b pb-2 text-blue-600 text-xs uppercase">Informasi Karyawan</h3>
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold">Nama Lengkap</p>
                    <p class="text-gray-800 font-medium">{{ Auth::user()->name }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold">Jabatan</p>
                    <p class="text-gray-800 font-medium">{{ Auth::user()->jabatan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold">Tanggal Pengajuan</p>
                    <p class="text-gray-800 font-medium">{{ $kasbon->created_at->format('d F Y') }}</p>
                </div>
            </div>

            <!-- DATA PINJAMAN -->
            <div class="space-y-4">
                <h3 class="font-bold border-b pb-2 text-blue-600 text-xs uppercase">Rincian Kasbon</h3>
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold">Total Pinjaman</p>
                    <p class="text-xl font-black text-gray-800">Rp {{ number_format($kasbon->jumlah_kasbon, 0, ',', '.') }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-400 text-[10px] uppercase font-bold">Metode</p>
                        <p class="text-gray-800 font-medium capitalize">{{ str_replace('_', ' ', $kasbon->metode_pembayaran) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[10px] uppercase font-bold">Tenor</p>
                        <p class="text-gray-800 font-medium">{{ $kasbon->lama_cicilan }} Bulan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- PROGRESS PEMBAYARAN -->
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
            <h3 class="font-bold mb-4 text-gray-800 text-sm">Status Pembayaran</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">Total Dibayar</span>
                    <span class="font-bold text-green-600">Rp {{ number_format($kasbon->jumlah_kasbon - $kasbon->sisa_kasbon, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">Sisa Hutang</span>
                    <span class="font-bold text-red-600 text-lg">Rp {{ number_format($kasbon->sisa_kasbon, 0, ',', '.') }}</span>
                </div>
                
                @if($kasbon->status == 'aktif' && $kasbon->metode_pembayaran == 'cicilan')
                <div class="pt-4 border-t">
                    <p class="text-xs text-gray-500 italic">* Cicilan sebesar <strong>Rp {{ number_format($kasbon->potongan_per_bulan, 0, ',', '.') }}</strong> akan dipotong otomatis dari gaji bulanan Anda.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-gray-100 p-4 text-center text-[10px] text-gray-400">
        Informasi ini bersifat rahasia dan hanya untuk konsumsi internal karyawan yang bersangkutan.
    </div>
</div>
@endsection
