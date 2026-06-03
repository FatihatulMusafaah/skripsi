<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pegawai</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow">

        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            Tambah Data Pegawai
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
        <form action="{{ route('pegawai.store') }}" method="POST">

            @csrf

 {{-- NAMA --}}
            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Pegawai_id
                </label>

                <input type="text"
                       name="id"
                       class="w-full border rounded-lg px-4 py-3"
                       placeholder="Masukkan id pegawai"
                       value="{{ old('id') }}">

            </div>

            {{-- NAMA --}}
            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Nama Pegawai
                </label>

                <input type="text"
                       name="nama"
                       class="w-full border rounded-lg px-4 py-3"
                       placeholder="Masukkan nama pegawai"
                       value="{{ old('nama') }}">

            </div>

            {{-- EMAIL --}}
            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="w-full border rounded-lg px-4 py-3"
                       placeholder="Masukkan email"
                       value="{{ old('email') }}">

            </div>

            {{-- JABATAN --}}
            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Jabatan
                </label>

                <input type="text"
                       name="jabatan"
                       class="w-full border rounded-lg px-4 py-3"
                       placeholder="Masukkan jabatan"
                       value="{{ old('jabatan') }}">

            </div>

            {{-- NO HP --}}
            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Nomor HP
                </label>

                <input type="text"
                       name="no_hp"
                       class="w-full border rounded-lg px-4 py-3"
                       placeholder="Masukkan nomor HP"
                       value="{{ old('no_hp') }}">

            </div>

            {{-- ALAMAT --}}
            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Alamat
                </label>

                <textarea name="alamat"
                          rows="4"
                          class="w-full border rounded-lg px-4 py-3"
                          placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>

            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                    Simpan

                </button>

                <a href="{{ route('pegawai.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</body>
</html>