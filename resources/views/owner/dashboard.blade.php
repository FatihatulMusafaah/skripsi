@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Owner</h1>
    <p class="text-gray-500">Selamat datang di Sistem Informasi Kepegawaian</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-gray-400 text-sm font-medium uppercase tracking-wider">Total Pegawai</h3>
        <p class="text-3xl font-bold text-blue-600 mt-2">25</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-gray-400 text-sm font-medium uppercase tracking-wider">Total Absensi</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">120</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-gray-400 text-sm font-medium uppercase tracking-wider">Total Kasbon</h3>
        <p class="text-3xl font-bold text-red-600 mt-2">15</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-gray-400 text-sm font-medium uppercase tracking-wider">Total Penggajian</h3>
        <p class="text-3xl font-bold text-purple-600 mt-2">30</p>
    </div>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Data Aktivitas Pegawai</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pegawai</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Ahmad</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Masuk</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">01-05-2026</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Budi</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Cuti</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">02-05-2026</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
