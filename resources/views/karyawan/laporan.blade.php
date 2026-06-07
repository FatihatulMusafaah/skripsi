@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Laporan Ringkasan Saya</h1>
    <p class="text-gray-500">Statistik performa Anda selama bergabung.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-white p-6 rounded-xl shadow border-t-4 border-blue-600 text-center">
        <h3 class="text-gray-500 text-xs font-bold uppercase mb-2">Total Kehadiran</h3>
        <p class="text-3xl font-black text-gray-800">{{ $absensi }}</p>
        <p class="text-[10px] text-gray-400 mt-1">Hari Kerja</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow border-t-4 border-yellow-600 text-center">
        <h3 class="text-gray-500 text-xs font-bold uppercase mb-2">Cuti Disetujui</h3>
        <p class="text-3xl font-black text-gray-800">{{ $cuti }}</p>
        <p class="text-[10px] text-gray-400 mt-1">Hari Cuti</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow border-t-4 border-red-600 text-center">
        <h3 class="text-gray-500 text-xs font-bold uppercase mb-2">Total Kasbon</h3>
        <p class="text-2xl font-black text-red-600">Rp {{ number_format($kasbon, 0, ',', '.') }}</p>
        <p class="text-[10px] text-gray-400 mt-1">Pinjaman Akumulasi</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow border-t-4 border-green-600 text-center">
        <h3 class="text-gray-500 text-xs font-bold uppercase mb-2">Performa</h3>
        <p class="text-3xl font-black text-gray-800">Baik</p>
        <p class="text-[10px] text-gray-400 mt-1">Bulan Berjalan</p>
    </div>
</div>

<div class="bg-white p-8 rounded-xl shadow">
    <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-4">Informasi Tambahan</h2>
    <div class="prose max-w-none text-gray-600 leading-relaxed">
        <p>Laporan ini merupakan ringkasan aktivitas Anda yang tercatat secara otomatis dalam sistem. Data kehadiran dihitung berdasarkan absen masuk yang berhasil divalidasi, sedangkan data cuti dan kasbon dihitung dari pengajuan yang telah mendapatkan persetujuan dari pihak Admin atau Owner.</p>
        <p class="mt-4 font-bold text-blue-600">Terus tingkatkan produktivitas dan disiplin kerja Anda!</p>
    </div>
</div>
@endsection
