<!DOCTYPE html>
<html>
<head>
    <title>Sistem Pakar Motor Matic</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .form-check { padding: 10px; border-bottom: 1px solid #eee; }
        button { margin-top: 15px; padding: 10px 20px; background-color: #2c3e50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Diagnosa Kerusakan Motor Matic</h1>
    
    <form action="/hitung" method="POST">
        @csrf
        @foreach($gejalas as $gejala)
            <div class="form-check">
                <input type="checkbox" name="gejala[]" value="{{ $gejala->id }}">
                <label>{{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}</label>
                
                <select name="cf_user[{{ $gejala->id }}]">
                    <option value="1.0">Sangat Yakin</option>
                    <option value="0.8">Yakin</option>
                    <option value="0.6">Cukup Yakin</option>
                    <option value="0.4">Sedikit Yakin</option>
                </select>
            </div>
        @endforeach
        <button type="submit">Diagnosa Sekarang</button>
    </form>
</body>
</html>