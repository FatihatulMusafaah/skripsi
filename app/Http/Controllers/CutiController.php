<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuti;

class CutiController extends Controller
{
    public function index()
    {
        $cuti = Cuti::latest()->get();
        return view('cuti.index', compact('cuti'));
    }

    public function create()
    {
        return view('cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'pegawai_id' => 'required',
            'nama_pegawai' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'alasan' => 'required',
        ]);

        Cuti::create($request->except('_token'));

        return redirect()->route('cuti.index')
            ->with('success', 'Pengajuan cuti berhasil');
    }

    public function update($id)
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