<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuti;
use App\Models\User;

class CutiController extends Controller
{
    /**
     * Tampilkan data cuti
     */
    public function index()
    {
        $cuti = Cuti::with('user')->latest()->get();

        return view('cuti.index', compact('cuti'));
    }

    /**
     * Form create cuti
     */
    public function create()
    {
        $pegawai = User::where('role', 'karyawan')->get();

        return view('cuti.create', compact('pegawai'));
    }

    /**
     * Simpan data cuti
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'alasan' => 'required',
        ]);

        Cuti::create([
            'user_id' => $request->user_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'Pending'
        ]);

        return redirect()->route('cuti.index')
            ->with('success', 'Pengajuan cuti berhasil');
    }

    public function update(Request $request, $id)
    {
        $cuti = Cuti::findOrFail($id);

        $cuti->update([
            'status' => 'disetujui'
        ]);

        return back()->with('success', 'Cuti disetujui');
    }

    public function destroy($id)
    {
        Cuti::findOrFail($id)->delete();

        return back()->with('success', 'Data dihapus');
    }
}
