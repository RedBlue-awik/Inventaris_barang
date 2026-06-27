<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\permintaan;
use App\Models\barang;

class PermintaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nomor = 1;
        $barang = barang::first();
        $data = [
            [
                'permohonan_id' => 2,
                'barang_id' => $barang->id,
                'no_permintaan' => 'REQ' . now()->format('Ymd') . str_pad($nomor++, 3, '0', STR_PAD_LEFT),
                'jumlah_diminta' => rand(1, 3),
                'jumlah_disetujui' => null,
                'disetujui_oleh' => null,
                'keperluan' => 'Kebutuhan Lab komputer',
                'status' => 'menunggu',
            ],
        ];

        foreach ($data as $item) {
            permintaan::create($item);
        }
    }
}
