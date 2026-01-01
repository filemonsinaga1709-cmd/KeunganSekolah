<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi</title>
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
            max-width: 900px;
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
        
        .text-right {
            text-align: right;
        }
        
        .font-bold {
            font-weight: bold;
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
        
        .total-row {
            background: #e0e0e0;
            font-weight: bold;
        }
        
        .result-box {
            border: 3px double #000;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }
        
        .result-label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .result-value {
            font-size: 24px;
            font-weight: bold;
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
            LAPORAN LABA RUGI
        </div>

        <!-- Period -->
        <div class="period">
            Periode: {{ \Carbon\Carbon::parse($request->tanggal_mulai)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d F Y') }}
        </div>

        <!-- Pendapatan Section -->
        <div class="section-title">PENDAPATAN</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Kode Akun</th>
                    <th style="width: 50%;">Nama Akun</th>
                    <th style="width: 30%;" class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendapatan as $item)
                <tr>
                    <td>{{ $item['akun']->kode_akun }}</td>
                    <td>{{ $item['akun']->nama_akun }}</td>
                    <td class="text-right font-bold">{{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data pendapatan</td>
                </tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="2" class="text-right">Total Pendapatan:</td>
                    <td class="text-right">{{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Beban Section -->
        <div class="section-title">BEBAN</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Kode Akun</th>
                    <th style="width: 50%;">Nama Akun</th>
                    <th style="width: 30%;" class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($beban as $item)
                <tr>
                    <td>{{ $item['akun']->kode_akun }}</td>
                    <td>{{ $item['akun']->nama_akun }}</td>
                    <td class="text-right font-bold">{{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data beban</td>
                </tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="2" class="text-right">Total Beban:</td>
                    <td class="text-right">{{ number_format($totalBeban, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Result Box -->
        <div class="result-box">
            <div class="result-label">{{ $labaRugi >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' }}</div>
            <div class="result-value">Rp {{ number_format(abs($labaRugi), 0, ',', '.') }}</div>
            <p style="margin-top: 10px; font-size: 11px; color: #666;">
                {{ $labaRugi >= 0 ? '✓ Kondisi Keuangan Sehat' : '⚠ Perlu Evaluasi Keuangan' }}
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Laporan ini dicetak pada: {{ now()->format('d F Y, H:i:s') }} WIB</p>
            <p style="margin-top: 5px; font-weight: bold;">*** DOKUMEN INI DIHASILKAN OLEH SISTEM ***</p>
        </div>
    </div>
</body>
</html>