@extends('layouts.app')

@section('content')
<!-- JQUERY & MDTimePicker CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/gh/dmuy/MDTimePicker/mdtimepicker.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/dmuy/MDTimePicker/mdtimepicker.js"></script>

<style>
    /* Penyesuaian agar picker terlihat modern dan konsisten dengan Tailwind */
    .mdtp__wrapper {
        font-family: inherit;
    }
    .mdtp__button {
        color: #2563eb !important;
    }
    .mdtp__digit.active, .mdtp__clock-dot, .mdtp__am.active, .mdtp__pm.active {
        background-color: #2563eb !important;
    }
    .mdtp__hand, .mdtp__hand-dot {
        fill: #2563eb !important;
        stroke: #2563eb !important;
    }
</style>

<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Tambah Absensi</h2>
        <a href="{{ route('absensi.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">&larr; Kembali</a>
    </div>

    <form action="{{ route('absensi.store') }}" method="POST">
        @csrf

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Pegawai</label>
            <select name="nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">-- Pilih Pegawai --</option>
                @foreach ($pegawai as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <select name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpha">Alpha</option>
                </select>
            </div>
        </div>

        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 mb-6">
            <h3 class="text-blue-800 font-bold mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Waktu Kerja (Klik untuk Analog)
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2 flex justify-between">
                        <span>Jam Masuk</span>
                        <button type="button" onclick="setCurrentTime('jam_masuk')" class="text-xs text-blue-600 hover:underline font-bold">Waktu Sekarang</button>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <input type="text" name="jam_masuk" id="jam_masuk" value="{{ date('H:i') }}" readonly
                            class="timepicker pl-10 block w-full border-gray-300 rounded-lg shadow-sm cursor-pointer focus:ring-blue-500 focus:border-blue-500 border p-2.5 bg-white transition duration-200">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2 flex justify-between">
                        <span>Jam Keluar (Opsional)</span>
                        <button type="button" onclick="setCurrentTime('jam_keluar')" class="text-xs text-red-600 hover:underline font-bold">Waktu Sekarang</button>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <input type="text" name="jam_keluar" id="jam_keluar" readonly
                            class="timepicker pl-10 block w-full border-gray-300 rounded-lg shadow-sm cursor-pointer focus:ring-blue-500 focus:border-blue-500 border p-2.5 bg-white transition duration-200" placeholder="--:--">
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                // Inisialisasi Analog Time Picker (24 jam)
                $('.timepicker').mdtimepicker({ 
                    format: 'hh:mm', 
                    hourPadding: true,
                    is24hour: true,
                    theme: 'blue'
                });
            });

            function setCurrentTime(id) {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const timeString = `${hours}:${minutes}`;
                
                // Set value ke input
                const input = document.getElementById(id);
                input.value = timeString;
                
                // Update MDTimePicker agar sinkron
                $(input).mdtimepicker('setValue', timeString);
            }
        </script>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-200">
                Simpan Absensi
            </button>
        </div>
    </form>
</div>
@endsection
