@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Data Penggajian</h2>
        <a href="{{ route('penggajian.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">&larr; Kembali</a>
    </div>

    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
        <p class="text-blue-800"><strong>Pegawai:</strong> {{ $penggajian->user->name }}</p>
        <p class="text-blue-800"><strong>Periode:</strong> {{ $penggajian->bulan }} {{ $penggajian->tahun }}</p>
    </div>

    <form action="{{ route('penggajian.update', $penggajian->id) }}" method="POST" id="editGajiForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- GAJI POKOK --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Gaji Pokok</label>
                <input type="number" name="gaji_pokok" id="gaji_pokok" value="{{ $penggajian->gaji_pokok }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- JAM LEMBUR --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Jam Lembur</label>
                <input type="number" name="jam_lembur" id="jam_lembur" value="{{ $penggajian->jam_lembur }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- TOTAL LEMBUR --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Total Uang Lembur</label>
                <input type="number" name="total_lembur" id="total_lembur" value="{{ $penggajian->total_lembur }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- POTONGAN KASBON --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Potongan Kasbon</label>
                <input type="number" name="potongan_kasbon" id="potongan_kasbon" value="{{ $penggajian->potongan_kasbon }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- POTONGAN CUTI --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Potongan Cuti</label>
                <input type="number" name="potongan_cuti" id="potongan_cuti" value="{{ $penggajian->potongan_cuti }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- GAJI BERSIH --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2 text-green-700">Gaji Bersih (Total)</label>
                <input type="number" name="gaji_bersih" id="gaji_bersih" value="{{ $penggajian->gaji_bersih }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-green-700 font-bold bg-green-50 focus:outline-none border-green-300" readonly>
                <p class="text-xs text-gray-500 mt-1">* Dihitung otomatis: (Gaji Pokok + Lembur) - Potongan</p>
            </div>
        </div>

        <div class="flex items-center justify-end mt-8 gap-4">
            <button type="button" onclick="calculateNet()" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded focus:outline-none transition">
                Hitung Ulang
            </button>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function calculateNet() {
        const pokok = parseFloat(document.getElementById('gaji_pokok').value) || 0;
        const lemburVal = parseFloat(document.getElementById('total_lembur').value) || 0;
        const jamLembur = parseFloat(document.getElementById('jam_lembur').value) || 0;
        const kasbon = parseFloat(document.getElementById('potongan_kasbon').value) || 0;
        const cuti = parseFloat(document.getElementById('potongan_cuti').value) || 0;

        // Jika user mengubah jam lembur saja, hitung ulang total lembur (25rb/jam)
        // Namun di form edit kita biarkan fleksibel.
        
        const bersih = (pokok + lemburVal) - (kasbon + cuti);
        document.getElementById('gaji_bersih').value = bersih;
    }

    // Auto-calculate on change
    const inputs = ['gaji_pokok', 'total_lembur', 'potongan_kasbon', 'potongan_cuti'];
    inputs.forEach(id => {
        document.getElementById(id).addEventListener('input', calculateNet);
    });
</script>
@endsection
