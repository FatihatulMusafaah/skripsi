<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kasbon</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow">

        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            Tambah Kasbon Pegawai
        </h1>

        {{-- ERROR VALIDASI --}}
        @if ($errors->any())

            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">

                <ul class="list-disc pl-5">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- FORM --}}
        <form action="{{ route('kasbon.store') }}" method="POST">

            @csrf

            {{-- PEGAWAI --}}
            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Nama Pegawai
                </label>

                <select name="pegawai_id"
                        class="w-full border rounded-lg px-4 py-3">

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

            {{-- JUMLAH KASBON --}}
            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Jumlah Kasbon
                </label>

                <input type="number"
                       name="jumlah_kasbon"
                       class="w-full border rounded-lg px-4 py-3"
                       placeholder="Masukkan jumlah kasbon">

            </div>

            {{-- METODE PEMBAYARAN --}}
            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Metode Pembayaran
                </label>

                <select name="metode_pembayaran"
                        id="metode"
                        class="w-full border rounded-lg px-4 py-3">

                    <option value="">
                        -- Pilih Metode --
                    </option>

                    <option value="Sekali Bayar">
                        Sekali Bayar
                    </option>

                    <option value="Cicilan">
                        Cicilan
                    </option>

                </select>

            </div>

            {{-- JUMLAH CICILAN --}}
            <div class="mb-5" id="cicilanBox" style="display: none;">

                <label class="block mb-2 font-semibold">
                    Jumlah Cicilan
                </label>

                <input type="number"
                       name="jumlah_cicilan"
                       class="w-full border rounded-lg px-4 py-3"
                       placeholder="Masukkan jumlah cicilan">

            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                    Simpan

                </button>

                <a href="{{ route('kasbon.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                    Kembali

                </a>

            </div>

        </form>

    </div>

    {{-- SCRIPT --}}
    <script>

        const metode = document.getElementById('metode');

        const cicilanBox = document.getElementById('cicilanBox');

        metode.addEventListener('change', function () {

            if (this.value === 'Cicilan') {

                cicilanBox.style.display = 'block';

            } else {

                cicilanBox.style.display = 'none';

            }

        });

    </script>

</body>
</html>