@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold text-primary">
                Pengajuan Cuti
            </h2>

        </div>

        <a href="{{ route('cuti.index') }}"
           class="btn btn-secondary rounded-pill">


        </a>

    </div>

    {{-- CARD --}}
    <div class="card border-0 shadow-lg rounded-4">

        <div class="card-body p-5">

            {{-- ERROR --}}
            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- FORM --}}
            <form action="{{ route('cuti.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                      <div class="col-md-6 mb-4">
                        <label class="form-label fw-semibold">
                            pegawai_id
                        </label>
                        <textarea name="alasan"
                                  rows= "1"
                                  class= "form-control"
                                  placeholder= "Masukkan id"></textarea>
                    </div>

                    {{-- PEGAWAI --}}
                    <div class="col-md-6 mb-4">

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

                  


                    {{-- TANGGAL MULAI --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">
                            Tanggal Mulai
                        </label>

                        <input type="date"
                               name="tanggal_mulai"
                               class="form-control">

                    </div>

                    {{-- TANGGAL SELESAI --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">
                            Tanggal Selesai
                        </label>

                        <input type="date"
                               name="tanggal_selesai"
                               class="form-control">

                    </div>

                    
                    {{-- STATUS --}}
                    <div class="col-md-6 mb-4">
                       

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="Menunggu">
                                Menunggu
                            </option>

                            <option value="Disetujui">
                                Disetujui
                            </option>

                            <option value="Ditolak">
                                Ditolak
                            </option>

                        </select>

                    </div>

                    {{-- ALASAN --}}
                    <div class="col-md-12 mb-4">

                        <label class="form-label fw-semibold">
                            Alasan Cuti
                        </label>

                        <textarea name="alasan"
                                  rows="5"
                                  class="form-control"
                                  placeholder="Masukkan alasan cuti"></textarea>

                    </div>

                    {{-- BUTTON --}}
                    <div class="col-md-12">

                        <button type="submit"
                                class="btn btn-primary px-5 py-2 rounded-pill">

                            Simpan Pengajuan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection