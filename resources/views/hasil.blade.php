<!DOCTYPE html>
<html>
<head>
    <title>Hasil Diagnosa</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #333; color: white; }
        .btn { padding: 10px 20px; background: #e74c3c; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Hasil Diagnosa</h1>
    <a href="/download-pdf" class="btn">Download PDF Report</a>
    
    <table>
        <tr><th>Gejala</th><th>Kerusakan</th><th>Persentase</th><th>Solusi</th></tr>
        @foreach($dataHasil as $namaGejala => $kerusakans)
            @foreach($kerusakans as $index => $k)
            <tr>
                @if($index == 0)
                    <td rowspan="{{ count($kerusakans) }}">{{ $namaGejala }}</td>
                @endif
                <td>{{ $k['kerusakan'] }}</td>
                <td>{{ $k['persentase'] }}%</td>
                <td>{{ $k['solusi'] }}</td>
            </tr>
            @endforeach
        @endforeach
    </table>
    <br>
    <a href="/">Diagnosa Ulang</a>
</body>
</html>