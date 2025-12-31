<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = [
            [
                'nis' => '2024010001',
                'nama' => 'Ahmad Rizki Pratama',
                'kelas' => 'X-1',
                'no_telp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 10, Surabaya',
                'is_active' => true,
            ],
            [
                'nis' => '2024010002',
                'nama' => 'Siti Nurhaliza',
                'kelas' => 'X-1',
                'no_telp' => '082345678901',
                'alamat' => 'Jl. Pahlawan No. 25, Surabaya',
                'is_active' => true,
            ],
            [
                'nis' => '2023020001',
                'nama' => 'Budi Santoso',
                'kelas' => 'XI IPA 1',
                'no_telp' => '083456789012',
                'alamat' => 'Jl. Pemuda No. 15, Surabaya',
                'is_active' => true,
            ],
            [
                'nis' => '2023020002',
                'nama' => 'Dewi Kusuma Wardani',
                'kelas' => 'XI IPA 1',
                'no_telp' => '084567890123',
                'alamat' => 'Jl. Diponegoro No. 30, Surabaya',
                'is_active' => true,
            ],
            [
                'nis' => '2022030001',
                'nama' => 'Eko Prasetyo Wibowo',
                'kelas' => 'XII IPA 1',
                'no_telp' => '085678901234',
                'alamat' => 'Jl. Sudirman No. 45, Surabaya',
                'is_active' => true,
            ],
        ];

        foreach ($siswas as $siswa) {
            Siswa::create($siswa);
        }

        $this->command->info('✅ Siswa seeded (5 siswa)');
        $this->command->info('   - Ahmad Rizki Pratama (X-1)');
        $this->command->info('   - Siti Nurhaliza (X-1)');
        $this->command->info('   - Budi Santoso (XI IPA 1)');
        $this->command->info('   - Dewi Kusuma Wardani (XI IPA 1)');
        $this->command->info('   - Eko Prasetyo Wibowo (XII IPA 1)');
    }
}