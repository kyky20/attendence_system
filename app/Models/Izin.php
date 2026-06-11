<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Izin extends Model
{
    protected $table = 'izins';

    protected $fillable = [
        'mahasiswa_id',
        'kode_matakuliah',
        'dosen_id',
        'jenis',
        'tanggal',
        'keterangan',
        'lampiran',
        'status',
        'catatan_dosen',
        'reviewed_at',
    ];

    protected $casts = [
        'tanggal'     => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function matakuliah(): BelongsTo
    {
        return $this->belongsTo(Matakuliah::class, 'kode_matakuliah', 'kode_matakuliah');
    }

    public function scopeForDosen($query, int $dosenId)
    {
        return $query->whereHas('matakuliah', fn ($q) => $q->where('dosen_id', $dosenId));
    }
}
