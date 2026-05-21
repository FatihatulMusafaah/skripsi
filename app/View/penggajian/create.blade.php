<x-app-layout>
<div class="p-6">
    <h2 class="text-xl font-bold">Input Gaji</h2>

    <form action="{{ route('penggajian.store') }}" method="POST">
        @csrf

        <input type="text" name="nama_pegawai" placeholder="Nama" class="border p-2 w-full mb-2">

        <input type="number" name="gaji_pokok" placeholder="Gaji Pokok" class="border p-2 w-full mb-2">

        <input type="number" name="tunjangan" placeholder="Tunjangan" class="border p-2 w-full mb-2">

        <input type="number" name="potongan" placeholder="Potongan" class="border p-2 w-full mb-2">

        <button class="bg-blue-500 text-white px-4 py-2">Simpan</button>
    </form>
</div>
</x-app-layout>