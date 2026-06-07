@extends('layouts.app')

@section('content')
<!-- HEADER -->
<div class="flex justify-between items-start mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500">Sistem Informasi Kepegawaian</p>
    </div>
    
    <!-- NOTIFIKASI -->
    <div class="flex gap-4">
        <!-- Notif Cuti -->
        <a href="{{ route('cuti.index') }}" class="relative p-3 bg-white rounded-full shadow hover:bg-gray-50 transition">
            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            @if($notifCuti > 0)
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                    {{ $notifCuti }}
                </span>
            @endif
        </a>

        <!-- Notif Kasbon -->
        <a href="{{ route('kasbon.index') }}" class="relative p-3 bg-white rounded-full shadow hover:bg-gray-50 transition">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            @if($notifKasbon > 0)
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                    {{ $notifKasbon }}
                </span>
            @endif
        </a>
    </div>
</div>

<!-- CARD -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">

    <!-- TOTAL PEGAWAI -->
    <div class="bg-white p-5 rounded-xl shadow border-l-4 border-blue-500">
        <h3 class="text-gray-500 text-sm font-semibold">Laporan Pegawai</h3>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalPegawai ?? 0 }}</p>
    </div>

    <!-- ABSENSI -->
    <div class="bg-white p-5 rounded-xl shadow border-l-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-semibold">Laporan Absensi</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ $absensiHariIni ?? 0 }}</p>
    </div>

    <!-- CUTI -->
    <div class="bg-white p-5 rounded-xl shadow border-l-4 border-yellow-500">
        <h3 class="text-gray-500 text-sm font-semibold">Laporan Cuti</h3>
        <p class="text-3xl font-bold text-yellow-500 mt-2">{{ $cutiHariIni ?? 0 }}</p>
    </div>

    <!-- KASBON -->
    <div class="bg-white p-5 rounded-xl shadow border-l-4 border-red-500">
        <h3 class="text-gray-500 text-sm font-semibold">Laporan Kasbon</h3>
        <p class="text-3xl font-bold text-red-500 mt-2">{{ $kasbonHariIni ?? 0 }}</p>
    </div>

    <!-- TOTAL GAJI -->
    <div class="bg-white p-5 rounded-xl shadow border-l-4 border-purple-500">
        <h3 class="text-gray-500 text-sm font-semibold">Laporan Penggajian</h3>
        <p class="text-2xl font-bold text-purple-600 mt-2">Rp {{ number_format($totalGaji ?? 0, 0, ',', '.') }}</p>
    </div>

</div>

<!-- GRAFIK -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- BAR CHART -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4">
            Statistik Kepegawaian
        </h2>
        <canvas id="pegawaiChart"></canvas>
    </div>

    <!-- PIE CHART -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4">
            Persentase Data
        </h2>
        <canvas id="pieChart"></canvas>
    </div>

</div>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // BAR CHART
    const ctx = document.getElementById('pegawaiChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Laporan Pegawai', 'Laporan Absensi', 'Laporan Cuti', 'Laporan Kasbon'],
            datasets: [{
                label: 'Data Sistem',
                data: [
                    {{ (int)($totalPegawai ?? 0) }},
                    {{ (int)($absensiHariIni ?? 0) }},
                    {{ (int)($cutiHariIni ?? 0) }},
                    {{ (int)($kasbonHariIni ?? 0) }}
                ],
                backgroundColor: [
                    '#3B82F6',
                    '#10B981',
                    '#F59E0B',
                    '#EF4444'
                ],
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // PIE CHART
    const pie = document.getElementById('pieChart');

    new Chart(pie, {
        type: 'pie',
        data: {
            labels: ['Laporan Pegawai', 'Laporan Absensi', 'Laporan Cuti', 'Laporan Kasbon'],
            datasets: [{
                data: [
                    {{ (int)($totalPegawai ?? 0) }},
                    {{ (int)($absensiHariIni ?? 0) }},
                    {{ (int)($cutiHariIni ?? 0) }},
                    {{ (int)($kasbonHariIni ?? 0) }}
                ],
                backgroundColor: [
                    '#3B82F6',
                    '#10B981',
                    '#F59E0B',
                    '#EF4444'
                ]
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@endsection
