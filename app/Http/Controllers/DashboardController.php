<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\barang;
use App\Models\kategori;
use App\Models\mutasi_barang;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = barang::count();
        $barangMasuk = mutasi_barang::where('tipe', 'masuk')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('jumlah');

        $barangKeluar = mutasi_barang::where('tipe', 'keluar')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('jumlah');

        $stokKritis = barang::whereColumn('stok_saat_ini', '<=', 'stok_minimum')->count();

        // DATA CHART & PERINGATAN STOK
        $chartData = barang::with('kategori')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->nama_barang,
                    'kategori' => $item->kategori ? $item->kategori->nama_kategori : 'Lainnya',
                    'jumlah' => $item->stok_saat_ini,
                    'stok_min' => $item->stok_minimum ?? 5,
                ];
            });

        // AKTIVITAS TERKINI (5 Transaksi Terakhir)
        $mutasiTerbaru = mutasi_barang::with(['barang', 'staff', 'referensi'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($mutasi) {
                $isMasuk = $mutasi->tipe === 'masuk';
                return [
                    'type' => $isMasuk ? 'in' : 'out',
                    'icon' => $isMasuk ? 'fa-arrow-down' : 'fa-arrow-up',
                    'color' => $isMasuk ? 'emerald' : 'red',
                    'title' => ($isMasuk ? 'Barang Masuk: ' : 'Barang Keluar: ') . ($mutasi->barang->nama_barang ?? 'Unknown'),
                    'meta' => 'Oleh ' . ($mutasi->staff->name ?? 'Sistem') . ' · ' . $mutasi->created_at->diffForHumans(),
                    'badge' => ($isMasuk ? '+' : '−') . $mutasi->jumlah . ' Unit',
                ];
            });

        // STATUS STOK KATEGORI (Persentase)
        $totalStokKeseluruhan = barang::sum('stok_saat_ini');
        $kategoriStok = kategori::withSum('barang', 'stok_saat_ini')
            ->get()
            ->map(function ($kat) use ($totalStokKeseluruhan) {
                $persentase = $totalStokKeseluruhan > 0 ? round(($kat->barang_sum_stok_saat_ini / $totalStokKeseluruhan) * 100) : 0;

                // Warna acak untuk setiap kategori
                $colors = ['bg-blue-500', 'bg-emerald-500', 'bg-red-500', 'bg-amber-500', 'bg-purple-500'];

                return [
                    'label' => $kat->nama_kategori,
                    'pct' => $persentase,
                    'color' => $colors[array_rand($colors)],
                ];
            })
            ->sortByDesc('pct')
            ->take(5);

        // USER LOGIN - JUMLAH MUTASI
        $user = Auth::user();
        $jumlahMutasiUser = mutasi_barang::where('user_id', $user->id)->count();
        $userInfo = [
            'nama' => $user->name,
            'departemen' => $user->departemen ?? '-',
            'mutasi' => $jumlahMutasiUser,
        ];

        return view('pages.dashboard', [
            'totalBarang' => $totalBarang,
            'barangMasuk' => $barangMasuk,
            'barangKeluar' => $barangKeluar,
            'stokKritis' => $stokKritis,
            'chartData' => $chartData,
            'activities' => $mutasiTerbaru,
            'stocks' => $kategoriStok,
            'userInfo' => $userInfo,
        ]);
    }
}
