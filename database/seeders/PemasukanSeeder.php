<?php

namespace Database\Seeders;

use App\Models\{Pemasukan, User, Jurnal, JurnalDetail, Akun};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemasukanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bendahara = User::where('role', 'bendahara')->first();
        if (!$bendahara) {
            $this->command->error('❌ User Bendahara tidak ditemukan!');
            return;
        }

        $akunKas = Akun::where('kode_akun', '1-101')->first();
        $akunBank = Akun::where('kode_akun', '1-102')->first();
        $akunPendapatanDonasi = Akun::where('kode_akun', '4-201')->first();
        $akunPendapatanLain = Akun::where('kode_akun', '4-999')->first();

        DB::beginTransaction();
        try {
            $pemasukans = [
                // Donasi Alumni
                [
                    'tanggal' => Carbon::now()->subDays(15),
                    'kategori' => 'Donasi',
                    'keterangan' => 'Donasi dari Alumni Angkatan 2015',
                    'jumlah' => 10000000,
                    'akun_debit' => $akunBank,
                    'akun_kredit' => $akunPendapatanDonasi,
                ],
                // Donasi Komite
                [
                    'tanggal' => Carbon::now()->subDays(12),
                    'kategori' => 'Donasi',
                    'keterangan' => 'Sumbangan Komite Sekolah',
                    'jumlah' => 5000000,
                    'akun_debit' => $akunKas,
                    'akun_kredit' => $akunPendapatanDonasi,
                ],
                // Sewa Aula
                [
                    'tanggal' => Carbon::now()->subDays(7),
                    'kategori' => 'Lain-lain',
                    'keterangan' => 'Sewa Aula untuk Acara Pernikahan',
                    'jumlah' => 2500000,
                    'akun_debit' => $akunKas,
                    'akun_kredit' => $akunPendapatanLain,
                ],
                // Penjualan Buku Bekas
                [
                    'tanggal' => Carbon::now()->subDays(4),
                    'kategori' => 'Lain-lain',
                    'keterangan' => 'Penjualan Buku Bekas Perpustakaan',
                    'jumlah' => 500000,
                    'akun_debit' => $akunKas,
                    'akun_kredit' => $akunPendapatanLain,
                ],
                // Denda Keterlambatan
                [
                    'tanggal' => Carbon::now()->subDays(2),
                    'kategori' => 'Lain-lain',
                    'keterangan' => 'Denda Keterlambatan Pembayaran',
                    'jumlah' => 200000,
                    'akun_debit' => $akunKas,
                    'akun_kredit' => $akunPendapatanLain,
                ],
            ];

            foreach ($pemasukans as $index => $data) {
                // Create Pemasukan
                $pemasukan = Pemasukan::create([
                    'no_transaksi' => 'IN-' . $data['tanggal']->format('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'tanggal' => $data['tanggal'],
                    'kategori' => $data['kategori'],
                    'keterangan' => $data['keterangan'],
                    'jumlah' => $data['jumlah'],
                    'akun_id' => $data['akun_kredit']->id,
                    'user_id' => $bendahara->id,
                ]);

                // Create Jurnal
                $jurnal = Jurnal::create([
                    'no_jurnal' => 'JU-' . $data['tanggal']->format('Ymd') . '-' . str_pad(Jurnal::whereDate('tanggal', $data['tanggal'])->count() + 1, 4, '0', STR_PAD_LEFT),
                    'tanggal' => $data['tanggal'],
                    'keterangan' => 'Pemasukan: ' . $data['keterangan'],
                    'jenis' => 'umum',
                    'ref_tipe' => 'pemasukan',
                    'ref_id' => $pemasukan->id,
                    'user_id' => $bendahara->id,
                ]);

                // Jurnal Detail - Debit (Kas/Bank bertambah)
                JurnalDetail::create([
                    'jurnal_id' => $jurnal->id,
                    'akun_id' => $data['akun_debit']->id,
                    'debit' => $data['jumlah'],
                    'kredit' => 0,
                ]);

                // Jurnal Detail - Kredit (Pendapatan bertambah)
                JurnalDetail::create([
                    'jurnal_id' => $jurnal->id,
                    'akun_id' => $data['akun_kredit']->id,
                    'debit' => 0,
                    'kredit' => $data['jumlah'],
                ]);
            }

            DB::commit();

            $this->command->info('✅ Pemasukan & Jurnal seeded (5 pemasukan)');
            $this->command->info('   - Donasi Alumni: Rp 10.000.000 (Bank)');
            $this->command->info('   - Donasi Komite: Rp 5.000.000 (Kas)');
            $this->command->info('   - Sewa Aula: Rp 2.500.000 (Kas)');
            $this->command->info('   - Penjualan Buku: Rp 500.000 (Kas)');
            $this->command->info('   - Denda: Rp 200.000 (Kas)');
            $this->command->info('');
            $this->command->info('💰 Total Pemasukan: Rp ' . number_format(Pemasukan::sum('jumlah'), 0, ',', '.'));
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error('❌ Error: ' . $e->getMessage());
        }
    }
}