<h1>Data Kasbon</h1>

<a href="/kasbon/create">Tambah Kasbon</a>

<table border="1" cellpadding="10">

    <tr>
        <th>No</th>
        <th>Nama Pegawai</th>
        <th>Jumlah Kasbon</th>
        <th>Metode</th>
        <th>Sisa Kasbon</th>
        <th>Status</th>
    </tr>

    @foreach($kasbon as $kasbon)

    <tr>

        <td>{{ $loop->iteration }}</td>

        <td>
            {{ $kasbon->pegawai->nama ?? '-' }}
        </td>

        <td>
            Rp {{ number_format($kasbon->jumlah_kasbon) }}
        </td>

        <td>
            {{ $kasbon->metode_pembayaran }}
        </td>

        <td>
            Rp {{ number_format($kasbon->sisa_kasbon) }}
        </td>

        <td>
            {{ $kasbon->status }}
        </td>

    </tr>

    @endforeach

</table>