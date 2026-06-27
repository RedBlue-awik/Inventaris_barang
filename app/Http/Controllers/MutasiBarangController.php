<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\mutasi_barang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MutasiBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mutasiBarang = mutasi_barang::with('barang', 'staff', 'referensi')->latest()->get();
        $barangs = barang::all();
        $users = User::all();
        return view('mutasi_barang', compact('mutasiBarang', 'barangs', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id'    => 'required|exists:barangs,id',
            'tipe'         => 'required|in:masuk,keluar,opname,transfer',
            'jumlah'       => 'required|integer|min:1',
            'referensi_id' => 'nullable|exists:users,id',
            'keterangan'   => 'required|string|max:255',
        ]);

        try {
            $barang = barang::LockforUpdate()->findOrFail($request->barang_id);
            $stok_sebelum = $barang->stok_saat_ini;
            $tipe = $request->tipe;
            $jumlah = $request->jumlah;

            // Validasi stok cukup untuk tipe keluar
            if (in_array($tipe, ['keluar']) && $jumlah > $stok_sebelum) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Stok tidak cukup! Stok: $stok_sebelum, diminta: $jumlah");
            }

            // Hitung stok sesudah & update barang berdasarkan tipe
            switch($tipe) {
                case 'masuk':
                    $stok_sesudah = $stok_sebelum + $jumlah;
                    $barang->increment('stok_saat_ini', $jumlah);
                    break;
                case 'keluar':
                    $stok_sesudah = $stok_sebelum - $jumlah;
                    $barang->decrement('stok_saat_ini', $jumlah);
                    break;
                default:
                    $stok_sesudah = $stok_sebelum;
            }

            // Simpan mutasi dengan stok before & after
            mutasi_barang::create([
                'barang_id'    => $request->barang_id,
                'user_id'      => Auth::id(),
                'referensi_id' => $request->referensi_id,
                'tipe'         => $tipe,
                'jumlah'       => $jumlah,
                'stok_sebelum' => $stok_sebelum,
                'stok_sesudah' => $stok_sesudah,
                'keterangan'   => $request->keterangan,
            ]);

            $barang->update(['stok_saat_ini' => $stok_sesudah]);

            return redirect()->back()->with('success', "Mutasi [$tipe] berhasil: Stok $stok_sebelum → $stok_sesudah");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $mutasi = mutasi_barang::findOrFail($id);
            $barang = barang::LockforUpdate()->findOrFail($mutasi->barang_id);
            $stok_baru = $barang->stok_saat_ini;

            if ($mutasi->tipe === 'masuk') {
                $stok_baru -= $mutasi->jumlah;
            } elseif ($mutasi->tipe === 'keluar') {
                $stok_baru += $mutasi->jumlah;
            }

            $barang->update(['stok_saat_ini' => $stok_baru]);

            $mutasi->delete();

            return redirect()->back()->with('success', "Mutasi berhasil dihapus. Stok barang sekarang: $stok_baru");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
