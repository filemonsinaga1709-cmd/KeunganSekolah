<?php

namespace Database\Seeders;

use App\Models\{Pembayaran, Siswa, JenisPembayaran, User, Jurnal, JurnalDetail, Akun};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get data
        $tuUser = User::where('role', 'tu')->first();
        if (!$tuUser) {
            $this->command->error('❌ User TU tidak ditemukan!');
            return;
        }

        $ahmad = Siswa::where('nis', '2024010001')->first();
        $siti = Siswa::where('nis', '2024010002')->first();
        $budi = Siswa::where('nis', '2023020001')->first();
        $dewi = Siswa::where('nis', '2023020002')->first();
        $eko = Siswa::where('nis', '2022030001')->first();

        $spp = JenisPembayaran::where('nama', 'like', '%SPP%')->first();
        $uangPangkal = JenisPembayaran::where('nama', 'like', '%Uang Pangkal%')->first();
        $uangSeragam = JenisPembayaran::where('nama', 'like', '%Uang Seragam%')->first();

        $akunKas = Akun::where('kode_akun', '1-101')->first();
        $akunBank = Akun::where('kode_akun', '1-102')->first();
        $akunPendapatanSPP = Akun::where('kode_akun', '4-101')->first();
        $akunPendapatanUangPangkal = Akun::where('kode_akun', '4-102')->first();
        $akunPendapatanUangSeragam = Akun::where('kode_akun', '4-103')->first();

        DB::beginTransaction();
        try {
            $pembayarans = [
                // Ahmad bayar SPP
                [
                    'siswa' => $ahmad,
                    'jenis' => $spp,
                    'tanggal' => Carbon::now()->subDays(10),
                    'jumlah' => 500000,
                    'metode' => 'tunai',
                    'akun_debit' => $akunKas,
                    'akun_kredit' => $akunPendapatanSPP,
                    'keterangan' => 'Pembayaran SPP bulan Desember 2024',
                ],
                // Siti bayar Uang Pangkal
                [
                    'siswa' => $siti,
                    'jenis' => $uangPangkal,
                    'tanggal' => Carbon::now()->subDays(8),
                    'jumlah' => 5000000,
                    'metode' => 'transfer',
                    'akun_debit' => $akunBank,
                    'akun_kredit' => $akunPendapatanUangPangkal,
                    'keterangan' => 'Pembayaran Uang Pangkal siswa baru',
                ],
                // Budi bayar SPP
                [
                    'siswa' => $budi,
                    'jenis' => $spp,
                    'tanggal' => Carbon::now()->subDays(5),
                    'jumlah' => 500000,
                    'metode' => 'tunai',
                    'akun_debit' => $akunKas,
                    'akun_kredit' => $akunPendapatanSPP,
                    'keterangan' => 'Pembayaran SPP bulan Desember 2024',
                ],
                // Dewi bayar Uang Seragam
                [
                    'siswa' => $dewi,
                    'jenis' => $uangSeragam,
                    'tanggal' => Carbon::now()->subDays(3),
                    'jumlah' => 750000,
                    'metode' => 'transfer',
                    'akun_debit' => $akunBank,
                    'akun_kredit' => $akunPendapatanUangSeragam,
                    'keterangan' => 'Pembayaran Uang Seragam',
                ],
                // Eko bayar SPP
                [
                    'siswa' => $eko,
                    'jenis' => $spp,
                    'tanggal' => Carbon::now()->subDays(1),
                    'jumlah' => 500000,
                    'metode' => 'tunai',
                    'akun_debit' => $akunKas,
                    'akun_kredit' => $akunPendapatanSPP,
                    'keterangan' => 'Pembayaran SPP bulan Desember 2024',
                ],
            ];

            foreach ($pembayarans as $index => $data) {
                // Create Pembayaran
                $pembayaran = Pembayaran::create([
                    'no_transaksi' => 'PAY-' . $data['tanggal']->format('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'siswa_id' => $data['siswa']->id,
                    'jenis_pembayaran_id' => $data['jenis']->id,
                    'tanggal' => $data['tanggal'],
                    'jumlah' => $data['jumlah'],
                    'metode_pembayaran' => $data['metode'],
                    'keterangan' => $data['keterangan'],
                    'user_id' => $tuUser->id,
                ]);

                // Create Jurnal
                $jurnal = Jurnal::create([
                    'no_jurnal' => 'JU-' . $data['tanggal']->format('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'tanggal' => $data['tanggal'],
                    'keterangan' => 'Pembayaran ' . $data['jenis']->nama . ' - ' . $data['siswa']->nama,
                    'jenis' => 'umum',
                    'ref_tipe' => 'pembayaran',
                    'ref_id' => $pembayaran->id,
                    'user_id' => $tuUser->id,
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

            $this->command->info('✅ Pembayaran & Jurnal seeded (5 pembayaran)');
            $this->command->info('   - Ahmad: SPP Rp 500.000 (Tunai → Kas)');
            $this->command->info('   - Siti: Uang Pangkal Rp 5.000.000 (Transfer → Bank)');
            $this->command->info('   - Budi: SPP Rp 500.000 (Tunai → Kas)');
            $this->command->info('   - Dewi: Uang Seragam Rp 750.000 (Transfer → Bank)');
            $this->command->info('   - Eko: SPP Rp 500.000 (Tunai → Kas)');
            $this->command->info('');
            $this->command->info('💰 Total Pembayaran: Rp ' . number_format(Pembayaran::sum('jumlah'), 0, ',', '.'));
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error('❌ Error: ' . $e->getMessage());
        }
    }
}