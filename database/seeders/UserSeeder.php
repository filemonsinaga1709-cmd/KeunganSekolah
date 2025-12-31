<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Bu Siti (Tata Usaha)',
                'email' => 'tu@sekolah.com',
                'password' => Hash::make('tu123'),
                'role' => 'tu',
            ],
            [
                'name' => 'Pak Budi (Bendahara)',
                'email' => 'bendahara@sekolah.com',
                'password' => Hash::make('bendahara123'),
                'role' => 'bendahara',
            ],
            [
                'name' => 'Dr. Ahmad (Kepala Sekolah)',
                'email' => 'kepsek@sekolah.com',
                'password' => Hash::make('kepsek123'),
                'role' => 'kepala_sekolah',
            ],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'role' => $userData['role'],
                'email_verified_at' => now(),
            ]);
        }

        $this->command->info('✅ Users seeded (4 users)');
        $this->command->table(
            ['Role', 'Nama', 'Email', 'Password'],
            [
                ['Admin', 'Administrator', 'admin@sekolah.com', 'admin123'],
                ['TU', 'Bu Siti (Tata Usaha)', 'tu@sekolah.com', 'tu123'],
                ['Bendahara', 'Pak Budi (Bendahara)', 'bendahara@sekolah.com', 'bendahara123'],
                ['Kepsek', 'Dr. Ahmad (Kepala Sekolah)', 'kepsek@sekolah.com', 'kepsek123'],
            ]
        );
    }
}