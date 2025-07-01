<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = "barang";
    protected $fillable = ['nama_barang', 'jumlah_barang', 'keterangan', 'supply_id', 'status', 'progress_status'];
}
