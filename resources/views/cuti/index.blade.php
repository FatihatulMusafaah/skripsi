<h2>Data Pengajuan Cuti</h2>

<a href="{{ route('cuti.create') }}">+ Ajukan Cuti</a>

@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<table border="1">
<tr>
    ,<th>id</th>
    <th>Nama</th>
    <th>tanggal_mulai</th>
    <th>tanggal_selesai</th>
    <th>Alasan</th>
    <th>Status</th>
</tr>

@foreach($cuti as $c)
<tr>
    <td>{{$c ->id }}</td>
    <td>{{ $c->nama_pegawai }}</td>
    <td>{{ $c->tanggal_mulai }} -
         {{ $c->tanggal_selesai }}</td>
    <td>{{ $c->alasan }}</td>
    <td>{{ $c->status }}</td>
    <td>
        <form action="{{ route('cuti.update',$c->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button>Setujui</button>
        </form>

        <form action="{{ route('cuti.destroy',$c->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button>Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>