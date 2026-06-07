@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Karyawan</h1>
    <p class="text-gray-500">Selamat Datang, {{ Auth::user()->name }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow border-l-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-semibold">Status Kehadiran</h3>
        <p class="text-lg font-bold text-gray-800 mt-2">
            @if($absensiHariIni)
                Sudah Absen ({{ $absensiHariIni->jam_masuk }})
            @else
                Belum Absen
            @endif
        </p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow border-l-4 border-yellow-500">
        <h3 class="text-gray-500 text-sm font-semibold">Total Cuti Disetujui</h3>
        <p class="text-lg font-bold text-gray-800 mt-2">{{ $totalCuti }} Hari</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow border-l-4 border-red-500">
        <h3 class="text-gray-500 text-sm font-semibold">Sisa Kasbon</h3>
        <p class="text-lg font-bold text-red-600 mt-2">Rp {{ number_format($kasbonAktif, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4">Akses Cepat</h2>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('karyawan.absensi') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Absen Sekarang</a>
            <a href="{{ route('karyawan.cuti') }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">Ajukan Cuti</a>
            <a href="{{ route('karyawan.kasbon') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Ajukan Kasbon</a>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4">Pengumuman</h2>
        <p class="text-gray-600 italic">Tidak ada pengumuman terbaru.</p>
    </div>
</div>
@endsection
