@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Owner</h1>
    <p class="text-gray-500">Sistem Informasi Kepegawaian - Ringkasan Laporan</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <a href="{{ route('owner.laporan.pegawai') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-blue-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Laporan Pegawai</h3>
        <p class="text-xs text-gray-400 mt-1">Klik untuk melihat detail</p>
    </a>
    <a href="{{ route('owner.laporan.absensi') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Laporan Absensi</h3>
        <p class="text-xs text-gray-400 mt-1">Klik untuk melihat detail</p>
    </a>
    <a href="{{ route('owner.laporan.cuti') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-yellow-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Laporan Cuti</h3>
        <p class="text-xs text-gray-400 mt-1">Klik untuk melihat detail</p>
    </a>
    <a href="{{ route('owner.laporan.kasbon') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-red-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Laporan Kasbon</h3>
        <p class="text-xs text-gray-400 mt-1">Klik untuk melihat detail</p>
    </a>
    <a href="{{ route('owner.laporan.penggajian') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-purple-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Laporan Penggajian</h3>
        <p class="text-xs text-gray-400 mt-1">Klik untuk melihat detail</p>
    </a>
</div>

<div class="bg-white p-8 rounded-xl shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-800">Selamat Datang, Owner</h2>
    <p class="text-gray-600">Anda dapat memantau seluruh aktivitas operasional melalui menu laporan yang tersedia.</p>
</div>
@endsection
