@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">

        <h2>Data Pegawai</h2>

        <a href="{{ route('pegawai.create') }}"
           class="btn btn-primary">
            Tambah Pegawai
        </a>

    </div>

    <table class="table table-bordered">

        <thead class="table-dark">

            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($pegawais as $pegawai)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $pegawai->nama }}</td>

                <td>{{ $pegawai->email }}</td>

                <td>{{ $pegawai->jabatan }}</td>

                <td>{{ $pegawai->no_hp }}</td>

                <td>

                    <a href="{{ route('pegawai.edit', $pegawai->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('pegawai.destroy', $pegawai->id) }}"
                          method="POST"
                          style="display:inline;">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm">
                            Hapus
                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>
                <td colspan="6" class="text-center">
                    Data Pegawai Kosong
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection