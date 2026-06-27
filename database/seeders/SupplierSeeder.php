<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_supplier' => 'Yazid',
                'telepon' => '081234567890',
                'email' => 'supplier@example.com',
                'alamat' => 'Banyurip',
            ],
        ];

        foreach ($data as $item) {
            supplier::create($item);
        }
    }
}
