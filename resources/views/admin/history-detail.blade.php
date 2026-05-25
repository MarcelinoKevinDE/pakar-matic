@extends('layouts.app')

@section('title', 'Detail Diagnosis #' . $record->id . ' — Admin')

@section('content')

<div class="nb-hero">
    <div class="nb-container">
        <div style="display:flex; align-items:center; gap:1rem; margin-bottom:0.5rem;">
            <a href="{{ route('admin.history') }}"
               class="nb-btn nb-btn-sm"
               style="background: var(--yellow); font-size:0.72rem;">
                KEMBALI
            </a>
            <span style="color:rgba(255,255,255,0.4); font-size:0.72rem;">
                RIWAYAT / DETAIL
            </span>
        </div>
        <h1 class="nb-hero-title">DETAIL DIAGNOSIS <span>#{{ $record->id }}</span></h1>
        <p class="nb-hero-sub">
            DICATAT: {{ $record->created_at->format('d M Y, H:i') }} WIB
        </p>
    </div>
</div>

<div class="nb-container py-5">

    @php $top = $record->top_result; @endphp

    <div class="grid cols-6-4 g-4">

        <!-- LEFT: RESULTS & STEPS -->
        <div>

            <!-- Top result banner -->
            @if($top)
                <div style="background: var(--black); border: var(--border);
                            box-shadow: var(--shadow); padding: 1.5rem; margin-bottom: 1.5rem;">
                    <div style="font-size:0.68rem; font-weight:700; letter-spacing:0.12em;
                                text-transform:uppercase; color:rgba(255,255,255,0.5);
                                margin-bottom:0.4rem;">
                        DIAGNOSIS UTAMA
                    </div>
                    <div style="font-family:'Bebas Neue',sans-serif; font-size:2rem;
                                color: var(--yellow); letter-spacing:0.06em; line-height:1.1;
                                margin-bottom:0.75rem;">
                        {{ $top['nama_kerusakan'] }}
                    </div>
                    <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
                        <div style="font-family:'Bebas Neue',sans-serif; font-size:2.5rem;
                                    color: var(--white); line-height:1;">
                            {{ number_format($top['persen'] ?? ($top['cf'] * 100), 1) }}%
                        </div>
                        <div>
                            <div style="font-size:0.72rem; color:rgba(255,255,255,0.5);
                                        text-transform:uppercase; letter-spacing:0.1em;">
                                CF = {{ $top['cf'] }}
                            </div>
                            <span class="nb-badge {{ $record->badge_class }}" style="margin-top:0.3rem; display:inline-block;">
                                {{ $record->confidence_level }}
                            </span>
                        </div>
                    </div>
                    @if(!empty($top['solusi']))
                        <div style="margin-top:1rem; padding-top:1rem;
                                    border-top: 2px solid #333;
                                    font-size:0.78rem; color:rgba(255,255,255,0.7);
                                    line-height:1.7;">
                            <span style="font-size:0.65rem; text-transform:uppercase;
                                         letter-spacing:0.1em; color:rgba(255,255,255,0.4);
                                         display:block; margin-bottom:0.25rem;">
                                SOLUSI / REKOMENDASI:
                            </span>
                            {{ $top['solusi'] }}
                        </div>
                    @endif
                </div>
            @endif

            <!-- All hasil -->
            @if(!empty($record->hasil_diagnosa) && count($record->hasil_diagnosa) > 1)
                <div class="nb-section-header">SEMUA KANDIDAT KERUSAKAN</div>
                <div style="border: var(--border); border-top:none; margin-bottom: 1.5rem;">
                    @foreach ($record->hasil_diagnosa as $i => $item)
                        <div style="padding: 0.75rem 1rem; border-bottom: 2px solid #e8e8e0;
                                    background: {{ $i === 0 ? 'var(--yellow)' : 'var(--white)' }};
                                    display:flex; justify-content:space-between; align-items:center;">
                            <div style="font-size:0.8rem; font-weight:700;">
                                {{ $i + 1 }}. {{ $item['nama_kerusakan'] }}
                            </div>
                            <div style="text-align:right;">
                                <span class="nb-badge {{ $item['level'] === 'SANGAT TINGGI' ? 'badge-high' :
                                                        ($item['level'] === 'TINGGI' ? 'badge-med-high' :
                                                        ($item['level'] === 'SEDANG' ? 'badge-medium' : 'badge-low')) }}">
                                    {{ $item['level'] }}
                                </span>
                                <div style="font-size:0.72rem; font-family:'IBM Plex Mono',monospace; margin-top:0.2rem;">
                                    CF = {{ $item['cf'] }} ({{ $item['persen'] ?? round($item['cf']*100,2) }}%)
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- CF Calculation Steps -->
            @if(!empty($record->cf_calculation_steps))
                <div class="nb-section-header">LOG PERHITUNGAN CF (AUDIT)</div>
                <div style="border: var(--border); border-top: none;">
                    @foreach ($record->cf_calculation_steps as $kerusakanId => $data)
                        <div style="padding: 0.6rem 1rem; background: #f0f0e8;
                                    border-bottom: 2px solid var(--black);
                                    font-family:'Bebas Neue',sans-serif; font-size:1rem;
                                    letter-spacing:0.06em;">
                            {{ $data['nama_kerusakan'] ?? 'ID: '.$kerusakanId }}
                        </div>
                        @if(!empty($data['steps']))
                            @foreach ($data['steps'] as $si => $step)
                                <div class="nb-step">
                                    <div class="nb-step-num">{{ str_pad($si + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                    <div class="nb-step-body">
                                        <strong>{{ $step['nama_gejala'] }}</strong>
                                        &nbsp;&nbsp;MB={{ $step['mb'] }} &nbsp; MD={{ $step['md'] }}
                                        &nbsp; CF_rule={{ $step['cf_rule'] }}
                                        <div class="nb-step-formula">{{ $step['formula'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            @endif

        </div>

        <!-- RIGHT: SESSION INFO & SYMPTOMS -->
        <div>

            <!-- Session info -->
            <div class="nb-section-header">INFORMASI SESI</div>
            <div style="border: var(--border); border-top: none; margin-bottom: 1.5rem;">
                @php
                    $rows = [
                        ['NAMA PENGGUNA',  $record->nama_user ?? '—'],
                        ['IP ADDRESS',     $record->ip_address ?? '—'],
                        ['DICATAT PADA',   $record->created_at->format('d M Y, H:i:s')],
                        ['JML GEJALA',     count($record->gejala_dipilih) . ' gejala dipilih'],
                        ['JML KANDIDAT',   count($record->hasil_diagnosa ?? []) . ' kerusakan'],
                    ];
                @endphp
                @foreach ($rows as [$label, $value])
                    <div style="display:flex; justify-content:space-between;
                                padding: 0.65rem 1rem; border-bottom: 2px solid #e8e8e0;
                                font-size: 0.78rem; background: var(--white);">
                        <span style="color:#666; font-size:0.68rem; font-weight:700;
                                     text-transform:uppercase; letter-spacing:0.1em;">
                            {{ $label }}
                        </span>
                        <span style="font-weight:600; text-align:right;">{{ $value }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Selected symptoms -->
            <div class="nb-section-header">
                GEJALA YANG DIPILIH ({{ count($record->gejala_dipilih) }})
            </div>
            <div style="border: var(--border); border-top: none;">
                @foreach ($record->gejala_dipilih as $gejalaId)
                    <div style="padding: 0.6rem 1rem; border-bottom: 2px solid #e8e8e0;
                                background: var(--white); font-size: 0.78rem;
                                display:flex; gap:0.5rem; align-items:flex-start;">
                        <span style="color: var(--green); font-weight:700; flex-shrink:0;">[OK]</span>
                        <span>Gejala ID: {{ $gejalaId }}</span>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <!-- BACK -->
    <div style="margin-top: 2rem;">
        <a href="{{ route('admin.history') }}" class="nb-btn nb-btn-black">
            KEMBALI KE RIWAYAT
        </a>
        <a href="{{ route('admin.dashboard') }}" class="nb-btn nb-btn-outline" style="margin-left:0.75rem;">
            KE DASHBOARD
        </a>
    </div>

</div>
@endsection