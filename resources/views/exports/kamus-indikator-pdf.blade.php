<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kamus Indikator Mutu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            padding: 10px 0;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>KAMUS INDIKATOR MUTU</h1>
        <p>{{ config('app.name') }}</p>
        <p>Tanggal Export: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA INDIKATOR</th>
                <th>DIMENSI MUTU</th>
                <th>METODOLOGI PENGUMPULAN</th>
                <th>CAKUPAN DATA</th>
                <th>FREKUENSI PENGUMPULAN</th>
                <th>FREKUENSI ANALISA</th>
                <th>METODOLOGI ANALISA</th>
                <th>INTERPRETASI</th>
                <th>PUBLIKASI</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td style="text-align: center">{{ $item['no'] }}</td>
                <td>{{ $item['nama_indikator'] }}</td>
                <td>{{ $item['dimensi_mutu'] }}</td>
                <td>{{ $item['metodologi_pengumpulan'] }}</td>
                <td>{{ $item['cakupan_data'] }}</td>
                <td>{{ $item['frekuensi_pengumpulan'] }}</td>
                <td>{{ $item['frekuensi_analisa'] }}</td>
                <td>{{ $item['metodologi_analisa'] }}</td>
                <td>{{ $item['interpretasi'] }}</td>
                <td>{{ $item['publikasi'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html> 