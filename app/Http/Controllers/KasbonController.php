<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KasbonController extends Controller
{
    public function index()
    {
        $kasbon = Kasbon::with('user')->latest()->get();
        return view('kasbon.index', compact('kasbon'));
    }

    public function create()
    {
        $pegawai = User::where('role', 'karyawan')->get();
        return view('kasbon.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:user,id',
            'jumlah_kasbon' => 'required|numeric|min:1000',
            'metode_pembayaran' => 'required|in:bayar_sekali,cicilan',
            'persentase_potongan' => 'required_if:metode_pembayaran,cicilan|nullable|integer|min:30|max:100',
            'potongan_per_bulan' => 'required|numeric',
            'lama_cicilan' => 'required|integer|min:1',
        ]);

        $user = User::findOrFail($request->pegawai_id);

        Kasbon::create([
            'pegawai_id' => $request->pegawai_id,
            'jumlah_kasbon' => $request->jumlah_kasbon,
            'metode_pembayaran' => $request->metode_pembayaran,
            'persentase_potongan' => $request->metode_pembayaran == 'cicilan' ? $request->persentase_potongan : null,
            'potongan_per_bulan' => $request->potongan_per_bulan,
            'lama_cicilan' => $request->lama_cicilan,
            'sisa_kasbon' => $request->jumlah_kasbon,
            'status' => 'aktif',
        ]);

        return redirect()->route('kasbon.index')->with('success', 'Data Kasbon berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        Kasbon::findOrFail($id)->delete();
        return back()->with('success', 'Data Kasbon dihapus.');
    }
}
