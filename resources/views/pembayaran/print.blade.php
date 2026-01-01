<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran - {{ $pembayaran->no_transaksi }}</title>
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
        }
        
        .receipt {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border: 2px solid #000;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
            color: #000;
            font-weight: bold;
        }
        
        .header p {
            font-size: 14px;
            color: #333;
        }
        
        .receipt-title {
            text-align: center;
            background: #000;
            color: white;
            padding: 10px;
            margin-bottom: 30px;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        
        .info-label {
            width: 200px;
            font-weight: bold;
            color: #000;
        }
        
        .info-value {
            flex: 1;
            color: #333;
        }
        
        .amount-box {
            border: 3px double #000;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }
        
        .amount-label {
            font-size: 14px;
            color: #333;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .amount-value {
            font-size: 36px;
            font-weight: bold;
            color: #000;
            margin: 10px 0;
        }
        
        .amount-text {
            margin-top: 10px;
            font-style: italic;
            color: #333;
            font-size: 14px;
        }
        
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            text-align: center;
            width: 200px;
        }
        
        .signature-line {
            border-top: 2px solid #000;
            margin-top: 80px;
            padding-top: 5px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px dashed #000;
            padding-top: 20px;
        }
        
        .footer .bold {
            font-weight: bold;
            color: #000;
            margin-top: 10px;
            display: block;
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
            font-size: 16px;
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
            
            .receipt {
                border: 2px solid #000;
                padding: 40px;
            }
            
            /* Force black and white printing */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
        
        hr {
            border: none;
            border-top: 2px solid #000;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="print-button">
        <button onclick="window.print()">🖨️ CETAK BUKTI PEMBAYARAN</button>
    </div>

    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <h1>SIKAS</h1>
            <p style="font-weight: bold;">SISTEM INFORMASI KEUANGAN SEKOLAH</p>
            <p>Jl. Pendidikan No. 123, Surabaya, Jawa Timur</p>
            <p>Telp: (031) 1234567 | Email: info@sikas-sekolah.sch.id</p>
        </div>

        <!-- Title -->
        <div class="receipt-title">
            BUKTI PEMBAYARAN
        </div>

        <!-- Info Transaksi -->
        <div class="info-section">
            <div class="info-row">
                <div class="info-label">No. Transaksi</div>
                <div class="info-value">: <strong>{{ $pembayaran->no_transaksi }}</strong></div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Tanggal Bayar</div>
                <div class="info-value">: {{ $pembayaran->tanggal->format('d F Y') }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Waktu</div>
                <div class="info-value">: {{ $pembayaran->created_at->format('H:i:s') }} WIB</div>
            </div>
        </div>

        <hr>

        <!-- Info Siswa -->
        <div class="info-section">
            <div class="info-row">
                <div class="info-label">NIS</div>
                <div class="info-value">: <strong>{{ $pembayaran->siswa->nis }}</strong></div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Nama Siswa</div>
                <div class="info-value">: <strong>{{ $pembayaran->siswa->nama }}</strong></div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Kelas</div>
                <div class="info-value">: {{ $pembayaran->siswa->kelas }}</div>
            </div>
        </div>

        <hr>

        <!-- Info Pembayaran -->
        <div class="info-section">
            <div class="info-row">
                <div class="info-label">Jenis Pembayaran</div>
                <div class="info-value">: <strong>{{ $pembayaran->jenisPembayaran->nama }}</strong></div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Metode Pembayaran</div>
                <div class="info-value">: {{ strtoupper($pembayaran->metode_pembayaran) }}</div>
            </div>
            
            @if($pembayaran->keterangan)
            <div class="info-row">
                <div class="info-label">Keterangan</div>
                <div class="info-value">: {{ $pembayaran->keterangan }}</div>
            </div>
            @endif
        </div>

        <!-- Amount Box -->
        <div class="amount-box">
            <div class="amount-label">JUMLAH YANG DIBAYARKAN</div>
            <div class="amount-value">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</div>
            <div class="amount-text"># {{ ucwords(terbilang($pembayaran->jumlah)) }} Rupiah #</div>
        </div>

        <!-- Signature -->
        <div class="signature-section">
            <div class="signature-box">
                <div style="font-weight: bold;">Yang Membayar,</div>
                <div class="signature-line">
                    ( ........................... )
                </div>
            </div>
            
            <div class="signature-box">
                <div style="font-weight: bold;">Petugas,</div>
                <div class="signature-line">
                    ( {{ auth()->user()->name }} )
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Bukti pembayaran ini sah dan diproses oleh sistem.</p>
            <p>Dicetak pada: {{ now()->format('d F Y, H:i:s') }} WIB</p>
            <span class="bold">*** TERIMA KASIH ATAS PEMBAYARAN ANDA ***</span>
        </div>
    </div>

    <script>
        // Auto print on load (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>