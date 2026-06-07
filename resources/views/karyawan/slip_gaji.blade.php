@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Slip Gaji Saya</h1>
    <p class="text-gray-500">Daftar penghasilan bulanan Anda.</p>
</div>

<div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
    <table class="min-w-full table-auto">
        <thead>
            <tr class="bg-gray-100 text-gray-600 text-sm">
                <th class="py-3 px-4 text-left">Bulan / Tahun</th>
                <th class="py-3 px-4 text-left">Gaji Pokok</th>
                <th class="py-3 px-4 text-left">Lembur</th>
                <th class="py-3 px-4 text-left">Potongan</th>
                <th class="py-3 px-4 text-left">Total Diterima</th>
                <th class="py-3 px-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-sm">
            @forelse($gaji as $row)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4 font-medium">{{ $row->bulan }} {{ $row->tahun }}</td>
                <td class="py-3 px-4">Rp {{ number_format($row->gaji_pokok, 0, ',', '.') }}</td>
                <td class="py-3 px-4 text-green-600">+ Rp {{ number_format($row->lembur, 0, ',', '.') }}</td>
                <td class="py-3 px-4 text-red-600">- Rp {{ number_format($row->potongan_kasbon + $row->potongan_cuti, 0, ',', '.') }}</td>
                <td class="py-3 px-4 font-bold text-blue-600">Rp {{ number_format($row->total_gaji, 0, ',', '.') }}</td>
                <td class="py-3 px-4 text-center">
                    <a href="{{ route('karyawan.slip_gaji.show', $row->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded-md text-xs hover:bg-blue-700 transition">
                        Lihat Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-4 text-center text-gray-500 italic">Belum ada data penggajian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
