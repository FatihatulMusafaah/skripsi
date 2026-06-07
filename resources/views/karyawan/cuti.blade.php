@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Pengajuan Cuti</h1>
    <p class="text-gray-500">Ajukan permohonan cuti Anda.</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-xl font-bold mb-4">Form Pengajuan</h2>
            <form action="{{ route('karyawan.cuti.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="w-full border rounded-lg p-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="w-full border rounded-lg p-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Alasan Cuti</label>
                    <textarea name="alasan" class="w-full border rounded-lg p-2 focus:ring-blue-500" rows="3" placeholder="Contoh: Keperluan keluarga" required></textarea>
                </div>
                <button type="submit" class="w-full bg-yellow-600 text-white font-bold py-3 rounded-lg hover:bg-yellow-700 transition">
                    Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
            <h2 class="text-xl font-bold mb-4">Riwayat Cuti</h2>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm">
                        <th class="py-3 px-4 text-left">Mulai</th>
                        <th class="py-3 px-4 text-left">Selesai</th>
                        <th class="py-3 px-4 text-left">Alasan</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($cuti as $row)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($row->tanggal_mulai)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ $row->alasan }}</td>
                        <td class="py-3 px-4 text-center">
                            @php
                                $statusClass = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'disetujui' => 'bg-green-100 text-green-700',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                ][$row->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="px-2 py-1 rounded-full font-bold text-xs {{ $statusClass }}">
                                {{ strtoupper($row->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500 italic">Belum ada riwayat cuti.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
