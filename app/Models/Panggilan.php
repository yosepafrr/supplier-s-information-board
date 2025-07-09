<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Panggilan extends Model
{
    use HasFactory;

    protected $table = 'panggilan';

    protected $fillable = [
        'barang_id',
        'dari',
        'pesan',
        'sudah_ditampilkan',
    ];}
