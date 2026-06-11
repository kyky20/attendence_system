<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken()->after('role');
            }
        });

        Schema::table('mahasiswas', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswas', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('mahasiswas', 'angkatan')) {
                $table->year('angkatan')->nullable()->after('jurusan');
            }

            if (!Schema::hasColumn('mahasiswas', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('email');
            }

            if (!Schema::hasColumn('mahasiswas', 'status')) {
                $table->enum('status', ['Aktif', 'Cuti', 'Non-Aktif'])
                    ->default('Aktif')
                    ->after('no_hp');
            }
        });

        // Link mahasiswa to users by matching email
        $mahasiswas = DB::table('mahasiswas')->whereNull('user_id')->get();
        foreach ($mahasiswas as $mahasiswa) {
            $user = DB::table('users')->where('email', $mahasiswa->email)->first();
            if ($user) {
                DB::table('mahasiswas')->where('id', $mahasiswa->id)->update(['user_id' => $user->id]);
            }
        }

        Schema::table('matakuliah', function (Blueprint $table) {
            if (!Schema::hasColumn('matakuliah', 'dosen_id')) {
                $table->foreignId('dosen_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('matakuliah', 'kelas')) {
                $table->string('kelas')->nullable()->after('nama_matakuliah');
            }

            if (!Schema::hasColumn('matakuliah', 'sks')) {
                $table->unsignedTinyInteger('sks')->default(3)->after('kelas');
            }

            if (!Schema::hasColumn('matakuliah', 'ruang')) {
                $table->string('ruang')->nullable()->after('jadwal');
            }

            if (!Schema::hasColumn('matakuliah', 'status')) {
                $table->enum('status', ['Aktif', 'Non-Aktif'])
                    ->default('Aktif')
                    ->after('ruang');
            }
        });

        Schema::table('qr_sessions', function (Blueprint $table) {
            if (!Schema::hasColumn('qr_sessions', 'latitude')) {
                $table->double('latitude')->nullable()->after('status');
            }

            if (!Schema::hasColumn('qr_sessions', 'longitude')) {
                $table->double('longitude')->nullable()->after('latitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('qr_sessions', function (Blueprint $table) {
            $this->dropColumnIfExists($table, 'longitude');
            $this->dropColumnIfExists($table, 'latitude');
        });

        Schema::table('matakuliah', function (Blueprint $table) {
            $this->dropColumnIfExists($table, 'status');
            $this->dropColumnIfExists($table, 'ruang');
            $this->dropColumnIfExists($table, 'sks');
            $this->dropColumnIfExists($table, 'kelas');
            $this->dropColumnIfExists($table, 'dosen_id');
        });

        Schema::table('mahasiswas', function (Blueprint $table) {
            $this->dropColumnIfExists($table, 'status');
            $this->dropColumnIfExists($table, 'no_hp');
            $this->dropColumnIfExists($table, 'angkatan');
            $this->dropColumnIfExists($table, 'user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $this->dropColumnIfExists($table, 'remember_token');
            $this->dropColumnIfExists($table, 'email_verified_at');
        });
    }

    private function dropColumnIfExists(Blueprint $table, string $column): void
    {
        if (Schema::hasColumn($table->getTable(), $column)) {
            $table->dropColumn($column);
        }
    }
};
