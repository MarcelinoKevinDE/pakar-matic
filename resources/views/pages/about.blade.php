@extends('layouts.app')

@section('title', 'Tentang Sistem — PakarMatik')

@section('content')

<!-- HERO -->
<div class="nb-hero">
    <div class="nb-container">
        <h1 class="nb-hero-title">TENTANG <span>PAKARMATIK</span></h1>
        <p class="nb-hero-sub">
            SISTEM PAKAR DIAGNOSIS KERUSAKAN MESIN MOTOR BERBASIS CERTAINTY FACTOR
        </p>
    </div>
</div>

<div class="nb-container py-5">

    <!-- INTRO BLOCK -->
    <div style="display:grid; grid-template-columns: 3fr 2fr; gap:1.5rem; margin-bottom:3rem;">

        <div>
            <div class="nb-section-header">APA ITU PAKARMATIK?</div>
            <div class="nb-card" style="border-top:none; line-height:1.8; font-size:0.85rem;">
                <p>
                    <strong>PakarMatik</strong> adalah sistem pakar berbasis web yang dirancang untuk
                    membantu pemilik kendaraan bermotor dan teknisi dalam mengidentifikasi
                    kerusakan mesin secara cepat dan terstruktur.
                </p>
                <p style="margin-top:1rem;">
                    Sistem ini mereplikasi penalaran diagnostik seorang mekanik berpengalaman
                    melalui mekanisme inferensi <strong>Certainty Factor (CF)</strong>, sebuah
                    pendekatan matematis yang memodelkan tingkat kepercayaan terhadap suatu
                    hipotesis berdasarkan bukti (gejala) yang ada.
                </p>
                <p style="margin-top:1rem;">
                    Dengan memilih gejala yang diamati pada kendaraan, sistem akan
                    menelusuri basis aturan dan mengeluarkan daftar kandidat kerusakan
                    yang diurutkan berdasarkan nilai kepercayaan tertinggi.
                </p>
            </div>
        </div>

        <div>
            <div class="nb-section-header">FITUR UTAMA</div>
            <div style="border: var(--border); border-top: none;">
                @php
                    $features = [
                        'DIAGNOSIS BERBASIS CF' => 'Metode ilmiah yang telah teruji.',
                        'PERHITUNGAN TRANSPARAN' => 'Setiap langkah kalkulasi ditampilkan.',
                        'RIWAYAT TERSIMPAN' => 'Setiap sesi dicatat dalam database.',
                        'DASHBOARD ADMIN' => 'Visualisasi data dan statistik penggunaan.',
                        'VALIDASI KETAT' => 'Input divalidasi di sisi server dan klien.',
                        'RESPONSIF' => 'Dapat diakses dari perangkat apa pun.',
                    ];
                @endphp
                @foreach ($features as $title => $desc)
                    <div style="padding:0.75rem 1rem; border-bottom:2px solid #e8e8e0;
                                background: var(--white); font-size:0.78rem;">
                        <div style="font-weight:700; font-size:0.72rem; letter-spacing:0.08em;
                                    text-transform:uppercase;">
                            {{ $title }}
                        </div>
                        <div style="color:#666; margin-top:0.2rem;">{{ $desc }}</div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- HOW IT WORKS -->
    <div class="mb-5">
        <div class="nb-section-header">CARA KERJA SISTEM</div>
        <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:0; border: var(--border); border-top:none;">
            @php
                $steps = [
                    ['no'=>'01','title'=>'PILIH GEJALA','desc'=>'Pengguna memilih semua gejala yang saat ini diamati pada kendaraan dari daftar yang tersedia.'],
                    ['no'=>'02','title'=>'PENCOCOKAN ATURAN','desc'=>'Sistem mencocokkan gejala yang dipilih dengan basis aturan IF-THEN yang didefinisikan oleh pakar.'],
                    ['no'=>'03','title'=>'KALKULASI CF','desc'=>'Nilai CF setiap aturan (MB - MD) digabungkan secara iteratif menggunakan rumus CF kombinasi.'],
                    ['no'=>'04','title'=>'HASIL DIRANKING','desc'=>'Kandidat kerusakan diurutkan dari CF tertinggi ke terendah. Kandidat teratas adalah diagnosis utama.'],
                ];
            @endphp
            @foreach ($steps as $i => $step)
                <div style="padding:1.5rem 1.25rem;
                            background: {{ $i % 2 === 0 ? 'var(--black)' : 'var(--white)' }};
                            color: {{ $i % 2 === 0 ? 'var(--white)' : 'var(--black)' }};
                            border-left: {{ $i > 0 ? '2px solid var(--black)' : 'none' }};">
                    <div style="font-family:'Bebas Neue',sans-serif; font-size:3rem;
                                color: var(--yellow); line-height:1; margin-bottom:0.5rem;">
                        {{ $step['no'] }}
                    </div>
                    <div style="font-family:'Bebas Neue',sans-serif; font-size:1.1rem;
                                letter-spacing:0.06em; margin-bottom:0.5rem;">
                        {{ $step['title'] }}
                    </div>
                    <div style="font-size:0.76rem; line-height:1.7;
                                opacity: {{ $i % 2 === 0 ? '0.75' : '0.7' }};">
                        {{ $step['desc'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- CF FORMULA -->
    <div class="mb-5">
        <div class="nb-section-header">METODE CERTAINTY FACTOR</div>
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:0; border:var(--border); border-top:none;">

            <div style="padding:1.5rem; border-right: 2px solid var(--black);">
                <div style="font-family:'Bebas Neue',sans-serif; font-size:1.2rem; margin-bottom:0.75rem;">
                    DEFINISI
                </div>
                <p style="font-size:0.8rem; line-height:1.8; color:#333;">
                    Certainty Factor (CF) diperkenalkan oleh Shortliffe dan Buchanan pada tahun 1975
                    dalam sistem pakar medis MYCIN. CF mengkuantifikasi keyakinan seorang pakar
                    terhadap suatu aturan atau hipotesis.
                </p>
                <p style="font-size:0.8rem; line-height:1.8; color:#333; margin-top:0.75rem;">
                    Setiap aturan dalam sistem ini memiliki nilai
                    <strong>MB (Measure of Belief)</strong> dan
                    <strong>MD (Measure of Disbelief)</strong> yang ditentukan oleh pakar domain.
                </p>
            </div>

            <div style="padding:1.5rem; background: #fafaf0;">
                <div style="font-family:'Bebas Neue',sans-serif; font-size:1.2rem; margin-bottom:0.75rem;">
                    RUMUS
                </div>
                <div style="background: var(--black); color: var(--yellow); padding:1rem;
                            text-align:center; font-size:0.85rem;
                            font-family:'IBM Plex Mono',monospace; margin-bottom:0.75rem;
                            line-height:2;">
                    CF(rule) = MB - MD<br>
                    CF(A, B) = CF(A) + CF(B) x (1 - CF(A))
                </div>
                <div style="font-size:0.72rem; color:#555; line-height:1.7;">
                    Nilai CF akhir dipastikan berada dalam rentang [0, 1].
                    Semakin mendekati 1.0, semakin tinggi keyakinan sistem terhadap
                    kerusakan tersebut.
                </div>
            </div>

        </div>
    </div>

    <!-- PAKAR -->
    <div class="mb-5">
        <div class="nb-section-header">PAKAR DAN BASIS PENGETAHUAN</div>
        <div style="display:grid; grid-template-columns: auto 1fr; gap:0;
                    border: var(--border); border-top:none;">

            <div style="padding:1.5rem; background: var(--yellow);
                        border-right: 2px solid var(--black);
                        display:flex; flex-direction:column; align-items:center;
                        justify-content:center; min-width:180px; text-align:center;">
                <div style="width:80px; height:80px; border:3px solid var(--black);
                             background: var(--black); display:flex; align-items:center;
                             justify-content:center; margin-bottom:0.75rem;">
                    <span style="font-family:'Bebas Neue',sans-serif; font-size:2rem;
                                 color: var(--yellow);">AH</span>
                </div>
                <div style="font-family:'Bebas Neue',sans-serif; font-size:1rem; letter-spacing:0.06em;">
                    BPK. AHMAD HENDRA
                </div>
                <div style="font-size:0.68rem; color:#555; margin-top:0.25rem;">
                    MEKANIK BERSERTIFIKAT
                </div>
            </div>

            <div style="padding:1.5rem;">
                <div style="font-family:'Bebas Neue',sans-serif; font-size:1.1rem;
                             margin-bottom:0.75rem; letter-spacing:0.06em;">
                    TENTANG PAKAR DOMAIN
                </div>
                <p style="font-size:0.8rem; line-height:1.8; color:#333;">
                    Basis pengetahuan sistem ini disusun berdasarkan pengalaman dan keahlian
                    <strong>Bpk. Ahmad Hendra, S.T.</strong>, mekanik berlisensi Astra Honda Motor
                    dengan pengalaman lebih dari 15 tahun dalam menangani kendaraan bermotor
                    roda dua, khususnya mesin 4-tak Honda dan Yamaha.
                </p>
                <p style="font-size:0.8rem; line-height:1.8; color:#333; margin-top:0.75rem;">
                    Seluruh aturan IF-THEN beserta nilai MB dan MD ditetapkan melalui sesi
                    wawancara terstruktur dan validasi lapangan menggunakan 20 kasus nyata
                    dari bengkel praktis.
                </p>
                <div style="display:flex; gap:1rem; flex-wrap:wrap; margin-top:1rem;">
                    <div style="padding:0.6rem 1rem; background: var(--black); color:var(--yellow);
                                 font-size:0.72rem; font-weight:700; letter-spacing:0.1em;
                                 text-transform:uppercase;">
                        15+ TAHUN PENGALAMAN
                    </div>
                    <div style="padding:0.6rem 1rem; background: var(--green);
                                 border: 2px solid var(--black);
                                 font-size:0.72rem; font-weight:700; letter-spacing:0.1em;
                                 text-transform:uppercase;">
                        LISENSI AHM RESMI
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- DISCLAIMER -->
    <div class="nb-alert nb-alert-warn mb-5">
        <div class="nb-alert-title">DISCLAIMER / PENYANGKALAN</div>
        PakarMatik memberikan diagnosis yang bersifat rekomendatif dan edukatif semata.
        Hasil diagnosis tidak menggantikan pemeriksaan langsung oleh teknisi berlisensi.
        Selalu konsultasikan kendaraan Anda dengan mekanik profesional sebelum melakukan
        perbaikan. Pihak pengembang tidak bertanggung jawab atas kerusakan yang timbul
        akibat penggunaan hasil diagnosis sistem ini tanpa konfirmasi ahli.
    </div>

    <!-- CTA -->
    <div style="background: var(--black); border: var(--border); box-shadow: var(--shadow-lg);
                padding: 2.5rem; text-align: center;">
        <div style="font-family:'Bebas Neue',sans-serif; font-size:2rem; color: var(--white);
                     letter-spacing:0.06em; margin-bottom:0.5rem;">
            SIAP MENDIAGNOSIS KENDARAAN ANDA?
        </div>
        <p style="color:rgba(255,255,255,0.55); font-size:0.8rem; margin-bottom:1.5rem;">
            PILIH GEJALA YANG DIAMATI DAN DAPATKAN HASIL DIAGNOSIS DALAM HITUNGAN DETIK.
        </p>
        <a href="{{ route('diagnosa.index') }}" class="nb-btn" style="font-size:1rem; padding:1rem 2.5rem;">
            MULAI DIAGNOSIS SEKARANG
        </a>
    </div>

</div>
@endsection