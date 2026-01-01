<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background: #f5f5f5;
            font-size: 12px;
        }
        
        .report {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border: 2px solid #000;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            color: #000;
            font-weight: bold;
        }
        
        .header p {
            font-size: 11px;
            color: #333;
        }
        
        .report-title {
            text-align: center;
            background: #000;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        .period {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 13px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th {
            background: #000;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            border: 1px solid #000;
        }
        
        table td {
            padding: 8px;
            border: 1px solid #333;
            font-size: 11px;
        }
        
        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        table tbody tr:hover {
            background: #f0f0f0;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .font-bold {
            font-weight: bold;
        }
        
        .summary {
            border: 2px solid #000;
            padding: 15px;
            margin: 20px 0;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        
        .summary-row:last-child {
            border-bottom: none;
            border-top: 2px solid #000;
            padding-top: 10px;
            margin-top: 10px;
            font-weight: bold;
            font-size: 14px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px dashed #000;
            padding-top: 15px;
        }
        
        .print-button {
            text-align: center;
            margin: 20px 0;
        }
        
        .print-button button {
            background: #000;
            color: white;
            border: none;
            padding: 12px 40px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
        }
        
        .print-button button:hover {
            background: #333;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .print-button {
                display: none;
            }
            
            .report {
                border: 2px solid #000;
                padding: 30px;
            }
        }
        
        .section-title {
            background: #000;
            color: white;
            padding: 8px;
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="print-button">
        <button onclick="window.print()">🖨️ CETAK LAPORAN</button>
    </div>

    <div class="report">
        <!-- Header -->
        <div class="header">
            <h1>SIKAS</h1>
            <p style="font-weight: bold;">SISTEM INFORMASI KEUANGAN SEKOLAH</p>
            <p>Jl. Pendidikan No. 123, Surabaya, Jawa Timur | Telp: (031) 1234567</p>
        </div>

        <!-- Title -->
        <div class="report-title">
            LAPORAN KAS
        </div>

        <!-- Period -->
        <div class="period">
            Periode: {{ \Carbon\Carbon::parse($request->tanggal_mulai)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d F Y') }}
        </div>

        <!-- Pembayaran SPP Section -->
        @if($pembayarans->count() > 0)
        <div class="section-title">PEMASUKAN DARI PEMBAYARAN SPP</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 20%;">No. Transaksi</th>
                    <th style="width: 25%;">Siswa</th>
                    <th style="width: 15%;">Jenis</th>
                    <th style="width: 20%;" class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembayarans as $index => $pembayaran)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pembayaran->tanggal->format('d/m/Y') }}</td>
                    <td class="font-bold">{{ $pembayaran->no_transaksi }}</td>
                    <td>{{ $pembayaran->siswa->nama }}</td>
                    <td>{{ $pembayaran->jenisPembayaran->nama }}</td>
                    <td class="text-right font-bold">{{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr style="background: #e0e0e0; font-weight: bold;">
                    <td colspan="5" class="text-right">Subtotal Pembayaran SPP:</td>
                    <td class="text-right">{{ number_format($pembayarans->sum('jumlah'), 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        @endif

        <!-- Pemasukan Lain Section -->
        @if($pemasukans->count() > 0)
        <div class="section-title">PEMASUKAN LAIN-LAIN</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 20%;">No. Transaksi</th>
                    <th style="width: 20%;">Kategori</th>
                    <th style="width: 20%;">Keterangan</th>
                    <th style="width: 20%;" class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemasukans as $index => $pemasukan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pemasukan->tanggal->format('d/m/Y') }}</td>
                    <td class="font-bold">{{ $pemasukan->no_transaksi }}</td>
                    <td>{{ $pemasukan->kategori }}</td>
                    <td>{{ $pemasukan->keterangan }}</td>
                    <td class="text-right font-bold">{{ number_format($pemasukan->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr style="background: #e0e0e0; font-weight: bold;">
                    <td colspan="5" class="text-right">Subtotal Pemasukan Lain:</td>
                    <td class="text-right">{{ number_format($pemasukans->sum('jumlah'), 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        @endif

        <!-- Pengeluaran Section -->
        @if($pengeluarans->count() > 0)
        <div class="section-title">PENGELUARAN</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 20%;">No. Transaksi</th>
                    <th style="width: 20%;">Kategori</th>
                    <th style="width: 20%;">Keterangan</th>
                    <th style="width: 20%;" class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengeluarans as $index => $pengeluaran)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pengeluaran->tanggal->format('d/m/Y') }}</td>
                    <td class="font-bold">{{ $pengeluaran->no_transaksi }}</td>
                    <td>{{ $pengeluaran->kategori }}</td>
                    <td>{{ $pengeluaran->keterangan }}</td>
                    <td class="text-right font-bold">{{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr style="background: #e0e0e0; font-weight: bold;">
                    <td colspan="5" class="text-right">Total Pengeluaran:</td>
                    <td class="text-right">{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        @endif

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row">
                <span>Total Pemasukan:</span>
                <span class="font-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Total Pengeluaran:</span>
                <span class="font-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>SALDO AKHIR:</span>
                <span style="font-size: 16px;">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Laporan ini dicetak pada: {{ now()->format('d F Y, H:i:s') }} WIB</p>
            <p style="margin-top: 5px; font-weight: bold;">*** DOKUMEN INI DIHASILKAN OLEH SISTEM ***</p>
        </div>
    </div>
</body>
</html>