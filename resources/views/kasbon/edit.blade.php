@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-dark text-white p-4">
                    <h4 class="mb-0">Edit Kasbon</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('kasbon.update', $kasbon->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pegawai</label>
                            <select name="pegawai_id" class="form-select" required>
                                @foreach($pegawai as $p)
                                    <option value="{{ $p->id }}" {{ $kasbon->pegawai_id == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah Kasbon</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="jumlah_kasbon" id="jumlah_kasbon" value="{{ (int)$kasbon->jumlah_kasbon }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                <option value="bayar_sekali" {{ $kasbon->metode_pembayaran == 'bayar_sekali' ? 'selected' : '' }}>Bayar Sekali</option>
                                <option value="cicilan" {{ $kasbon->metode_pembayaran == 'cicilan' ? 'selected' : '' }}>Cicilan</option>
                            </select>
                        </div>

                        <div id="cicilan_section" style="{{ $kasbon->metode_pembayaran == 'cicilan' ? '' : 'display: none;' }}">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Persentase Potongan Per Bulan</label>
                                <select name="persentase_potongan" id="persentase_potongan" class="form-select">
                                    <option value="">-- Pilih Persentase --</option>
                                    @for($i=30; $i<=100; $i+=10)
                                        <option value="{{ $i }}" {{ $kasbon->persentase_potongan == $i ? 'selected' : '' }}>{{ $i }}%</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $kasbon->status == 'pending' ? 'selected' : '' }}>PENDING</option>
                                <option value="aktif" {{ $kasbon->status == 'aktif' ? 'selected' : '' }}>AKTIF</option>
                                <option value="ditolak" {{ $kasbon->status == 'ditolak' ? 'selected' : '' }}>DITOLAK</option>
                                <option value="lunas" {{ $kasbon->status == 'lunas' ? 'selected' : '' }}>LUNAS</option>
                            </select>
                        </div>

                        <div class="bg-light p-4 rounded-3 mb-4">
                            <h5 class="mb-3 border-bottom pb-2">Ringkasan Kasbon</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small text-muted d-block">Potongan Per Bulan</label>
                                    <span class="h5" id="text_potongan">Rp {{ number_format($kasbon->potongan_per_bulan, 0, ',', '.') }}</span>
                                    <input type="hidden" name="potongan_per_bulan" id="potongan_per_bulan" value="{{ $kasbon->potongan_per_bulan }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted d-block">Lama Cicilan</label>
                                    <span class="h5" id="text_cicilan">{{ $kasbon->lama_cicilan }} Bulan</span>
                                    <input type="hidden" name="lama_cicilan" id="lama_cicilan" value="{{ $kasbon->lama_cicilan }}">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-lg py-3 fw-bold">Update Kasbon</button>
                            <a href="{{ route('kasbon.index') }}" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputJumlah = document.getElementById('jumlah_kasbon');
        const selectMetode = document.getElementById('metode_pembayaran');
        const selectPersen = document.getElementById('persentase_potongan');
        const cicilanSection = document.getElementById('cicilan_section');

        const textPotongan = document.getElementById('text_potongan');
        const textCicilan = document.getElementById('text_cicilan');
        const hiddenPotongan = document.getElementById('potongan_per_bulan');
        const hiddenCicilan = document.getElementById('lama_cicilan');

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        }

        function calculate() {
            const jumlah = parseFloat(inputJumlah.value) || 0;
            const metode = selectMetode.value;
            const persen = parseFloat(selectPersen.value) || 0;

            let potongan = 0;
            let tenor = 0;

            if (metode === 'bayar_sekali') {
                cicilanSection.style.display = 'none';
                potongan = jumlah;
                tenor = 1;
            } else {
                cicilanSection.style.display = 'block';
                if (persen > 0) {
                    potongan = (jumlah * persen) / 100;
                    tenor = Math.ceil(jumlah / potongan);
                }
            }

            textPotongan.innerText = formatRupiah(potongan);
            textCicilan.innerText = tenor + ' Bulan';
            hiddenPotongan.value = potongan;
            hiddenCicilan.value = tenor;
        }

        inputJumlah.addEventListener('input', calculate);
        selectMetode.addEventListener('change', calculate);
        selectPersen.addEventListener('change', calculate);
    });
</script>
@endsection
