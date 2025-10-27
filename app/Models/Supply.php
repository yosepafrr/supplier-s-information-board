<?php

namespace App\Models;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $table = "supply";
    protected $fillable = ['tanggal', 'no_antrian', 'jam', 'nama_driver', 'nopol', 'nama_perusahaan', 'no_surat_jalan'];

    public function barang()
    {
        return $this->hasMany(Barang::class)->orderBy('id');
    }
}
