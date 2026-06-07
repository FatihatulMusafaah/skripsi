@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Absensi Saya</h1>
    <p class="text-gray-500">Catat kehadiran Anda hari ini.</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p>{{ session('error') }}</p>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-xl font-bold mb-4">Absen Hari Ini</h2>
            <p class="text-gray-600 mb-4">{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            
            @if(!$todayAbsen)
                <form action="{{ route('karyawan.absensi.masuk') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition">
                        Absen Masuk
                    </button>
                </form>
            @elseif(!$todayAbsen->jam_keluar)
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Jam Masuk:</p>
                    <p class="text-xl font-bold text-green-600">{{ $todayAbsen->jam_masuk }}</p>
                </div>
                <form action="{{ route('karyawan.absensi.pulang', $todayAbsen->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-lg hover:bg-red-700 transition">
                        Absen Pulang
                    </button>
                </form>
            @else
                <div class="space-y-4">
                    <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                        <p class="text-green-800 font-medium text-center">Anda sudah selesai absen hari ini.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <p class="text-xs text-gray-500 uppercase">Masuk</p>
                            <p class="font-bold">{{ $todayAbsen->jam_masuk }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500 uppercase">Pulang</p>
                            <p class="font-bold">{{ $todayAbsen->jam_keluar }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
            <h2 class="text-xl font-bold mb-4">Riwayat Absen Terakhir</h2>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm">
                        <th class="py-3 px-4 text-left">Tanggal</th>
                        <th class="py-3 px-4 text-left">Masuk</th>
                        <th class="py-3 px-4 text-left">Pulang</th>
                        <th class="py-3 px-4 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($absensi as $row)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ $row->jam_masuk ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $row->jam_keluar ?? '-' }}</td>
                        <td class="py-3 px-4 uppercase font-bold text-xs">
                            <span class="px-2 py-1 rounded {{ $row->status == 'hadir' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $row->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500 italic">Belum ada data absensi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
