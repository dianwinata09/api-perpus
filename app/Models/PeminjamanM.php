<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanM extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $fillable = [
        'id_buku',
        'id_user',
        'tanggal_pinjaman',
        'tanggal_kembali',
        'denda'
    ];
}
