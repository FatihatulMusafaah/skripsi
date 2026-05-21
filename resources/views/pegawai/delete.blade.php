<h2>Hapus Pegawai</h2>

<p>Apakah Anda yakin ingin menghapus data berikut?</p>

<ul>
    <li>Nama: {{ $pegawai->id }}</li>
    <li>Nama: {{ $pegawai->nama }}</li>
    <li>Jabatan: {{ $pegawai->jabatan }}</li>
    <li>Email: {{ $pegawai->email }}</li>
    <li>Nama: {{ $pegawai->no_hp }}</li>
    <li>Nama: {{ $pegawai->alamat }}</li>
</ul>

<form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST">
    @csrf
    @method('DELETE')

    <button type="submit">Ya, Hapus</button>
    <a href="{{ route('pegawai.index') }}">Batal</a>
</form>