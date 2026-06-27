<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\mutasi_barang;
use App\Models\barang;

class MutasiBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang = barang::first();
        mutasi_barang::create([
            'barang_id' => $barang->id,
            'user_id' => 2,
            'referensi_id' => null,
            'tipe' => 'masuk',
            'jumlah' => 20,
            'stok_sebelum' => 0,
            'stok_sesudah' => 20,
            'keterangan' => 'Isi ulang stok',
        ]);
    }
}
