<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("matakuliah", function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string("kode_matakuliah")->unique();
            $table->string("nama_matakuliah");
            $table->string("kelas")->nullable();
            $table->unsignedTinyInteger("sks")->default(3);
            $table->integer("nilai")->default(0);
            $table->time("jadwal")->nullable();
            $table->string("ruang")->nullable();
            $table->enum("status", ["Aktif", "Non-Aktif"])->default("Aktif");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("matakuliah");
    }
};
