<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasiens';
    protected $fillable = [
        'nama_pasien', 'id_dokter', 'id_ruangan', 'keterangan', 'status', 'total_pembayaran'
    ];
}
