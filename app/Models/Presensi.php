<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensis';

    protected $fillable = [

        'mahasiswa_id',

        'qr_session_id',

        'waktu_scan',

        'status',

        'latitude',

        'longitude',

        'distance'

    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function qrSession()
    {
        return $this->belongsTo(QRSession::class);
    }
}