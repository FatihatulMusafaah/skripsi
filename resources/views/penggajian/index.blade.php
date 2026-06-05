@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Data Penggajian</h2>
        <!-- Button to trigger modal or separate page for creating payroll -->
        <button onclick="toggleModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
            + Proses Gaji
        </button>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">No</th>
                    <th class="py-3 px-6 text-left">Nama Pegawai</th>
                    <th class="py-3 px-6 text-left">Bulan/Tahun</th>
                    <th class="py-3 px-6 text-left">Gaji Pokok</th>
                    <th class="py-3 px-6 text-left">Lembur</th>
                    <th class="py-3 px-6 text-left">Pot. Kasbon</th>
                    <th class="py-3 px-6 text-left">Pot. Cuti</th>
                    <th class="py-3 px-6 text-left">Gaji Bersih</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($penggajian as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6 text-left font-medium">{{ $item->user->name ?? '-' }}</td>
                        <td class="py-3 px-6 text-left">{{ $item->bulan }} {{ $item->tahun }}</td>
                        <td class="py-3 px-6 text-left">Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-left">
                            Rp {{ number_format($item->total_lembur, 0, ',', '.') }} 
                            <span class="text-xs text-gray-400">({{ $item->jam_lembur }} Jm)</span>
                        </td>
                        <td class="py-3 px-6 text-left text-red-500">- Rp {{ number_format($item->potongan_kasbon, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-left text-orange-500">- Rp {{ number_format($item->potongan_cuti, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-left font-bold text-green-600">Rp {{ number_format($item->gaji_bersih, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center gap-2">
                                <a href="{{ route('penggajian.edit', $item->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold">
                                    Edit
                                </a>
                                <form action="{{ route('penggajian.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data gaji ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-bold">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-6 text-center text-gray-500 italic">Data penggajian belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Simple Modal for Processing Payroll -->
<div id="payrollModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Proses Gaji Otomatis</h3>
            <p class="text-xs text-gray-500 mb-4">Sistem akan menghitung otomatis berdasarkan Absensi, Kasbon, dan Cuti pada bulan yang dipilih.</p>
            <form action="{{ route('penggajian.store') }}" method="POST" class="mt-4 text-left">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Pilih Pegawai</label>
                    <select name="user_id" class="w-full border rounded px-2 py-1" required>
                        @foreach ($pegawai as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-2 mb-3">
                    <div>
                        <label class="block text-sm font-bold mb-1">Bulan</label>
                        <select name="bulan" class="w-full border rounded px-2 py-1" required>
                            @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bln)
                                <option value="{{ $bln }}" {{ date('F') == $bln ? 'selected' : '' }}>{{ $bln }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Tahun</label>
                        <input type="number" name="tahun" value="{{ date('Y') }}" class="w-full border rounded px-2 py-1" required>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <button type="button" onclick="toggleModal()" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">Batal</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">Hitung & Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal() {
        document.getElementById('payrollModal').classList.toggle('hidden');
    }
</script>
@endsection
