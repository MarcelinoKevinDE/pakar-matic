<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Gejala, Kerusakan, Rule};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Input Gejala (Lengkap)
        $gejalas = [
            ['kode_gejala' => 'G01', 'nama_gejala' => 'Tarikan berat atau ngempos'],
            ['kode_gejala' => 'G02', 'nama_gejala' => 'Bunyi kasar atau berdecit di area CVT'],
            ['kode_gejala' => 'G03', 'nama_gejala' => 'Mesin brebet atau sering mogok'],
            ['kode_gejala' => 'G04', 'nama_gejala' => 'Oli mesin cepat habis atau berasap'],
            ['kode_gejala' => 'G05', 'nama_gejala' => 'Suhu mesin overheat'],
            ['kode_gejala' => 'G06', 'nama_gejala' => 'Sistem pengereman blong/seret'],
        ];
        foreach ($gejalas as $g) Gejala::create($g);

        // 2. Input Kerusakan (Lengkap)
        $kerusakans = [
            ['kode_kerusakan' => 'K01', 'nama_kerusakan' => 'Roller CVT Aus', 'solusi' => 'Ganti roller CVT'],
            ['kode_kerusakan' => 'K02', 'nama_kerusakan' => 'V-Belt Kendur/Aus', 'solusi' => 'Ganti v-belt'],
            ['kode_kerusakan' => 'K03', 'nama_kerusakan' => 'Kampas Ganda Aus', 'solusi' => 'Ganti kampas ganda'],
            ['kode_kerusakan' => 'K04', 'nama_kerusakan' => 'Bearing Pulley Rusak', 'solusi' => 'Ganti bearing pulley'],
            ['kode_kerusakan' => 'K05', 'nama_kerusakan' => 'Busi Rusak', 'solusi' => 'Ganti busi'],
            ['kode_kerusakan' => 'K06', 'nama_kerusakan' => 'Injektor Kotor', 'solusi' => 'Bersihkan injektor'],
            ['kode_kerusakan' => 'K07', 'nama_kerusakan' => 'Ring Seher Aus', 'solusi' => 'Ganti ring seher'],
            ['kode_kerusakan' => 'K08', 'nama_kerusakan' => 'Seal Klep Bocor', 'solusi' => 'Ganti seal klep'],
            ['kode_kerusakan' => 'K09', 'nama_kerusakan' => 'Radiator Bermasalah', 'solusi' => 'Periksa coolant/radiator'],
            ['kode_kerusakan' => 'K10', 'nama_kerusakan' => 'Oli Mesin Habis', 'solusi' => 'Tambah/ganti oli'],
            ['kode_kerusakan' => 'K11', 'nama_kerusakan' => 'Kampas Rem Habis', 'solusi' => 'Ganti kampas rem'],
            ['kode_kerusakan' => 'K12', 'nama_kerusakan' => 'Minyak Rem Bocor', 'solusi' => 'Periksa master rem'],
        ];
        foreach ($kerusakans as $k) Kerusakan::create($k);

        // 3. Input Rules (Sesuai tabel pakar)
        $rules = [
            [1, 1, 0.8, 0.1], [1, 2, 0.7, 0.2], // G01 ke K01, K02
            [2, 3, 0.8, 0.1], [2, 4, 0.7, 0.2], // G02 ke K03, K04
            [3, 5, 0.9, 0.1], [3, 6, 0.8, 0.2], // G03 ke K05, K06
            [4, 7, 0.9, 0.1], [4, 8, 0.7, 0.2], // G04 ke K07, K08
            [5, 9, 0.8, 0.1], [5, 10, 0.9, 0.1], // G05 ke K09, K10
            [6, 11, 0.9, 0.1], [6, 12, 0.8, 0.2] // G06 ke K11, K12
        ];

        foreach ($rules as $r) {
            Rule::create(['gejala_id' => $r[0], 'kerusakan_id' => $r[1], 'mb' => $r[2], 'md' => $r[3]]);
        }
    }
}