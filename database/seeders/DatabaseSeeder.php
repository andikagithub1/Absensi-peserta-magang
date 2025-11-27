<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@absensi-pkl.local',
            'password' => bcrypt('Admin123456'),
            'role' => 'admin',
        ]);

        // Create Sample Pembina User
        $pembina_user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'pembina@absensi-pkl.local',
            'password' => bcrypt('Pembina123456'),
            'role' => 'pembina',
        ]);

        // Create Sample Peserta User
        $peserta_user = User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'peserta@absensi-pkl.local',
            'password' => bcrypt('Peserta123456'),
            'role' => 'peserta',
        ]);

        // Create Pembina Record
        \App\Models\Pembina::create([
            'user_id' => $pembina_user->id,
            'nip' => '19800115200803101',
            'nama_lengkap' => 'Budi Santoso',
            'jabatan' => 'Pembina Magang',
            'nomor_hp' => '08123456789',
        ]);

        // Create Peserta Record
        \App\Models\Peserta::create([
            'user_id' => $peserta_user->id,
            'pembina_id' => 1,
            'nisn' => '12345678',
            'nama_lengkap' => 'Ahmad Rizki',
            'sekolah' => 'SMK Negeri 1 Bandung',
            'jurusan' => 'Teknik Informatika',
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(30),
            'nomor_hp' => '08987654321',
            'latitude_tempat_kerja' => -7.2024967,
            'longitude_tempat_kerja' => 107.8905718,
            'radius_toleransi' => 500,
        ]);
    }
}
