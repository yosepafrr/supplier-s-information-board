<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $table = "supply";
    protected $fillable = ['tanggal', 'nama_driver', 'nopol', 'nama_perusahaan', 'no_surat_jalan'];
}
