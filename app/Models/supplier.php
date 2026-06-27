<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table('suppliers')]
#[Fillable(['id', 'nama_supplier', 'telepon', 'email', 'alamat'])]
class supplier extends Model
{
    public function barang()
    {
        return $this->hasMany(barang::class);
    }
}
