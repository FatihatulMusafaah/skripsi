@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Tambah Absensi</h2>

    <form action="{{ route('absensi.store') }}" method="POST">

        @csrf

        <!-- NAMA PEGAWAI -->
        <div class="mb-3">
    <label class="form-label">pegawai_id</label>

    <select name="pegawai_id" class="form-control">

        <option value="">-- Pilih Pegawai --</option>

        @foreach ($pegawais as $pegawai)

            <option value="{{ $pegawai->nama }}">
                {{ $pegawai->nama }}
            </option>

        @endforeach

    </select>
</div>
        <!-- TANGGAL -->
        <div class="mb-3">
            <label class="form-label">Tanggal</label>

            <input type="date"
                   name="tanggal"
                   class="form-control"
                   required>
        </div>

        <!-- JAM MASUK -->
        <div class="mb-3">
            <label class="form-label">Jam Masuk</label>

            <input type="time"
                   name="jam_masuk"
                   class="form-control">
        </div>

        <!-- JAM PULANG -->
        <div class="mb-3">
            <label class="form-label">Jam Pulang</label>

            <input type="time"
                   name="jam_keluar"
                   class="form-control">
        </div>

        <!-- STATUS -->
        <div class="mb-3">
            <label class="form-label">Status</label>

            <select name="status"
                    class="form-control"
                    required>

                <option value="">-- Pilih Status --</option>

                <option value="hadir">Hadir</option>
                <option value="terlambat">Terlambat</option>
                <option value="izin">Izin</option>
                <option value="alpa">Alpa</option>

            </select>
        </div>

        <!-- BUTTON -->
        <button type="submit" class="btn btn-primary">
            Simpan
        </button>

        <a href="{{ route('absensi.index') }}"
           class="btn   