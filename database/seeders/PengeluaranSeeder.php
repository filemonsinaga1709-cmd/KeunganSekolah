<?php

namespace Database\Seeders;

use App\Models\{Pengeluaran, User, Jurnal, JurnalDetail, Akun};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengeluaranSeeder extends Seeder
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
        $akunBebanGajiGuru = Akun::where('kode_akun', '5-101')->first();
        $akunBebanGajiKaryawan = Akun::where('kode_akun', '5-102')->first();
        $akunBebanListrik = Akun::where('kode_akun', '5-201')->first();
        $akunBebanATK = Akun::where('kode_akun', '5-204')->first();
        $akunBebanLain = Akun::where('kode_akun', '5-999')->first();

        DB::beginTransaction();
        try {
            $pengeluarans = [
                // Gaji Guru
                [
                    'tanggal' => Carbon::now()->subDays(25),
                    'kategori' => 'Gaji',
                    'keterangan' => 'Gaji Guru bulan November 2024',
                    'jumlah' => 15000000,
                    'akun_debit' => $akunBebanGajiGuru,
                    'akun_kredit' => $akunBank,
                ],
                // Gaji Karyawan
                [
                    'tanggal' => Carbon::now()->subDays(25),
                    'kategori' => 'Gaji',
                    'keterangan' => 'Gaji Karyawan bulan November 2024',
                    'jumlah' => 5000000,
                    'akun_debit' => $akunBebanGajiKaryawan,
                    'akun_kredit' => $akunBank,
                ],
                // Listrik
                [
                    'tanggal' => Carbon::now()->subDays(10),
                    'kategori' => 'Utilitas',
                    'keterangan' => 'Tagihan Listrik bulan November 2024',
                    'jumlah' => 3500000,
                    'akun_debit' => $akunBebanListrik,
                    'akun_kredit' => $akunKas,
                ],
                // ATK
                [
                    'tanggal' => Carbon::now()->subDays(6),
                    'kategori' => 'Operasional',
                    'keterangan' => 'Pembelian ATK (Kertas, Pulpen, Spidol)',
                    'jumlah' => 1500000,
                    'akun_debit' => $akunBebanATK,
                    'akun_kredit' => $akunKas,
                ],
                // Konsumsi Rapat
                [
                    'tanggal' => Carbon::now()->subDays(3),
                    'kategori' => 'Operasional',
                    'keterangan' => 'Konsumsi Rapat Guru',
                    'jumlah' => 500000,
                    'akun_debit' => $akunBebanLain,
                    'akun_kredit' => $akunKas,
                ],
            ];

            foreach ($pengeluarans as $index => $data) {
                // Create Pengeluaran
                $pengeluaran = Pengeluaran::create([
                    'no_transaksi' => 'OUT-' . $data['tanggal']->format('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'tanggal' => $data['tanggal'],
                    'kategori' => $data['kategori'],
                    'keterangan' => $data['keterangan'],
                    'jumlah' => $data['jumlah'],
                    'bukti_pembayaran' => null,
                    'akun_id' => $data['akun_debit']->id,
                    'user_id' => $bendahara->id,
                ]);

                // Create Jurnal
                $jurnal = Jurnal::create([
                    'no_jurnal' => 'JU-' . $data['tanggal']->format('Ymd') . '-' . str_pad(Jurnal::whereDate('tanggal', $data['tanggal'])->count() + 1, 4, '0', STR_PAD_LEFT),
                    'tanggal' => $data['tanggal'],
                    'keterangan' => 'Pengeluaran: ' . $data['keterangan'],
                    'jenis' => 'umum',
                    'ref_tipe' => 'pengeluaran',
                    'ref_id' => $pengeluaran->id,
                    'user_id' => $bendahara->id,
                ]);

                // Jurnal Detail - Debit (Beban bertambah)
                JurnalDetail::create([
                    'jurnal_id' => $jurnal->id,
                    'akun_id' => $data['akun_debit']->id,
                    'debit' => $data['jumlah'],
                    'kredit' => 0,
                ]);

                // Jurnal Detail - Kredit (Kas/Bank berkurang)
                JurnalDetail::create([
                    'jurnal_id' => $jurnal->id,
                    'akun_id' => $data['akun_kredit']->id,
                    'debit' => 0,
                    'kredit' => $data['jumlah'],
                ]);
            }

            DB::commit();

            $this->command->info('✅ Pengeluaran & Jurnal seeded (5 pengeluaran)');
            $this->command->info('   - Gaji Guru: Rp 15.000.000 (Bank)');
            $this->command->info('   - Gaji Karyawan: Rp 5.000.000 (Bank)');
            $this->command->info('   - Listrik: Rp 3.500.000 (Kas)');
            $this->command->info('   - ATK: Rp 1.500.000 (Kas)');
            $this->command->info('   - Konsumsi Rapat: Rp 500.000 (Kas)');
            $this->command->info('');
            $this->command->info('💰 Total Pengeluaran: Rp ' . number_format(Pengeluaran::sum('jumlah'), 0, ',', '.'));
            $this->command->info('');
            
            // Hitung saldo
            $totalPembayaran = \App\Models\Pembayaran::sum('jumlah');
            $totalPemasukan = \App\Models\Pemasukan::sum('jumlah');
            $totalPengeluaran = \App\Models\Pengeluaran::sum('jumlah');
            $saldo = $totalPembayaran + $totalPemasukan - $totalPengeluaran;
            
            $this->command->info('📊 RINGKASAN KEUANGAN:');
            $this->command->info('   Pembayaran Siswa : Rp ' . number_format($totalPembayaran, 0, ',', '.'));
            $this->command->info('   Pemasukan Lain   : Rp ' . number_format($totalPemasukan, 0, ',', '.'));
            $this->command->info('   Total Pemasukan  : Rp ' . number_format($totalPembayaran + $totalPemasukan, 0, ',', '.'));
            $this->command->info('   Total Pengeluaran: Rp ' . number_format($totalPengeluaran, 0, ',', '.'));
            $this->command->info('   ─────────────────────────────────');
            $this->command->info('   SALDO AKHIR      : Rp ' . number_format($saldo, 0, ',', '.'));
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error('❌ Error: ' . $e->getMessage());
        }
    }
}