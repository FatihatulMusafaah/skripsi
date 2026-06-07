@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Detail Slip Gaji</h1>
        <p class="text-gray-500">Periode: {{ $gaji->bulan }} {{ $gaji->tahun }}</p>
    </div>
    <a href="{{ route('karyawan.slip_gaji') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
        &larr; Kembali
    </a>
</div>

<div class="max-w-2xl mx-auto bg-white p-10 rounded-xl shadow-lg border border-gray-200">
    <!-- HEADER SLIP -->
    <div class="text-center border-bottom pb-6 mb-6">
        <h2 class="text-2xl font-bold uppercase tracking-widest">Slip Gaji Karyawan</h2>
        <p class="text-gray-500">{{ config('app.name') }}</p>
    </div>

    <!-- INFO KARYAWAN -->
    <div class="grid grid-cols-2 gap-4 mb-8 text-sm">
        <div>
            <p class="text-gray-400 uppercase text-[10px]">Nama Karyawan</p>
            <p class="font-bold">{{ $gaji->user->name }}</p>
        </div>
        <div class="text-right">
            <p class="text-gray-400 uppercase text-[10px]">Jabatan</p>
            <p class="font-bold">{{ $gaji->user->jabatan ?? '-' }}</p>
        </div>
    </div>

    <!-- DETAIL PENGHASILAN -->
    <div class="mb-8">
        <h3 class="font-bold border-b pb-2 mb-4 uppercase text-xs text-blue-600">Penghasilan</h3>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Gaji Pokok</span>
                <span class="font-medium">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Tunjangan Lembur</span>
                <span class="font-medium text-green-600">+ Rp {{ number_format($gaji->lembur, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- DETAIL POTONGAN -->
    <div class="mb-8">
        <h3 class="font-bold border-b pb-2 mb-4 uppercase text-xs text-red-600">Potongan</h3>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Potongan Kasbon</span>
                <span class="font-medium text-red-600">- Rp {{ number_format($gaji->potongan_kasbon, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Potongan Cuti (Tidak Hadir)</span>
                <span class="font-medium text-red-600">- Rp {{ number_format($gaji->potongan_cuti, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- TOTAL -->
    <div class="bg-blue-600 p-4 rounded-lg text-white">
        <div class="flex justify-between items-center">
            <span class="font-bold uppercase tracking-wider">Total Gaji Bersih (Take Home Pay)</span>
            <span class="text-xl font-black">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="mt-10 text-center text-[10px] text-gray-400 italic">
        * Dicetak secara otomatis oleh Sistem Informasi Kepegawaian pada {{ now()->format('d/m/Y H:i') }}
    </div>
</div>
@endsection
