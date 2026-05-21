<tbody>

    @foreach($absensis as $absen)

    <tr class="text-center">

        <td class="p-3 border">
            {{ $loop->iteration }}
        </td>

         <td class="p-3 border">
            {{ $absen->pegawai->id }}
        </td>

        <td class="p-3 border">
            {{ $absen->pegawai->nama }}
        </td>

        <td class="p-3 border">
            {{ $absen->tanggal }}
        </td>

        <td class="p-3 border">
            {{ $absen->jam_masuk }}
        </td>

        <td class="p-3 border">
            {{ $absen->jam_pulang ?? '-' }}
        </td>

        <td class="p-3 border">
            {{ $absen->status }}
        </td>

        <td class="p-3 border">

            @if(!$absen->jam_pulang)

                <a href="/absensi/pulang/{{ $absen->id }}"
                   class="bg-green-500 text-white px-3 py-1 rounded">

                    Absen Pulang

                </a>

            @else

                <span class="text-green-600 font-bold">
                    Selesai
                </span>

            @endif

        </td>

    </tr>

    @endforeach

</tbody>