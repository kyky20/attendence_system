<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function qrSession(): BelongsTo
    {
        return $this->belongsTo(QRSession::class, 'qr_session_id');
    }
}
