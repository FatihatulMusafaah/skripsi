<x-app-layout>

    <div class="p-6">

        <h1 class="text-2xl font-bold mb-6">
            Tambah Pegawai
        </h1>

        <form action="{{ route('pegawai.store') }}" method="POST">

            @csrf
            

            <div class="mb-4">
                <label>id Pegawai</label>

                <input type="text"
                       name="id"
                       class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label>Nama Pegawai</label>

                <input type="text"
                       name="nama"
                       class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label>Jabatan</label>

                <input type="text"
                       name="jabatan"
                       class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label>Email</label>

                <input type="email"
                       name="email"
                       class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label>No HP</label>

                <input type="text"
                       name="no_hp"
                       class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label>Alamat</label>

                <textarea name="alamat"
                          class="w-full border p-2 rounded"></textarea>
            </div>

        

            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded">
                Simpan
            </button>

        </form>

    </div>

</x-app-layout>