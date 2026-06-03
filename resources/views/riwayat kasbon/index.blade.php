@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Riwayat Kasbon</h2>

```
<a href="{{ route('riwayat-kasbon.create') }}" class="btn btn-primary mb-3">
    Tambah Riwayat Kasbon
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Pegawai</th>
            <th>Total Kasbon</th>
            <th>Kasbon Dibayar</th>
            <th>Sisa Kasbon</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($riwayat as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->pegawai->nama_pegawai }}</td>
            <td>Rp {{ number_format($item->total_kasbon,0,',','.') }}</td>
            <td>Rp {{ number_format($item->kasbon_dibayar,0,',','.') }}</td>
            <td>Rp {{ number_format($item->sisa_kasbon,0,',','.') }}</td>

            <td>
                <a href="{{ route('riwayat-kasbon.edit',$item->id) }}"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('riwayat-kasbon.destroy',$item->id) }}"
                      method="POST"
                      style="display:inline">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Hapus data?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
```

</div>
@endsection
