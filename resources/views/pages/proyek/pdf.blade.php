<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Struk Proyek - {{ $proyek->id_proyek }}</title>

    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            width: 100%;
            margin-bottom: 30px;
        }

        .header td {
            vertical-align: top;
        }

        .header .company-logo {
            width: 100px;
            /* 
             * src="{{ public_path('images/logo.png') }}"
             */
        }

        .header .company-details {
            text-align: left;
        }

        .header .invoice-details {
            text-align: right;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #4a55c7;
        }

        .details-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .details-table th,
        .details-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
            text-align: left;
        }

        .details-table th {
            background-color: #f9f9f9;
            width: 150px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th,
        .items-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .items-table th {
            background-color: #4a55c7;
            color: #fff;
        }

        .items-table .text-right {
            text-align: right;
        }

        .total-table {
            width: 40%;
            float: right;
            border-collapse: collapse;
        }

        .total-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .total-table .total {
            font-weight: bold;
            font-size: 16px;
            color: #4a55c7;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">

        <table class="header">
            <tr>
                <td class="company-details">
                    <strong style="font-size: 16px;">PT HASTA REKSA MANUNGGAL</strong><br>
                    Tanjung RT 03 RW 23 Wukirsari, Cangkringan<br>
                    Sleman, Indonesia<br>
                    (027) 489-6466
                </td>
                <td class="invoice-details">
                    <h1>STRUK PROYEK</h1>
                    <strong>Invoice:</strong> {{ $proyek->invoice }}<br>
                    <strong>Tanggal Cetak:</strong> {{ date('d F Y') }}
                </td>
            </tr>
        </table>

        <hr>

        <!-- Detail Proyek -->
        <h3>Detail Proyek</h3>
        <table class="details-table">
            <tr>
                <th>ID Proyek</th>
                <td>{{ $proyek->id_proyek }}</td>
            </tr>
            <tr>
                <th>Customer</th>
                <td>{{ $proyek->customer->nama_perusahaan ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Penanggung Jawab</th>
                <td>{{ $proyek->customer->nama_penanggung_jawab ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Lokasi SPBU</th>
                <td>{{ $proyek->spbu->no_spbu ?? 'N/A' }} - {{ $proyek->spbu->nama_lokasi ?? '' }}</td>
            </tr>
            <tr>
                <th>Alamat SPBU</th>
                <td>{{ $proyek->spbu->alamat ?? 'N/A' }}</td>
            </tr>
        </table>

        <!-- Rincian Pekerjaan/Harga -->
        <h3>Rincian Pekerjaan</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th class="text-right">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $proyek->nama_proyek }}</strong><br>
                        <small>
                            Periode Pengerjaan:
                            {{ $proyek->tanggal_mulai->format('d/m/Y') }} s/d
                            {{ $proyek->tanggal_selesai->format('d/m/Y') }}
                        </small>
                    </td>
                    <td class="text-right">
                        Rp {{ number_format($proyek->harga_borongan, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Total -->
        <table class="total-table">
            <tr>
                <td>Subtotal</td>
                <td class="text-right">Rp {{ number_format($proyek->harga_borongan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="total">Total</td>
                <td class="text-right total">Rp {{ number_format($proyek->harga_borongan, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div style="clear: both;"></div>

        <div class="footer">
            <p>Terima kasih atas kepercayaan Anda.</p>
            <p>Struk ini dicetak otomatis oleh sistem ERP HRM.</p>
        </div>

    </div>
</body>

</html>
