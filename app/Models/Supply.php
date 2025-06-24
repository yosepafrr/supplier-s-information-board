<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $table = "supply";
    protected $fillable = ['tanggal', 'no_antrian', 'jam', 'nama_driver', 'nopol', 'nama_perusahaan', 'no_surat_jalan'];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}
