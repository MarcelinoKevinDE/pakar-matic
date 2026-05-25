<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; font-size: 12px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Hasil Diagnosa Sistem Pakar</h2>
    <p>Tanggal: {{ date('d-m-Y H:i:s') }}</p>
    
    <table>
        <tr><th>Gejala</th><th>Kerusakan</th><th>Persentase</th><th>Solusi</th></tr>
        @foreach($dataHasil as $namaGejala => $kerusakans)
            @foreach($kerusakans as $k)
            <tr>
                <td>{{ $namaGejala }}</td>
                <td>{{ $k['kerusakan'] }}</td>
                <td>{{ $k['persentase'] }}%</td>
                <td>{{ $k['solusi'] }}</td>
            </tr>
            @endforeach
        @endforeach
    </table>
    <p><i>Laporan ini dibuat secara otomatis oleh sistem.</i></p>
</body>
</html>