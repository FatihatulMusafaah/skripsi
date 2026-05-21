<x-app-layout>

<div class="p-6">

    <h1 class="text-3xl font-bold mb-6">
        Laporan Sistem Informasi Kepegawaian
    </h1>

    <!-- Statistik -->
    <div class="grid grid-cols-5 gap-4 mb-8">

        <div class="bg-blue-500 text-white p-4 rounded">
            <h2>Total Pegawai</h2>
            <p class="text-2xl">{{ $totalPegawai }}</p>
        </div>

        <div class="bg-green-500 text-white p-4 rounded">
            <h2>Total Absensi</h2>
            <p class="text-2xl">{{ $totalAbsensi }}</p>
        </div>

        <div class="bg-yellow-500 text-white p-4 rounded">
            <h2>Total Cuti</h2>
            <p class="text-2xl">{{ $totalCuti }}</p>
        </div>

        <div class="bg-purple-500 text-white p-4 rounded">
            <h2>Total Penggajian</h2>
            <p class="text-2xl">{{ $totalPenggajian }}</p>
        </div>

        <div class="bg-red-500 text-white p-4 rounded">
            <h2>Total Kasbon</h2>
            <p class="text-2xl">{{ $totalKasbon }}</p>
        </div>

    </div>

    <!-- DATA PEGAWAI -->
    <div class="bg-white shadow rounded p-4 mb-8">

        <h2 class="text-xl font-bold mb-4">
            Data Pegawai
        </h2>

        <table class="w-full border">

            <tr class="bg-gray-200">
                <th class="border p-2">Nama</th>
                <th class="border p-2">Jabatan</th>
                <th class="border p-2">No HP</th>
            </tr>

            @foreach($pegawais as $pegawai)
            <tr>
                <td class="border p-2">
                    {{ $pegawai->nama }}
                </td>

                <td class="border p-2">
                    {{ $pegawai->jabatan }}
                </td>

                <td class="border p-2">
                    {{ $pegawai->no_hp }}
                </td>
            </tr>
            @endforeach

        </table>

    </div>

    <!-- DATA ABSENSI -->
    <div class="bg-white shadow rounded p-4 mb-8">

        <h2 class="text-xl font-bold mb-4">
            Data Absensi
        </h2>

        <table class="w-full border">

            <tr class="bg-gray-200">
                <th class="border p-2">Nama</th>
                <th class="border p-2">Tanggal</th>
                <th class="border p-2">Status</th>
            </tr>

            @foreach($absensis as $absensi)
            <tr>
                <td class="border p-2">
                    {{ $absensi->nama_pegawai }}
                </td>

                <td class="border p-2">
                    {{ $absensi->tanggal }}
                </td>

                <td class="border p-2">
                    {{ $absensi->status }}
                </td>
            </tr>
            @endforeach

        </table>

    </div>

    <!-- DATA CUTI -->
    <div class="bg-white shadow rounded p-4 mb-8">

        <h2 class="text-xl font-bold mb-4">
            Data Cuti
        </h2>

        <table class="w-full border">

            <tr class="bg-gray-200">
                <th class="border p-2">Nama</th>
                <th class="border p-2">Tanggal Mulai</th>
                <th class="border p-2">Tanggal Selesai</th>
                <th class="border p-2">Status</th>
            </tr>

            @foreach($cutis as $cuti)
            <tr>
                <td class="border p-2">
                    {{ $cuti->nama_pegawai }}
                </td>

                <td class="border p-2">
                    {{ $cuti->tanggal_mulai }}
                </td>

                <td class="border p-2">
                    {{ $cuti->tanggal_selesai }}
                </td>

                <td class="border p-2">
                    {{ $cuti->status }}
                </td>
            </tr>
            @endforeach

        </table>

    </div>

</div>

</x-app-layout>