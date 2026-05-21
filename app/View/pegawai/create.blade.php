<h2>Tambah Pegawai</h2>

<form action="{{ route('pegawai.store') }}" method="POST">
@csrf

<input type="text" name="nama" placeholder="Nama"><br>
<input type="text" name="jabatan" placeholder="Jabatan"><br>
<input type="email" name="email" placeholder="Email"><br>
<input type="text" name="no_hp" placeholder="No HP"><br>

<button type="submit">Simpan</button>
</form>