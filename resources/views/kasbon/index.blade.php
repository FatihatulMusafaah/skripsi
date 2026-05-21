<x-app-layout>

<div class="p-6">

    <a href="{{ route('kasbon.create') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded">
       Tambah Kasbon
    </a>

    <table class="w-full mt-5 border">
        <tr class="bg-gray-200">
            <th class="p-2">Pegawai</th>
            <th>Jumlah</th>
            <th>Metode</th>
            <th>Cicilan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        @foreach($kasbons as $kasbon)
        <tr class="text-center border">
            <td>{{ $kasbon->pegawai->nama }}</td>
            <td>Rp {{ number_format($kasbon->jumlah_kasbon) }}</td>
            <td>{{ $kasbon->metode_pembayaran }}</td>
            <td>
                {{ $kasbon->jumlah_cicilan ?? '-' }}
            </td>
            <td>{{ $kasbon->status }}</td>

            <td>
                <form action="{{ route('kasbon.destroy', $kasbon->id) }}"
                      method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="bg-red-500 text-white px-2 py-1 rounded">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>

</div>

</x-app-layout>