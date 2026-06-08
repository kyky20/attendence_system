<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $dosen = User::updateOrCreate(
            ['email' => 'dosen@example.com'],
            [
                'name' => 'Dosen',
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ]
        );

        $mahasiswaUser = User::updateOrCreate(
            ['email' => 'mahasiswa@example.com'],
            [
                'name' => 'Mahasiswa',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ]
        );

        Mahasiswa::updateOrCreate(
            ['nim' => 'M001'],
            [
                'user_id' => $mahasiswaUser->id,
                'nama' => $mahasiswaUser->name,
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2024,
                'email' => $mahasiswaUser->email,
                'no_hp' => '081234567890',
                'status' => 'Aktif',
            ]
        );

        $matakuliahs = [
            ['kode_matakuliah' => 'MK001', 'nama_matakuliah' => 'Algoritma dan Pemrograman', 'kelas' => 'TI-A', 'sks' => 3, 'jadwal' => '07:30', 'ruang' => 'Lab K.301'],
            ['kode_matakuliah' => 'MK002', 'nama_matakuliah' => 'Basis Data', 'kelas' => 'TI-B', 'sks' => 3, 'jadwal' => '09:30', 'ruang' => 'R. B.202'],
            ['kode_matakuliah' => 'MK003', 'nama_matakuliah' => 'Rekayasa Perangkat Lunak', 'kelas' => 'TI-A', 'sks' => 3, 'jadwal' => '13:00', 'ruang' => 'R. C.101'],
        ];

        foreach ($matakuliahs as $matakuliah) {
            Matakuliah::updateOrCreate(
                ['kode_matakuliah' => $matakuliah['kode_matakuliah']],
                $matakuliah + [
                    'dosen_id' => $dosen->id,
                    'nilai' => 0,
                    'status' => 'Aktif',
                ]
            );
        }
    }
}
