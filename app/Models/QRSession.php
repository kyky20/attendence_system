<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QRSession extends Model
{
    protected $table = 'qr_sessions';

    protected $fillable = [
        'dosen_id',
        'matakuliah_id',
        'kode_matakuliah',
        'pertemuan',
        'tanggal',
        'waktu_mulai',
        'token',
        'durasi',
        'keterangan',
        'expired_at',
        'status',
        'latitude',
        'longitude',
    ];

    public function matakuliah(): BelongsTo
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }

    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class, 'qr_session_id');
    }
}
