<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('izins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->cascadeOnDelete();
            $table->string('kode_matakuliah');
            $table->foreign('kode_matakuliah')->references('kode_matakuliah')->on('matakuliah');
            $table->foreignId('dosen_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('jenis', ['Sakit', 'Izin Keluarga', 'Kegiatan Kampus', 'Lainnya']);
            $table->date('tanggal');
            $table->text('keterangan');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->text('catatan_dosen')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('izins');
    }
};
