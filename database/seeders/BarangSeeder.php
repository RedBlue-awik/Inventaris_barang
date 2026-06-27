<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nomor = 1;
        $data = [
            [
                'kategori_id' => 1,
                'supplier_id' => 1,
                'kode_barang' => 'BRG' . now()->format('Ymd') . str_pad($nomor++, 3, '0', STR_PAD_LEFT),
                'nama_barang' => 'Laptop Asus ROG',
                'satuan' => 'Unit',
                'stok_saat_ini' => 10,
                'stok_minimum' => 2,
                'lokasi_rak' => 'Rak A1',
                'kondisi' => 'baik',
            ],
        ];
        foreach ($data as $item) {
            barang::create($item);
        }
    }
}
