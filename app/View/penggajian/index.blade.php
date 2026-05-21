<x-app-layout>
<div class="p-6">
    <h2 class="text-xl font-bold">Data Penggajian</h2>

    <a href="{{ route('penggajian.create') }}" class="bg-blue-500 text-white px-3 py-2">
        Tambah Gaji
    </a>

    @if(session('success'))
        <div class="bg-green-200 p-2 mt-2">{{ session('success') }}</div>
    @endif

    <table class="w-full mt-4 border">
        <tr>
            <th>Nama</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan</th>
            <th>Potongan</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>

        @foreach($data as $d)
        <tr>
            <td>{{ $d->nama_pegawai }}</td>
            <td>{{ $d->gaji_pokok }}</td>
            <td>{{ $d->tunjangan }}</td>
            <td>{{ $d->potongan }}</td>
            <td>{{ $d->total_gaji }}</td>
            <td>
                <form action="{{ route('penggajian.destroy', $d->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 text-white px-2">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
</x-app-layout>