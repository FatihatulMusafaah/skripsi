<h2>Edit Pegawai</h2>

<form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
@csrf
@method('PUT')

<input type="text" name="nama" value="{{ $pegawai->nama }}"><br>
<input type="text" name="jabatan" value="{{ $pegawai->jabatan }}"><br>
<input type="email" name="email" value="{{ $pegawai->email }}"><br>
<input type="text" name="no_hp" value="{{ $pegawai->no_hp }}"><br>

<button type="submit">Update</button>
</form>