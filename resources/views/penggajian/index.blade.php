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
                    <th class="py-3 px-6 text-left">Gaji Pokok</th>
                    <th class="py-3 px-6 text-left">Lembur</th>
                    <th class="py-3 px-6 text-left">Potongan</th>
                    <th class="py-3 px-6 text-left">Total Diterima</th>
                    <th class="py-3 px-6 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($penggajian as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6 text-left font-medium">{{ $item->user->name ?? '-' }}</td>
                        <td class="py-3 px-6 text-left">Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-left">Rp {{ number_format($item->lembur, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-left text-red-500">- Rp {{ number_format($item->potongan, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-left font-bold text-green-600">Rp {{ number_format($item->total_gaji, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-left">{{ $item->tanggal }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-gray-500 italic">Data penggajian belum tersedia.</td>
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
            <h3 class="text-lg leading-6 font-medium text-gray-900">Proses Gaji Pegawai</h3>
            <form action="{{ route('penggajian.store') }}" method="POST" class="mt-4 text-left">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Pilih Pegawai</label>
                    <select name="user_id" class="w-full border rounded px-2 py-1" required>
                        @foreach ($pegawai as $p)
                            <option value="{{ $p->id }}">{{ $p->name }} (Rp {{ number_format($p->gaji_pokok, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Bulan</label>
                    <input type="month" name="bulan" class="w-full border rounded px-2 py-1" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Gaji Pokok</label>
                    <input type="number" name="gaji_pokok" class="w-full border rounded px-2 py-1" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Jam Lembur</label>
                    <input type="number" name="jam_lembur" value="0" class="w-full border rounded px-2 py-1">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Tarif Lembur (Per Jam)</label>
                    <input type="number" name="tarif_lembur" value="0" class="w-full border rounded px-2 py-1">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Potongan Kasbon</label>
                    <input type="number" name="potongan_kasbon" value="0" class="w-full border rounded px-2 py-1">
                </div>
                <div class="flex items-center justify-between mt-4">
                    <button type="button" onclick="toggleModal()" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">Batal</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Proses</button>
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
