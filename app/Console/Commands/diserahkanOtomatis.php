<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\permintaan;
use App\Models\barang;
use App\Models\mutasi_barang;

#[Signature('app:diserahkan-otomatis')]
#[Description('Mengubah status permintaan yang disetujui menjadi diserahkan dan membuat mutasi_barang keluar secara otomatis setiap 1 jam sekali.')]
class diserahkanOtomatis extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permintaan = permintaan::where('status', 'disetujui')->get();

        foreach ($permintaan as $permintaan) {
            $barang = barang::lockForUpdate()->find($permintaan->barang_id);
            $jumlah = $permintaan->jumlah_disetujui;

            if ($barang->stok_saat_ini < $jumlah) {
                $this->warn("Stok barang [{$barang->nama_barang}] tidak mencukupi untuk permintaan ID {$permintaan->id}. Permintaan ini tidak dapat diserahkan.");
                return;
            }

            $stok_sebelum = $barang->stok_saat_ini;
            $barang->decrement('stok_saat_ini', $jumlah);
            $permintaan->update(['status' => 'diserahkan']);

            mutasi_barang::create([
                'barang_id' => $barang->id,
                'user_id' => $permintaan->disetujui_oleh,
                'referensi_id' => $permintaan->pemohonan_id,
                'tipe' => 'keluar',
                'jumlah' => $jumlah,
                'stok_sebelum' => $stok_sebelum,
                'stok_sesudah' => $stok_sebelum - $jumlah,
                'keterangan' => $permintaan->keperluan,
            ]);
        }
        $this->info('Permintaan yang disetujui telah berhasil diubah statusnya menjadi diserahkan dan mutasi barang telah dibuat.');
    }
}
