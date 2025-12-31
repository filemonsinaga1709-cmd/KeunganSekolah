<?php

namespace Database\Seeders;

use App\Models\JenisPembayaran;
use Illuminate\Database\Seeder;

class JenisPembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisPembayaran = [
            ['nama' => 'SPP (Sumbangan Pembinaan Pendidikan)', 'nominal' => 500000],
            ['nama' => 'Uang Pangkal', 'nominal' => 5000000],
            ['nama' => 'Uang Seragam', 'nominal' => 750000],
            ['nama' => 'Uang Buku', 'nominal' => 1000000],
            ['nama' => 'Uang Kegiatan', 'nominal' => 300000],
        ];

        foreach ($jenisPembayaran as $jenis) {
            JenisPembayaran::create($jenis);
        }

        $this->command->info('✅ Jenis Pembayaran seeded (5 jenis)');
        $this->command->info('   - SPP: Rp 500.000');
        $this->command->info('   - Uang Pangkal: Rp 5.000.000');
        $this->command->info('   - Uang Seragam: Rp 750.000');
    }
}