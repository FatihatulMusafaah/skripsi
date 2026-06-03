<h1>Data Pegawai</h1>

<a href="/pegawai/create">Tambah Pegawai</a>

<table border="1" cellpadding="10">
    <tr>
        <th>id_pegawai</th>
        <th>Nama</th>
        <th>jabatan</th>
        <th>email</th>
        <th>No HP</th>
        <th>alamat</th>
    </tr>

    @foreach($pegawai as $pegawai)
    <tr>
        <td>{{ $loop->iteration }}</td>
         <td>{{ $pegawai->id_pegawai }}</td>
        <td>{{ $pegawai->nama }}</td>
        <td>{{ $pegawai->jabatan }}</td>
        <td>{{ $pegawai->email }}</td>
        <td>{{ $pegawai->no_hp }}</td>
        <td>{{ $pegawai->alamat }}</td>
    </tr>
    @endforeach
</table>