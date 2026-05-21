<x-app-layout>

<div class="p-6">

<form action="{{ route('kasbon.store') }}" method="POST">

    @csrf

    <div class="mb-3">
        <label>Nama Pegawai</label>

        <select name="pegawai_id" class="border w-full p-2">
            @foreach($pegawais as $pegawai)
                <option value="{{ $pegawai->id }}">
                    {{ $pegawai->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Jumlah Kasbon</label>

        <input type="number"
               name="jumlah_kasbon"
               class="border w-full p-2">
    </div>

    <div class="mb-3">
        <label>Metode Pembayaran</label>

        <select name="metode_pembayaran"
                class="border w-full p-2">

            <option value="sekali_bayar">
                Sekali Bayar
            </option>

            <option value="cicilan">
                Cicilan
            </option>

        </select>
    </div>

    <div class="mb-3">
        <label>Jumlah Cicilan</label>

        <input type="number"
               name="jumlah_cicilan"
               class="border w-full p-2">
    </div>

    <button class="bg-green-500 text-white px-4 py-2 rounded">
        Simpan
    </button>

</form>

</div>

</x-app-layout>