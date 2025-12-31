<?php

namespace Database\Seeders;

use App\Models\Akun;
use Illuminate\Database\Seeder;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $akuns = [
            // ASET
            ['kode_akun' => '1-101', 'nama_akun' => 'Kas', 'tipe_akun' => 'aset'],
            ['kode_akun' => '1-102', 'nama_akun' => 'Bank BRI', 'tipe_akun' => 'aset'],
            
            // KEWAJIBAN
            ['kode_akun' => '2-101', 'nama_akun' => 'Utang Gaji', 'tipe_akun' => 'kewajiban'],
            
            // MODAL
            ['kode_akun' => '3-101', 'nama_akun' => 'Modal Yayasan', 'tipe_akun' => 'modal'],
            
            // PENDAPATAN
            ['kode_akun' => '4-101', 'nama_akun' => 'Pendapatan SPP', 'tipe_akun' => 'pendapatan'],
            ['kode_akun' => '4-102', 'nama_akun' => 'Pendapatan Uang Pangkal', 'tipe_akun' => 'pendapatan'],
            ['kode_akun' => '4-103', 'nama_akun' => 'Pendapatan Uang Seragam', 'tipe_akun' => 'pendapatan'],
            ['kode_akun' => '4-201', 'nama_akun' => 'Pendapatan Donasi', 'tipe_akun' => 'pendapatan'],
            ['kode_akun' => '4-999', 'nama_akun' => 'Pendapatan Lain-lain', 'tipe_akun' => 'pendapatan'],
            
            // BEBAN
            ['kode_akun' => '5-101', 'nama_akun' => 'Beban Gaji Guru', 'tipe_akun' => 'beban'],
            ['kode_akun' => '5-102', 'nama_akun' => 'Beban Gaji Karyawan', 'tipe_akun' => 'beban'],
            ['kode_akun' => '5-201', 'nama_akun' => 'Beban Listrik', 'tipe_akun' => 'beban'],
            ['kode_akun' => '5-204', 'nama_akun' => 'Beban ATK', 'tipe_akun' => 'beban'],
            ['kode_akun' => '5-999', 'nama_akun' => 'Beban Lain-lain', 'tipe_akun' => 'beban'],
        ];

        foreach ($akuns as $akun) {
            Akun::create([
                'kode_akun' => $akun['kode_akun'],
                'nama_akun' => $akun['nama_akun'],
                'tipe_akun' => $akun['tipe_akun'],
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ Chart of Accounts seeded (15 akun)');
        $this->command->info('   - Aset: 2 akun (Kas, Bank)');
        $this->command->info('   - Pendapatan: 5 akun (SPP, Uang Pangkal, dll)');
        $this->command->info('   - Beban: 5 akun (Gaji, Listrik, ATK, dll)');
    }
}