<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QRSession extends Model
{
    protected $table = 'qr_sessions';

    protected $fillable = [
        'dosen_id',
        'kode_matakuliah',
        'pertemuan',
        'tanggal',
        'waktu_mulai',
        'token',
        'durasi',
        'keterangan',
        'expired_at',
        'status'
    ];
}