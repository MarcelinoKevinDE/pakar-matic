@extends('layouts.app')

@section('title', 'Hasil Diagnosis — PakarMatik')

@push('styles')
<style>
    .result-hero {
        background: var(--yellow);
        border-bottom: var(--border);
        padding: 2rem 0;
    }

    .result-hero-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2rem;
        letter-spacing: 0.06em;
        color: var(--black);
    }

    .big-pct {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 5rem;
        line-height: 1;
        color: var(--black);
    }

    .candidate-row {
        display: flex;
        flex-direction: column;
        gap: 0;
        border: var(--border);
        margin-bottom: 1.5rem;
    }

    .candidate-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        background: var(--black);
        color: var(--white);
    }

    .candidate-bar-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1rem;
        background: var(--white);
        border-top: 2px solid var(--black);
    }

    .candidate-solusi {
        padding: 0.75rem 1rem;
        background: #f5f5ed;
        border-top: 2px solid var(--black);
        font-size: 0.78rem;
        line-height: 1.7;
    }
</style>
@endpush

@section('content')

<!-- HERO -->
<div class="result-hero">
    <div class="nb-container">
        <div class="grid cols-6-4 g-4" style="align-items:center;">
            <div>
                <div style="font-size:0.72rem; font-weight:700; letter-spacing:0.12em;
                            text-transform:uppercase; margin-bottom:0.5rem; opacity:0.65;">
                    HASIL DIAGNOSIS TERBAIK
                </div>

                <div class="result-hero-title">
                    @if(!$noRule && !empty($hasil))
                        {{ $hasil[0]['nama_kerusakan'] }}
                    @else
                        TIDAK DITEMUKAN KERUSAKAN
                    @endif
                </div>

                @if($namaUser)
                    <div class="mt-2 text-sm">
                        PASIEN: <strong>{{ strtoupper($namaUser) }}</strong>
                    </div>
                @endif

                <div class="text-xs text-muted mt-1">
                    {{ now()->format('d M Y, H:i') }} WIB
                </div>
            </div>

            <div style="text-align: right;">
                @if(!$noRule && !empty($hasil))
                    <div class="big-pct">
                        {{ number_format($hasil[0]['persen'], 1) }}%
                    </div>

                    <div style="font-size:0.72rem; font-weight:700; letter-spacing:0.1em;
                                text-transform:uppercase; opacity:0.65; margin-top:0.3rem;">
                        TINGKAT KEPERCAYAAN
                    </div>

                    <span class="nb-badge {{ $hasil[0]['level'] === 'SANGAT TINGGI' ? 'badge-high' :
                                           ($hasil[0]['level'] === 'TINGGI' ? 'badge-med-high' :
                                           ($hasil[0]['level'] === 'SEDANG' ? 'badge-medium' : 'badge-low')) }}
                                           mt-1"
                          style="border-color: var(--black);">
                        {{ $hasil[0]['level'] }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="nb-container py-5">

    @if($noRule || empty($hasil))

        <!-- NO RULE FOUND -->
        <div class="nb-card nb-card-yellow" style="text-align: center; padding: 3rem;">
            <div style="font-family:'Bebas Neue',sans-serif; font-size:2rem; margin-bottom:1rem;">
                TIDAK ADA ATURAN YANG COCOK
            </div>

            <p class="text-sm" style="max-width:480px; margin: 0 auto 1.5rem;">
                Kombinasi gejala yang dipilih tidak sesuai dengan aturan dalam basis pengetahuan.
                Coba pilih gejala yang berbeda atau lebih lengkap.
            </p>

            <a href="{{ route('diagnosa.index') }}" class="nb-btn nb-btn-black">
                COBA LAGI
            </a>
        </div>

    @else

        <div class="grid cols-7-5 g-4">

            <!-- LEFT -->
            <div>

                <div class="nb-section-header">
                    HASIL DIAGNOSA BERDASARKAN GEJALA
                </div>

                @foreach ($gejalaDipilih as $gejala)

                    <div style="margin-bottom:2rem;">

                        <!-- HEADER GEJALA -->
                        <div style="border: var(--border); background: var(--yellow); padding: 1rem;">
                            <div style="font-family:'Bebas Neue',sans-serif;
                                        font-size:1.3rem;
                                        letter-spacing:0.06em;">
                                {{ $gejala->nama_gejala }}
                            </div>

                            <div style="font-size:0.72rem;
                                        font-family:'IBM Plex Mono',monospace;
                                        margin-top:0.2rem;
                                        opacity:0.7;">
                                {{ $gejala->kode_gejala }}
                            </div>
                        </div>

                        @php
                            $kandidatGejala = collect($hasil)->filter(function ($item) use ($cfSteps, $gejala) {

                                if (empty($cfSteps[$item['kerusakan_id']]['steps'])) {
                                    return false;
                                }

                                return collect($cfSteps[$item['kerusakan_id']]['steps'])
                                    ->contains(function ($step) use ($gejala) {

                                        return isset($step['nama_gejala']) &&
                                               trim(strtolower($step['nama_gejala'])) === trim(strtolower($gejala->nama_gejala));

                                    });
                            })->values();
                        @endphp

                        @if($kandidatGejala->count())

                            @foreach ($kandidatGejala as $i => $item)

                                <div class="candidate-row"
                                     style="{{ $i === 0 ? 'border-color: var(--black); box-shadow: var(--shadow-lg);' : '' }}">

                                    <!-- HEADER -->
                                    <div class="candidate-header"
                                         style="{{ $i === 0 ? 'background: var(--black);' : 'background: #333;' }}">

                                        <div style="font-family:'Bebas Neue',sans-serif;
                                                    font-size:1.1rem;
                                                    letter-spacing:0.06em;">
                                            {{ $i + 1 }}. {{ $item['nama_kerusakan'] }}
                                        </div>

                                        <div style="display:flex; align-items:center; gap:0.75rem;">

                                            <span class="nb-badge {{ $item['level'] === 'SANGAT TINGGI' ? 'badge-high' :
                                                                    ($item['level'] === 'TINGGI' ? 'badge-med-high' :
                                                                    ($item['level'] === 'SEDANG' ? 'badge-medium' : 'badge-low')) }}"
                                                  style="border-color:#fff;">
                                                {{ $item['level'] }}
                                            </span>

                                            <span style="font-family:'IBM Plex Mono',monospace;
                                                         font-size:0.82rem;
                                                         font-weight:700;
                                                         color: var(--yellow);">
                                                CF = {{ $item['cf'] }}
                                            </span>

                                        </div>
                                    </div>

                                    <!-- BAR -->
                                    <div class="candidate-bar-row">

                                        <div class="nb-bar-track" style="flex:1;">

                                            <div class="nb-bar-fill
                                                {{ $item['persen'] >= 80 ? 'fill-green' :
                                                  ($item['persen'] >= 60 ? 'fill-blue' :
                                                  ($item['persen'] >= 40 ? '' : 'fill-orange')) }}"
                                                 data-width="{{ $item['persen'] }}%">
                                            </div>

                                        </div>

                                        <span style="font-family:'Bebas Neue',sans-serif;
                                                     font-size:1.4rem;
                                                     min-width:3.5rem;
                                                     text-align:right;">
                                            {{ number_format($item['persen'], 1) }}%
                                        </span>

                                    </div>

                                    <!-- SOLUSI -->
                                    @if(!empty($item['solusi']))
                                        <div class="candidate-solusi">

                                            <span style="font-size:0.68rem;
                                                         font-weight:700;
                                                         letter-spacing:0.1em;
                                                         text-transform:uppercase;
                                                         display:block;
                                                         margin-bottom:0.3rem;">
                                                SOLUSI / REKOMENDASI:
                                            </span>

                                            {{ $item['solusi'] }}

                                        </div>
                                    @endif

                                    <!-- CF STEPS -->
                                    @if(!empty($cfSteps[$item['kerusakan_id']]['steps']))
                                        <div style="border-top: 2px solid var(--black);
                                                    background: var(--white);">

                                            <button type="button"
                                                    onclick="toggleSteps('steps-{{ $gejala->id }}-{{ $item['kerusakan_id'] }}')"
                                                    style="width:100%;
                                                           padding: 0.6rem 1rem;
                                                           background: #f0f0e8;
                                                           border: none;
                                                           font-family:'IBM Plex Mono',monospace;
                                                           font-size:0.72rem;
                                                           font-weight:700;
                                                           letter-spacing:0.1em;
                                                           text-transform:uppercase;
                                                           cursor:pointer;
                                                           text-align:left;">

                                                LIHAT LANGKAH PERHITUNGAN CF
                                                ({{ count($cfSteps[$item['kerusakan_id']]['steps']) }} LANGKAH)

                                            </button>

                                            <div id="steps-{{ $gejala->id }}-{{ $item['kerusakan_id'] }}"
                                                 style="display:none;">

                                                @foreach ($cfSteps[$item['kerusakan_id']]['steps'] as $si => $step)

                                                    <div class="nb-step"
                                                         style="{{ $si === 0 ? 'border-top: 2px solid var(--black);' : '' }}">

                                                        <div class="nb-step-num">
                                                            {{ str_pad($si + 1, 2, '0', STR_PAD_LEFT) }}
                                                        </div>

                                                        <div class="nb-step-body">

                                                            <strong>{{ $step['nama_gejala'] }}</strong>

                                                            &nbsp;&nbsp;
                                                            MB={{ $step['mb'] }}

                                                            &nbsp;
                                                            MD={{ $step['md'] }}

                                                            &nbsp;
                                                            CF_rule={{ $step['cf_rule'] }}

                                                            <div class="nb-step-formula">
                                                                {{ $step['formula'] }}
                                                            </div>

                                                        </div>

                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>
                                    @endif

                                </div>

                            @endforeach

                        @else

                            <div style="border: var(--border);
                                        border-top:none;
                                        padding:1rem;
                                        background: var(--white);
                                        font-size:0.78rem;">

                                Tidak ada kandidat kerusakan yang terkait dengan gejala ini.

                            </div>

                        @endif

                    </div>

                @endforeach

            </div>

            <!-- RIGHT -->
            <div>

                <!-- Selected symptoms -->
                <div class="nb-section-header">
                    GEJALA YANG DIPILIH ({{ $gejalaDipilih->count() }})
                </div>

                <div style="border: var(--border); border-top: none; margin-bottom: 1.5rem;">

                    @foreach ($gejalaDipilih as $g)

                        <div style="padding: 0.6rem 1rem;
                                    border-bottom: 2px solid #e8e8e0;
                                    background: var(--white);
                                    font-size: 0.78rem;
                                    display:flex;
                                    gap:0.5rem;">

                            <span style="color: var(--green); font-weight:700;">
                                [OK]
                            </span>

                            <div>
                                <div>{{ $g->nama_gejala }}</div>
                                <div style="color:#888; font-size:0.68rem;">
                                    {{ $g->kode_gejala }}
                                </div>
                            </div>

                        </div>

                    @endforeach

                </div>

                <!-- CF method info box -->
                <div class="nb-section-header">
                    METODE YANG DIGUNAKAN
                </div>

                <div style="border: var(--border);
                            border-top: none;
                            background: var(--white);
                            padding: 1rem;
                            font-size: 0.78rem;
                            line-height: 1.7;
                            margin-bottom: 1.5rem;">

                    <div style="font-family:'Bebas Neue',sans-serif;
                                font-size:1.1rem;
                                margin-bottom:0.5rem;">

                        CERTAINTY FACTOR

                    </div>

                    Nilai CF dihitung dari MB - MD setiap aturan, lalu digabungkan secara iteratif
                    menggunakan rumus:

                    <div style="background: var(--black);
                                color: var(--yellow);
                                padding: 0.6rem 0.75rem;
                                font-size: 0.72rem;
                                margin: 0.75rem 0;
                                font-family:'IBM Plex Mono',monospace;">

                        CF(A,B) = CF(A) + CF(B) x (1 - CF(A))

                    </div>

                    Kandidat diurutkan dari nilai CF tertinggi ke terendah.

                    <div style="margin-top:0.75rem;">
                        <button type="button"
                                class="nb-btn nb-btn-sm"
                                onclick="openCfModal()">
                            PELAJARI LEBIH LANJUT
                        </button>
                    </div>

                </div>

                <!-- Actions -->
                <div style="display:flex; flex-direction:column; gap:0.6rem;">

                    <a href="{{ route('diagnosa.index') }}"
                       class="nb-btn"
                       style="text-align:center; display:block;">

                        DIAGNOSIS BARU

                    </a>

                    <button onclick="window.print()"
                            class="nb-btn nb-btn-outline"
                            style="cursor:pointer;">

                        CETAK / SIMPAN PDF

                    </button>

                </div>

            </div>

        </div>

    @endif

</div>

@include('partials.cf-modal')

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Animate bars on load
    requestAnimationFrame(() => {

        document.querySelectorAll('.nb-bar-fill').forEach(bar => {
            bar.style.width = bar.dataset.width;
        });

    });

});

function toggleSteps(id) {

    const el = document.getElementById(id);

    if (!el) return;

    el.style.display = el.style.display === 'none'
        ? 'block'
        : 'none';
}

function openCfModal()  {
    document.getElementById('cfModal').classList.add('open');
}

function closeCfModal() {
    document.getElementById('cfModal').classList.remove('open');
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeCfModal();
});
</script>
@endpush