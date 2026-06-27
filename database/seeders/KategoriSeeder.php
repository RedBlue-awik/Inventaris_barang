<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_kategori' => 'Elektronik',
                'deskripsi' => 'Peralatan elektronik dan aksesoris'
            ],
        ];

        foreach ($data as $item) {
            kategori::create($item);
        }
    }
}
