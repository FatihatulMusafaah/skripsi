@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold text-primary mb-1">
                Data Penggajian
            </h2>

            <p class="text-muted">
                Sistem Informasi Penggajian Pegawai
            </p>
        </div>

    </div>

    {{-- FORM CARD --}}
    <div class="card border-0 shadow-lg rounded-4 mb-5">

        <div class="card-header bg-primary text-white rounded-top-4 py-3">

            <h5 class="mb-0">
                Form Penggajian
            </h5>

        </div>

        <div class="card-body p-4">

            <form action="/penggajian/store" method="POST">

                @csrf

                <div class="row">

                    {{-- PEGAWAI --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">
                           nama pegawai
                        </label>

                        <select name="pegawai_id"
                                class="form-select">

                            <option value="">
                                -- Pilih Pegawai --
                            </option>

                            @foreach($pegawai as $pegawai)

                                <option value="{{ $pegawai->id }}">

                                    {{ $pegawai->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- BULAN --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">
                            Bulan
                        </label>

                        <input type="month"
                               name="bulan"
                               class="form-control">

                    </div>

                    {{-- GAJI POKOK --}}
                    <div class="col-md-4 mb-4">

                        <label class="form-label fw-semibold">
                            Gaji Pokok
                        </label>

                        <input type="number"
                               name="gaji_pokok"
                               class="form-control"
                               placeholder="Masukkan gaji pokok">

                    </div>

                    {{-- JAM LEMBUR --}}
                    <div class="col-md-4 mb-4">

                        <label class="form-label fw-semibold">
                            Jam Lembur
                        </label>

                        <input type="number"
                               name="jam_lembur"
                               class="form-control"
                               placeholder="Masukkan jam lembur">

                    </div>

                    {{-- TARIF LEMBUR --}}
                    <div class="col-md-4 mb-4">

                        <label class="form-label fw-semibold">
                            Tarif Lembur
                        </label>

                        <input type="number"
                               name="tarif_lembur"
                               class="form-control"
                               placeholder="Masukkan tarif lembur">

                    </div>

                    {{-- POTONGAN KASBON --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">
                            Potongan Kasbon
                        </label>

                        <input type="number"
                               name="potongan_kasbon"
                               class="form-control"
                               placeholder="Masukkan potongan kasbon">

                    </div>

                    {{-- POTONGAN LAIN --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">
                            Potongan Lainnya
                        </label>

                        <input type="number"
                               name="potongan_lainnya"
                               class="form-control"
                               placeholder="Masukkan potongan lainnya">

                    </div>

                    {{-- KETERANGAN --}}
                    <div class="col-md-12 mb-4">

                        <label class="form-label fw-semibold">
                            Keterangan
                        </label>

                        <textarea name="keterangan"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Masukkan keterangan"></textarea>

                    </div>

                    {{-- BUTTON --}}
                    <div class="col-md-12">

                        <button type="submit"
                                class="btn btn-primary px-5 py-2 rounded-pill shadow">

                            Simpan Penggajian

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- TABLE CARD --}}
    <div class="card border-0 shadow-lg rounded-4">

        <div class="card-header bg-dark text-white rounded-top-4 py-3">

            <h5 class="mb-0">
                Data Penggajian Pegawai
            </h5>

        </div>

        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>No</th>

                            <th>Nama Pegawai</th>

                            <th>Bulan</th>

                            <th>Gaji Pokok</th>

                            <th>Lembur</th>

                            <th>Potongan</th>

                            <th>Total Gaji</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($penggajian as $gaji)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td class="fw-semibold">

                                {{ $gaji->pegawai->nama ?? '-' }}

                            </td>

                            <td>

                                {{ $gaji->bulan }}

                            </td>

                            <td>

                                Rp {{ number_format($gaji->gaji_pokok) }}

                            </td>

                            <td class="text-success fw-semibold">

                                Rp {{ number_format($gaji->jam_lembur * $gaji->tarif_lembur) }}

                            </td>

                            <td class="text-danger fw-semibold">

                                Rp {{ number_format($gaji->potongan_kasbon + $gaji->potongan_lainnya) }}

                            </td>

                            <td class="fw-bold text-primary">

                                Rp {{ number_format($gaji->total_gaji) }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="text-center text-muted py-4">

                                Data penggajian belum tersedia

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection