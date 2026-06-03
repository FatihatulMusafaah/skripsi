@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="mb-5">

        <h1 class="fw-bold text-primary">
            Laporan Sistem Informasi Kepegawaian
        </h1>

    </div>

    {{-- DATA PEGAWAI --}}
    <div class="card shadow border-0 mb-5">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">
                Data Pegawai
            </h5>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>No HP</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($pegawai as $pegawai)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $pegawai->nama }}</td>

                        <td>{{ $pegawai->email }}</td>

                        <td>{{ $pegawai->jabatan }}</td>

                        <td>{{ $pegawai->no_hp }}</td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    {{-- DATA ABSENSI --}}
    <div class="card shadow border-0 mb-5">

        <div class="card-header bg-success text-white">

            <h5 class="mb-0">
                Data Absensi
            </h5>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($absensi as $absen)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $absen->pegawai->nama ?? '-' }}</td>

                        <td>{{ $absen->tanggal }}</td>

                        <td>{{ $absen->jam_masuk }}</td>

                        <td>{{ $absen->jam_pulang ?? '-' }}</td>

                        <td>{{ $absen->status }}</td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    {{-- DATA CUTI --}}
    <div class="card shadow border-0 mb-5">

        <div class="card-header bg-warning">

            <h5 class="mb-0">
                Data Cuti
            </h5>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Alasan</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($cuti as $cuti)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $cuti->pegawai->nama ?? '-' }}</td>

                        <td>{{ $cuti->tanggal_mulai }}</td>

                        <td>{{ $cuti->tanggal_selesai }}</td>

                        <td>{{ $cuti->alasan }}</td>

                        <td>{{ $cuti->status }}</td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    {{-- DATA KASBON --}}
    <div class="card shadow border-0 mb-5">

        <div class="card-header bg-danger text-white">

            <h5 class="mb-0">
                Data Kasbon
            </h5>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Jumlah Kasbon</th>
                        <th>Metode</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($kasbon as $kasbon)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $kasbon->pegawai->nama ?? '-' }}</td>

                        <td>
                            Rp {{ number_format($kasbon->jumlah_kasbon) }}
                        </td>

                        <td>{{ $kasbon->metode_pembayaran }}</td>

                        <td>{{ $kasbon->status }}</td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    {{-- DATA PENGGAJIAN --}}
    <div class="card shadow border-0 mb-5">

        <div class="card-header bg-info text-white">

            <h5 class="mb-0">
                Data Penggajian
            </h5>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Bulan</th>
                        <th>Total Gaji</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($penggajian as $gaji)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $gaji->pegawai->nama ?? '-' }}</td>

                        <td>{{ $gaji->bulan }}</td>

                        <td>
                            Rp {{ number_format($gaji->total_gaji) }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection