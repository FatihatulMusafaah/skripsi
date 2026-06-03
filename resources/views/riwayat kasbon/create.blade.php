@extends('layouts.app')

@section('content')

<div class="container">

```
<h2>Tambah Riwayat Kasbon</h2>

<form action="{{ route('riwayat-kasbon.store') }}"
      method="POST">

    @csrf

    <div class="mb-3">
        <label>Pegawai</label>

        <select name="pegawai_id" class="form-control">
            <option value="">Pilih Pegawai</option>

            @foreach($pegawai as $p)
                <option value="{{ $p->id }}">
                    {{ $p->nama_pegawai }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Total Kasbon</label>
        <input type="number"
               name="total_kasbon"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Kasbon Dibayar</label>
        <input type="number"
               name="kasbon_dibayar"
               class="form-control">
    </div>

    <button type="submit"
            class="btn btn-success">
        Simpan
    </button>

</form>
```

</div>
@endsection
