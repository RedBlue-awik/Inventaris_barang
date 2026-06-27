<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\barang;
use App\Models\permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermintaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'staf') {

            $permintaans = permintaan::where('permohonan_id', Auth::id())
                ->latest()
                ->get();
        } else {

            $permintaans = permintaan::with(['permohonan', 'barang', 'disetujui'])->latest()->get();
        }
        $barangs = barang::where('stok_saat_ini', '>', 0)->get();
        return view('pages.permintaan', compact('permintaans', 'barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_diminta' => 'required|integer|min:1',
            'keperluan' => 'required|string|max:255',
        ]);

        permintaan::create([
            'permohonan_id' => Auth::id(),
            'barang_id' => $request->barang_id,
            'jumlah_diminta' => $request->jumlah_diminta,
            'keperluan' => $request->keperluan,
            'status' => 'menunggu',
        ]);

        return redirect()->back()->with('success', 'Permintaan berhasil dibuat.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permintaan = permintaan::findorFail($id);
        $request->validate([
            'barang_id'      => 'required|exists:barangs,id',
            'jumlah_diminta' => 'required|integer|min:1',
            'keperluan'      => 'required|string|max:255',
            'status'         => 'required|in:menunggu,disetujui,ditolak,diserahkan',
        ]);

        // Validasi untuk jumlah_disetujui hanya jika status disetujui
        if ($request->status === 'disetujui') {
            $request->validate([
                'jumlah_disetujui' => 'required|integer|min:1|max:' . $request->jumlah_diminta,
            ]);
        }

        // Jika disetujui, catat siapa yang menyetujui
        $disetujui_oleh = in_array($request->status, ['disetujui', 'diserahkan']) ? Auth::id() : null;

        $updateData = [
            'barang_id'      => $request->barang_id,
            'jumlah_diminta' => $request->jumlah_diminta,
            'keperluan'      => $request->keperluan,
            'status'         => $request->status,
            'disetujui_oleh' => $disetujui_oleh,
        ];

        // Hanya tambahkan jumlah_disetujui jika status disetujui
        if ($request->status === 'disetujui') {
            $updateData['jumlah_disetujui'] = $request->jumlah_disetujui;
        }

        $permintaan->update($updateData);

        $statusMsg = $request->status === 'disetujui' ? 'disetujui' : 'ditolak';
        return redirect()->back()->with('success', "Permintaan berhasil $statusMsg.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(permintaan $permintaan)
    {
        permintaan::findorFail($permintaan->id)->delete();
        return redirect()->back()->with('success', 'Permintaan berhasil dihapus.');
    }
}
