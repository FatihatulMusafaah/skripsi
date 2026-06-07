@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center" id="data_pegawai" data-gaji="{{ Auth::user()->gaji_pokok ?? 2000000 }}">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Kasbon Karyawan</h1>
        <p class="text-gray-500">Ajukan dan pantau status kasbon Anda.</p>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif

<!-- INFO SUMMARY -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Kasbon</h3>
        <p class="text-2xl font-bold text-gray-800 mt-2">Rp {{ number_format($riwayat->total_kasbon ?? 0, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow border-l-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Telah Dibayar</h3>
        <p class="text-2xl font-bold text-gray-800 mt-2">Rp {{ number_format($riwayat->kasbon_dibayar ?? 0, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow border-l-4 border-red-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Sisa Kasbon</h3>
        <p class="text-2xl font-bold text-red-600 mt-2">Rp {{ number_format($riwayat->sisa_kasbon ?? 0, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- FORM PENGAJUAN -->
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-xl font-bold mb-4">Ajukan Kasbon Baru</h2>
            <form action="{{ route('karyawan.kasbon.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Kasbon (Rp)</label>
                    <input type="number" name="jumlah_kasbon" id="jumlah_kasbon" class="w-full border rounded-lg p-2 focus:ring-red-500" placeholder="Contoh: 1000000" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metode_pembayaran" class="w-full border rounded-lg p-2 focus:ring-red-500" required>
                        <option value="bayar_sekali">Bayar Sekali (Bulan Depan)</option>
                        <option value="cicilan">Cicilan</option>
                    </select>
                </div>
                
                <div id="cicilan_section" class="hidden">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Persentase Potongan Gaji (%)</label>
                        <select name="persentase_potongan" id="persentase_potongan" class="w-full border rounded-lg p-2 focus:ring-red-500">
                            <option value="">-- Pilih Persentase --</option>
                            @for($i=30; $i<=100; $i+=10)
                                <option value="{{ $i }}">{{ $i }}% dari Gaji Pokok</option>
                            @endfor
                        </select>
                        <p class="text-[10px] text-gray-400 mt-1">* Minimal 30%</p>
                    </div>
                </div>

                <!-- RINGKASAN -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-100">
                    <h3 class="text-xs font-bold uppercase text-gray-400 mb-2">Ringkasan Pengajuan</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Bayar per Bulan:</span>
                            <span class="font-bold text-red-600" id="text_cicilan">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Lama Cicilan:</span>
                            <span class="font-bold text-gray-800" id="text_tenor">0 Bulan</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-lg hover:bg-red-700 transition">
                    Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>

    <!-- DAFTAR PENGAJUAN -->
    <div class="lg:col-span-2">
        <div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
            <h2 class="text-xl font-bold mb-4">Daftar Pengajuan Kasbon</h2>
            <table class="min-w-full table-auto text-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <th class="py-3 px-4 text-left">Tanggal</th>
                        <th class="py-3 px-4 text-left">Jumlah</th>
                        <th class="py-3 px-4 text-left">Metode</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kasbon as $row)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $row->created_at->format('d/m/Y') }}</td>
                        <td class="py-3 px-4 font-bold">Rp {{ number_format($row->jumlah_kasbon, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 capitalize">{{ str_replace('_', ' ', $row->metode_pembayaran) }}</td>
                        <td class="py-3 px-4 text-center">
                            @php
                                $statusClass = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'aktif' => 'bg-green-100 text-green-700',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                    'lunas' => 'bg-gray-100 text-gray-700',
                                ][$row->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="px-2 py-1 rounded-full font-bold text-[10px] {{ $statusClass }}">
                                {{ strtoupper($row->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500 italic">Belum ada data kasbon.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const inputJumlah = document.getElementById('jumlah_kasbon');
    const selectMetode = document.getElementById('metode_pembayaran');
    const selectPersen = document.getElementById('persentase_potongan');
    const cicilanSection = document.getElementById('cicilan_section');
    
    const textCicilan = document.getElementById('text_cicilan');
    const textTenor = document.getElementById('text_tenor');
    
    const gajiPokok = parseFloat(document.getElementById('data_pegawai').dataset.gaji);

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    function calculate() {
        const jumlah = parseFloat(inputJumlah.value) || 0;
        const metode = selectMetode.value;
        
        let potongan = 0;
        let tenor = 0;

        if (metode === 'bayar_sekali') {
            cicilanSection.classList.add('hidden');
            potongan = jumlah;
            tenor = 1;
        } else {
            cicilanSection.classList.remove('hidden');
            const persen = parseFloat(selectPersen.value) || 0;
            if (persen > 0) {
                // Rumus: Gaji Pokok * Persentase
                potongan = (gajiPokok * persen) / 100;
                // Rumus: Total Kasbon / Potongan per Bulan
                tenor = Math.ceil(jumlah / potongan);
            }
        }

        textCicilan.innerText = formatRupiah(potongan);
        textTenor.innerText = tenor + ' Bulan';
    }

    inputJumlah.addEventListener('input', calculate);
    selectMetode.addEventListener('change', calculate);
    selectPersen.addEventListener('change', calculate);
</script>
@endsection
