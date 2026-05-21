<x-app-layout>

    <div class="p-6">

        <h1 class="text-2xl font-bold mb-4">
            Data Pegawai
        </h1>
        <a href="/pegawai/create"
   class="bg-blue-500 text-white px-4 py-2 rounded">
    Tambah Pegawai
</a>

        <table class="w-full border">

            <tr class="bg-gray-200">
                <th class="p-2">id</th>
                <th class="p-2">Nama</th>
                <th class="p-2">Jabatan</th>
                <th class="p-2">Email</th>
                <th class="p-2">no_hp</th>
                <th class="p-2">alamat</th>
            </tr>

            @foreach($pegawai as $p)

            <tr class="border-t">
                <td class="p-2">{{ $p->id }}</td>
                <td class="p-2">{{ $p->nama }}</td>
                <td class="p-2">{{ $p->jabatan }}</td>
                <td class="p-2">{{ $p->email }}</td>
                <td class="p-2">{{ $p->no_hp }}</td>
                <td class="p-2">{{ $p->alamat }}</td>
            </tr>

            @endforeach

        </table>

    </div>

</x-app-layout>