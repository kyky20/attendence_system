<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_sessions', function (Blueprint $table) {

            $table->id();

            // dosen pembuat QR
            $table->foreignId('dosen_id')
                ->constrained('users')
                ->onDelete('cascade');

            // info perkuliahan
            $table->string('kode_matakuliah');
            $table->integer('pertemuan');

            // jadwal
            $table->date('tanggal');
            $table->time('waktu_mulai');

            // token QR
            $table->uuid('token')->unique();

            // durasi aktif QR (detik)
            $table->integer('durasi');

            // catatan tambahan
            $table->text('keterangan')->nullable();

            // expired QR
            $table->timestamp('expired_at');

            // status sesi
            $table->enum('status', [
                'aktif',
                'selesai'
            ])->default('aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_sessions');
    }
};