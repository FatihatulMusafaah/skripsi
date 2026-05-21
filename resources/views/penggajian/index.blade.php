@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Penggajian</h2>

    <div class="card mb-4">
        <div class="card-body">

            <form action="/penggajian/store" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Pegawai</label>

                        <select name="pegawai_id" class="form-control">
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}">
                                    {{ $pegawai->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Bulan</label>

                        <input type="month"
                               name="bulan"
                               class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Gaji Pokok</label>

                        <input type="number"
                               name="gaji_pokok"
                               class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Jam Lembur</label>

                        <input type="number"
                               name="jam_lembur"
                               class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Tarif Lembur</label>

                        <input type="number"
                               name="tarif_lembur"
                               class="form-control">
                    </div>


                    <div class="col-md-4 mb-3">
                        <label>Potongan Kasbon</label>

                        <input type="number"
                               name="potongan_kasbon"
                               class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Potongan Lainnya</label>

                        <input type="number"
                               name="potongan_lainnya"
                               class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Keterangan</label>

                        <textarea name="keterangan"
                                  class="form-control"></textarea>
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-primary">
                            Simpan Penggajian
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Bulan</th>
                        <th>Total Gaji</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($penggajian as $gaji)

                    <tr>
                        <td>{{ $gaji->pegawai->nama }}</td>

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