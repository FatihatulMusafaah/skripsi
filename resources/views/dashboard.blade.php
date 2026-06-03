<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Informasi Kepegawaian</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-gray-800 text-white p-5">

            <h2 class="text-2xl font-bold mb-6">
                Admin 
            </h2>

            <ul class="space-y-2">

                <li>
                    <a href="/dashboard"
                       class="block p-3 rounded bg-gray-700">
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="/pegawai"
                       class="block p-3 rounded hover:bg-gray-700">
                        Data Pegawai
                    </a>
                </li>

                <li>
                    <a href="/absensi"
                       class="block p-3 rounded hover:bg-gray-700">
                        Absensi
                    </a>
                </li>

                <li>
                    <a href="/cuti"
                       class="block p-3 rounded hover:bg-gray-700">
                        Pengajuan Cuti
                    </a>
                </li>

                <li>
                    <a href="/penggajian"
                       class="block p-3 rounded hover:bg-gray-700">
                        Penggajian
                    </a>
                </li>

                <li>
                    <a href="/kasbon"
                       class="block p-3 rounded hover:bg-gray-700">
                        Kasbon
                    </a>
                </li>

                <li>
                    <a href="/riwayatkasbon"
                       class="block p-3 rounded hover:bg-gray-700">
                        riwayatkasbon
                    </a>
                </li>

                <li>
                    <a href="/laporan"
                       class="block p-3 rounded hover:bg-gray-700">
                        Laporan
                    </a>
                </li>

                <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
            </ul>

        </aside>

        <!-- CONTENT -->
        <main class="flex-1 p-6">

            <!-- HEADER -->
            <div class="mb-6">

                <h1 class="text-3xl font-bold text-gray-800">
                    Dashboard
                </h1>

                <p class="text-gray-500">
                    Sistem Informasi Kepegawaian
                </p>

            </div>

            <!-- CARD -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">

                <!-- TOTAL PEGAWAI -->
                <div class="bg-white p-5 rounded-xl shadow">

                    <h3 class="text-gray-500 text-sm">
                        Total Pegawai
                    </h3>

                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $totalPegawai ?? 0 }}
                    </p>

                </div>

                <!-- ABSENSI -->
                <div class="bg-white p-5 rounded-xl shadow">

                    <h3 class="text-gray-500 text-sm">
                        Absensi Hari Ini
                    </h3>

                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ $absensiHariIni ?? 0 }}
                    </p>

                </div>

                <!-- CUTI -->
                <div class="bg-white p-5 rounded-xl shadow">

                    <h3 class="text-gray-500 text-sm">
                        Cuti Hari Ini
                    </h3>

                    <p class="text-3xl font-bold text-yellow-500 mt-2">
                        {{ $cutiHariIni ?? 0 }}
                    </p>

                </div>

                <!-- KASBON -->
                <div class="bg-white p-5 rounded-xl shadow">

                    <h3 class="text-gray-500 text-sm">
                        Pengajuan Kasbon
                    </h3>

                    <p class="text-3xl font-bold text-red-500 mt-2">
                        {{ $totalKasbon ?? 0 }}
                    </p>

                </div>

                <!-- TOTAL GAJI -->
                <div class="bg-white p-5 rounded-xl shadow">

                    <h3 class="text-gray-500 text-sm">
                        Total Gaji Bulan Ini
                    </h3>

                    <p class="text-2xl font-bold text-purple-600 mt-2">
                        Rp {{ number_format($totalGaji ?? 0, 0, ',', '.') }}
                    </p>

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

        </main>

    </div>

    <!-- CHART -->
    <script>

        // BAR CHART
        const ctx = document.getElementById('pegawaiChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pegawai', 'Absensi', 'Cuti', 'Kasbon'],
                datasets: [{
                    label: 'Data Sistem',
                    data: [
                        {{ (int)($totalPegawai ?? 0) }},
                        {{ (int)($absensiHariIni ?? 0) }},
                        {{ (int)($cutiHariIni ?? 0) }},
                        {{ (int)($totalKasbon ?? 0) }}
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
                labels: ['Pegawai', 'Absensi', 'Cuti', 'Kasbon'],
                datasets: [{
                    data: [
                        {{ (int)($totalPegawai ?? 0) }},
                        {{ (int)($absensiHariIni ?? 0) }},
                        {{ (int)($cutiHariIni ?? 0) }},
                        {{ (int)($totalKasbon ?? 0) }}
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

</body>
</html>