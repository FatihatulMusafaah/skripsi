<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Kepegawaian</title>

    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-gray-800 text-white p-5 hidden md:block">

            <h2 class="text-2xl font-bold mb-6 text-blue-400">
                SI KEPEGAWAIAN
            </h2>

            <nav class="space-y-2">
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                    class="block p-3 rounded {{ request()->is('admin/dashboard') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('pegawai.index') }}"
                    class="block p-3 rounded {{ request()->is('admin/pegawai*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Laporan Pegawai
                    </a>

                    <a href="{{ route('absensi.index') }}"
                    class="block p-3 rounded {{ request()->is('admin/absensi*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Laporan Absensi
                    </a>

                    <a href="{{ route('cuti.index') }}"
                    class="block p-3 rounded {{ request()->is('admin/cuti*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Laporan Cuti
                    </a>

                    <a href="{{ route('penggajian.index') }}"
                    class="block p-3 rounded {{ request()->is('admin/penggajian*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Laporan Penggajian
                    </a>

                    <a href="{{ route('kasbon.index') }}"
                    class="block p-3 rounded {{ request()->is('admin/kasbon*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Laporan Kasbon
                    </a>

                    <a href="{{ route('riwayat-kasbon.index') }}"
                    class="block p-3 rounded {{ request()->is('admin/riwayat-kasbon*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Riwayat Kasbon
                    </a>

                    <a href="{{ route('laporan.index') }}"
                    class="block p-3 rounded {{ request()->is('admin/laporan*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Laporan
                    </a>
                @elseif(Auth::user()->role == 'owner')
                    <a href="{{ route('owner.dashboard') }}"
                    class="block p-3 rounded {{ request()->is('owner/dashboard') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Dashboard
                    </a>
                    <div class="px-3 py-2 text-xs font-bold text-gray-400 uppercase">Laporan</div>
                    <a href="{{ route('owner.laporan.pegawai') }}"
                    class="block p-3 rounded {{ request()->is('owner/laporan/pegawai') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Laporan Pegawai
                    </a>
                    <a href="{{ route('owner.laporan.absensi') }}"
                    class="block p-3 rounded {{ request()->is('owner/laporan/absensi') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Laporan Absensi
                    </a>
                    <a href="{{ route('owner.laporan.cuti') }}"
                    class="block p-3 rounded {{ request()->is('owner/laporan/cuti') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Laporan Cuti
                    </a>
                    <a href="{{ route('owner.laporan.kasbon') }}"
                    class="block p-3 rounded {{ request()->is('owner/laporan/kasbon') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Laporan Kasbon
                    </a>
                    <a href="{{ route('owner.laporan.penggajian') }}"
                    class="block p-3 rounded {{ request()->is('owner/laporan/penggajian') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Laporan Penggajian
                    </a>
                @elseif(Auth::user()->role == 'karyawan')
                    <a href="{{ route('karyawan.dashboard') }}"
                    class="block p-3 rounded {{ request()->is('pegawai/dashboard') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('karyawan.absensi') }}" class="block p-3 rounded {{ request()->is('pegawai/absensi*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">Absensi Saya</a>
                    <a href="{{ route('karyawan.cuti') }}" class="block p-3 rounded {{ request()->is('pegawai/cuti*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">Ajukan Cuti</a>
                    <a href="{{ route('karyawan.kasbon') }}" class="block p-3 rounded {{ request()->is('pegawai/kasbon*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">Kasbon</a>
                    <a href="{{ route('karyawan.riwayat_kasbon') }}" class="block p-3 rounded {{ request()->is('pegawai/riwayat-kasbon*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">Riwayat Kasbon</a>
                    <a href="{{ route('karyawan.slip_gaji') }}" class="block p-3 rounded {{ request()->is('pegawai/slip-gaji*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">Slip Gaji</a>
                    <a href="{{ route('karyawan.laporan') }}" class="block p-3 rounded {{ request()->is('pegawai/laporan*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">Laporan</a>
                @endif

                <div class="pt-10">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left p-3 rounded bg-red-600 hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </nav>

        </aside>

        <!-- CONTENT -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>

</body>
</html>
