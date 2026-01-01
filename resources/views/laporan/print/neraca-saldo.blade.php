<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Neraca Saldo</title>
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
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .font-bold {
            font-weight: bold;
        }
        
        .group-header {
            background: #e0e0e0;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .subtotal-row {
            background: #f0f0f0;
            font-weight: bold;
        }
        
        .total-row {
            background: #d0d0d0;
            font-weight: bold;
            font-size: 13px;
        }
        
        .verification-box {
            border: 3px double #000;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }
        
        .verification-label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .summary-box {
            border: 2px solid #000;
            padding: 15px;
            margin: 20px 0;
            display: flex;
            justify-content: space-around;
        }
        
        .summary-item {
            text-align: center;
        }
        
        .summary-item .label {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .summary-item .value {
            font-size: 16px;
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
        
        .warning-box {
            border: 2px solid #000;
            padding: 15px;
            margin: 20px 0;
            background: #fff;
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
            NERACA SALDO
        </div>

        <!-- Period -->
        <div class="period">
            Per Tanggal: {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d F Y') }}
        </div>

        <!-- Summary Box -->
        @php
            $totalDebit = $akuns->sum('debit');
            $totalKredit = $akuns->sum('kredit');
            $isBalanced = $totalDebit == $totalKredit;
        @endphp

        <div class="summary-box">
            <div class="summary-item">
                <div class="label">Total Debit</div>
                <div class="value">Rp {{ number_format($totalDebit, 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Total Kredit</div>
                <div class="value">Rp {{ number_format($totalKredit, 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Status</div>
                <div class="value">{{ $isBalanced ? 'SEIMBANG ✓' : 'TIDAK SEIMBANG ⚠' }}</div>
            </div>
        </div>

        @if(!$isBalanced)
        <div class="warning-box">
            <p style="font-weight: bold; margin-bottom: 5px;">⚠ PERINGATAN:</p>
            <p>Total Debit dan Kredit tidak seimbang.</p>
            <p>Selisih: Rp {{ number_format(abs($totalDebit - $totalKredit), 0, ',', '.') }}</p>
        </div>
        @endif

        <!-- Main Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Kode Akun</th>
                    <th style="width: 40%;">Nama Akun</th>
                    <th style="width: 15%;" class="text-center">Tipe</th>
                    <th style="width: 15%;" class="text-right">Debit (Rp)</th>
                    <th style="width: 15%;" class="text-right">Kredit (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $groupedAkuns = $akuns->groupBy(function($item) {
                        return $item['akun']->tipe_akun;
                    });
                @endphp

                @foreach(['aset', 'kewajiban', 'modal', 'pendapatan', 'beban'] as $tipe)
                    @if($groupedAkuns->has($tipe))
                        <!-- Group Header -->
                        <tr class="group-header">
                            <td colspan="5">{{ strtoupper($tipe) }}</td>
                        </tr>

                        <!-- Detail Rows -->
                        @foreach($groupedAkuns[$tipe] as $item)
                        <tr>
                            <td>{{ $item['akun']->kode_akun }}</td>
                            <td>{{ $item['akun']->nama_akun }}</td>
                            <td class="text-center">{{ ucfirst($tipe) }}</td>
                            <td class="text-right font-bold">
                                @if($item['saldo'] > 0)
                                    {{ number_format($item['saldo'], 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right font-bold">
                                @if($item['saldo'] < 0)
                                    {{ number_format(abs($item['saldo']), 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        <!-- Subtotal per Type -->
                        @php
                            $subtotalDebit = $groupedAkuns[$tipe]->filter(fn($i) => $i['saldo'] > 0)->sum('saldo');
                            $subtotalKredit = abs($groupedAkuns[$tipe]->filter(fn($i) => $i['saldo'] < 0)->sum('saldo'));
                        @endphp
                        <tr class="subtotal-row">
                            <td colspan="3" class="text-right">Subtotal {{ ucfirst($tipe) }}:</td>
                            <td class="text-right">{{ number_format($subtotalDebit, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($subtotalKredit, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @endforeach

                <!-- Grand Total -->
                <tr class="total-row">
                    <td colspan="3" class="text-right">TOTAL:</td>
                    <td class="text-right">{{ number_format($totalDebit, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($totalKredit, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Verification Box -->
        <div class="verification-box">
            <div class="verification-label">VERIFIKASI NERACA SALDO</div>
            @if($isBalanced)
                <p style="font-size: 16px; margin: 10px 0;">
                    <strong>✓ NERACA DALAM KONDISI SEIMBANG</strong>
                </p>
                <p style="font-size: 12px; color: #666;">
                    Total Debit = Total Kredit<br>
                    Rp {{ number_format($totalDebit, 0, ',', '.') }}
                </p>
            @else
                <p style="font-size: 16px; margin: 10px 0;">
                    <strong>⚠ NERACA TIDAK SEIMBANG</strong>
                </p>
                <p style="font-size: 12px; color: #666;">
                    Selisih: Rp {{ number_format(abs($totalDebit - $totalKredit), 0, ',', '.') }}<br>
                    Perlu dilakukan pengecekan jurnal
                </p>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Laporan ini dicetak pada: {{ now()->format('d F Y, H:i:s') }} WIB</p>
            <p style="margin-top: 5px; font-weight: bold;">*** DOKUMEN INI DIHASILKAN OLEH SISTEM ***</p>
        </div>
    </div>
</body>
</html>