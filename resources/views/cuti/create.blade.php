<h2>Ajukan Cuti</h2>

<form action="{{ route('cuti.store') }}" method="POST">
@csrf
<input type="text" name="pegawai_id" value="23"><br>
<input type="text" name="nama_pegawai" placeholder="Nama"><br>
<input type="date" name="tanggal_mulai"><br>
<input type="date" name="tanggal_selesai"><br>
<textarea name="alasan" placeholder="Alasan"></textarea><br>

<button type="submit">Ajukan</button>
</form>