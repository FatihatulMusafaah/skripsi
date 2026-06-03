<h1>Data Absensi</h1>

<a href="/absensi/create">Tambah Absensi</a>

<table border="1" cellpadding="10">

    <tr>
        <th>pegawai_id</th>
        <th>Nama Pegawai</th>
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Jam Pulang</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($absensi as $absen)

    <tr>

        <td>{{ $loop->iteration }}</td>

        <td>
            {{ $absen->pegawai->nama ?? '-' }}
        </td>

        <td>{{ $absen->tanggal }}</td>

        <td>{{ $absen->jam_masuk }}</td>

        <td>{{ $absen->jam_pulang ?? '-' }}</td>

        <td>{{ $absen->status }}</td>

        <td>

            @if(!$absen->jam_pulang)

                <a href="{{ route('absensi.pulang', $absen->id) }}">
                    Absen Pulang
                </a>

            @else

                Selesai

            @endif

        </td>

    </tr>

    @endforeach

</table>