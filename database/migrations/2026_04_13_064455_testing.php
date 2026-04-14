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
        Schema::create("testing", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas');
        });
    
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
