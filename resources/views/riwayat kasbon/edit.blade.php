@extends('layouts.app')

@section('content')

<div class="container">

```
<h2>Edit Riwayat Kasbon</h2>

<form action="{{ route('riwayat-kasbon.update',$riwayat->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Pegawai</label>

        <select name="pegawai_id" class="form-control">

            @foreach($pegawai as $p)

                <option value="{{ $p->id }}"
                    {{ $riwayat->pegawai_id == $p->id ? 'selected' : '' }}>

                    {{ $p->nama_pegawai }}

                </option>

            @endforeach

        </select>
    </div>

    <div class="mb-3">
        <label>Total Kasbon</label>

        <input type="number"
               name="total_kasbon"
               value="{{ $riwayat->total_kasbon }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Kasbon Dibayar</label>

        <input type="number"
               name="kasbon_dibayar"
               value="{{ $riwayat->kasbon_dibayar }}"
               class="form-control">
    </div>

    <button type="submit"
            class="btn btn-primary">
        Update
    </button>

</form>
```

</div>
@endsection
