<x-app-layout>
    <div class="p-6">

        <h2 class="text-xl font-bold mb-4">Data Absensi</h2>

        <a href="{{ route('absensi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Absen Masuk
        </a>

        @if(session('success'))
            <div class="bg-green-200 p-2 mt-2">{{ session('success') }}</div>
        @endif

        <table class="table-auto w-full mt-4 border">
            <thead>
                <tr class="bg-gray-200">
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensi as $a)
                <tr class="text-center border">
                    <td>{{ $a->nama_pegawai }}</td>
                    <td>{{ $a->tanggal }}</td>
                    <td>{{ $a->jam_masuk }}</td>
                    <td>{{ $a->jam_keluar ?? '-' }}</td>
                    <td>
                        @if(!$a->jam_keluar)
                        <form action="{{ route('absensi.update', $a->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="bg-green-500 text-white px-2 py-1">Pulang</button>
                        </form>
                        @endif

                        <form action="{{ route('absensi.destroy', $a->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-2 py-1 mt-1">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>