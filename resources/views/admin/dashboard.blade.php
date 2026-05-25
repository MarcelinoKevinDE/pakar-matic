@extends('layouts.app')

@section('title', 'Admin Dashboard — PakarMatik')

@section('content')

<!-- HERO -->
<div class="nb-hero">
    <div class="nb-container">
        <h1 class="nb-hero-title">ADMIN <span>DASHBOARD</span></h1>
        <p class="nb-hero-sub">STATISTIK PENGGUNAAN SISTEM PAKAR KERUSAKAN MOTOR</p>
    </div>
</div>

<div class="nb-container py-5">

    <!-- STAT CARDS -->
    <div class="grid cols-4 g-3 mb-5">

        <div class="nb-stat" style="background: var(--yellow);">
            <div class="nb-stat-value">{{ number_format($totalDiagnosis) }}</div>
            <div class="nb-stat-label">TOTAL DIAGNOSIS</div>
        </div>

        <div class="nb-stat nb-card-black">
            <div class="nb-stat-value" style="color: var(--yellow);">
                {{ number_format($hariIni) }}
            </div>
            <div class="nb-stat-label">DIAGNOSIS HARI INI</div>
        </div>

        <div class="nb-stat" style="background: var(--green);">
            <div class="nb-stat-value">{{ number_format($totalKerusakan) }}</div>
            <div class="nb-stat-label">JENIS KERUSAKAN</div>
        </div>

        <div class="nb-stat" style="background: var(--blue); color: var(--white);">
            <div class="nb-stat-value">{{ number_format($totalGejala) }}</div>
            <div class="nb-stat-label">JENIS GEJALA</div>
        </div>

    </div>

    <!-- CHARTS ROW -->
    <div class="grid cols-7-5 g-4 mb-5">

        <!-- BAR CHART: Top Damages -->
        <div>
            <div class="nb-section-header">FREKUENSI KERUSAKAN TERBANYAK (TOP 10)</div>
            <div class="nb-card" style="border-top: none; padding: 1.5rem;">
                <canvas id="barChart" height="280"></canvas>
            </div>
        </div>

        <!-- DOUGHNUT: Confidence Distribution -->
        <div>
            <div class="nb-section-header">DISTRIBUSI TINGKAT KEPERCAYAAN</div>
            <div class="nb-card" style="border-top: none; padding: 1.5rem; min-height: 320px;
                                        display: flex; flex-direction: column;
                                        align-items: center; justify-content: center; gap: 1rem;">
                <canvas id="doughnutChart" width="220" height="220"
                        style="max-width:220px;"></canvas>
                <div style="display:flex; flex-wrap:wrap; gap:0.5rem; justify-content:center;">
                    @foreach ($confidenceDist as $level => $count)
                        <span class="nb-badge
                            {{ $level === 'SANGAT TINGGI' ? 'badge-high' :
                              ($level === 'TINGGI' ? 'badge-med-high' :
                              ($level === 'SEDANG' ? 'badge-medium' : 'badge-low')) }}">
                            {{ $level }}: {{ $count }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <!-- LINE CHART: Daily Trend -->
    <div class="mb-5">
        <div class="nb-section-header flex-between">
            <span>TREN DIAGNOSIS HARIAN</span>
            <span style="font-size:0.72rem; color:var(--yellow); font-family:'IBM Plex Mono',monospace;">
                30 HARI TERAKHIR
            </span>
        </div>
        <div class="nb-card" style="border-top:none; padding: 1.5rem;">
            <canvas id="lineChart" height="160"></canvas>
        </div>
    </div>

    <!-- RECENT TABLE -->
    <div>
        <div class="nb-section-header flex-between">
            <span>RIWAYAT DIAGNOSIS TERBARU</span>
            <a href="{{ route('admin.history') }}"
               style="font-family:'IBM Plex Mono',monospace; font-size:0.7rem;
                      color:var(--yellow); text-decoration:none; font-weight:700;
                      letter-spacing:0.08em;">
                LIHAT SEMUA
            </a>
        </div>

        <div style="border: var(--border); border-top:none; overflow-x:auto;">
            <table class="nb-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>KERUSAKAN</th>
                        <th>CF</th>
                        <th>LEVEL</th>
                        <th>GEJALA</th>
                        <th>PENGGUNA</th>
                        <th>TANGGAL</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentDiagnosis as $record)
                        @php $top = $record->top_result; @endphp
                        <tr>
                            <td style="color:#888; font-size:0.72rem;">#{{ $record->id }}</td>
                            <td style="font-weight:700; font-size:0.8rem;">
                                {{ $top ? $top['nama_kerusakan'] : '—' }}
                            </td>
                            <td style="font-family:'IBM Plex Mono',monospace; font-size:0.75rem;">
                                {{ $top ? $top['cf'] : '—' }}
                            </td>
                            <td>
                                <span class="nb-badge {{ $record->badge_class }}">
                                    {{ $record->confidence_level }}
                                </span>
                            </td>
                            <td style="font-size:0.78rem;">
                                {{ count($record->gejala_dipilih) }} gejala
                            </td>
                            <td style="font-size:0.78rem;">
                                {{ $record->nama_user ?? '—' }}
                            </td>
                            <td style="font-size:0.72rem; color:#666; white-space:nowrap;">
                                {{ $record->created_at->format('d M Y') }}<br>
                                <span style="opacity:0.65;">{{ $record->created_at->format('H:i') }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.history.show', $record) }}"
                                   class="nb-btn nb-btn-sm nb-btn-black">
                                    DETAIL
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:2rem;
                                                   color:#888; font-size:0.8rem;">
                                BELUM ADA DATA DIAGNOSIS.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const BLACK  = '#0a0a0a';
    const YELLOW = '#FFE047';
    const RED    = '#FF3B2F';
    const BLUE   = '#1A5CFF';
    const GREEN  = '#00C060';
    const ORANGE = '#FF7020';

    const PALETTE = [YELLOW, RED, BLUE, GREEN, ORANGE,
                     '#FF9500','#AF52DE','#32ADE6','#30B0C7','#34C759'];

    Chart.defaults.font.family = "'IBM Plex Mono', monospace";
    Chart.defaults.font.size   = 11;

    // ---------------------------------------------------------------
    // 1. BAR CHART — Top Damages
    // ---------------------------------------------------------------
    const barLabels = @json($chartLabels);
    const barData   = @json($chartData);

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                label: 'Jumlah Diagnosis',
                data: barData,
                backgroundColor: barLabels.map((_, i) => PALETTE[i % PALETTE.length]),
                borderColor: BLACK,
                borderWidth: 2,
                borderRadius: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: BLACK,
                    titleColor: YELLOW,
                    bodyColor: '#fff',
                    borderColor: BLACK,
                    borderWidth: 2,
                    callbacks: {
                        label: ctx => '  ' + ctx.parsed.y + ' kasus'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, color: '#555' },
                    grid: { color: '#e0e0d8', lineWidth: 1 },
                    border: { color: BLACK, width: 2 }
                },
                x: {
                    ticks: { maxRotation: 30, color: '#555', font: { size: 10 } },
                    grid: { display: false },
                    border: { color: BLACK, width: 2 }
                }
            }
        }
    });

    // ---------------------------------------------------------------
    // 2. DOUGHNUT — Confidence Level Distribution
    // ---------------------------------------------------------------
    const confLabels = @json($confidenceDist->keys()->values());
    const confValues = @json($confidenceDist->values()->values());
    const confColors = {
        'SANGAT TINGGI': GREEN,
        'TINGGI':        BLUE,
        'SEDANG':        YELLOW,
        'RENDAH':        '#aaaaaa',
    };

    new Chart(document.getElementById('doughnutChart'), {
        type: 'doughnut',
        data: {
            labels: confLabels,
            datasets: [{
                data: confValues,
                backgroundColor: confLabels.map(l => confColors[l] || '#ccc'),
                borderColor: BLACK,
                borderWidth: 3,
            }]
        },
        options: {
            responsive: false,
            cutout: '62%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: BLACK,
                    titleColor: YELLOW,
                    bodyColor: '#fff',
                    callbacks: {
                        label: ctx => ' ' + ctx.label + ': ' + ctx.parsed + ' kasus'
                    }
                }
            }
        }
    });

    // ---------------------------------------------------------------
    // 3. LINE CHART — Daily Trend
    // ---------------------------------------------------------------
    const trendLabels = @json($trendLabels);
    const trendData   = @json($trendData);

    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Diagnosis',
                data: trendData,
                borderColor: RED,
                backgroundColor: 'rgba(255,59,47,0.08)',
                borderWidth: 3,
                fill: true,
                tension: 0.35,
                pointRadius: 5,
                pointBackgroundColor: RED,
                pointBorderColor: BLACK,
                pointBorderWidth: 2,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: BLACK,
                    titleColor: YELLOW,
                    bodyColor: '#fff',
                    callbacks: {
                        label: ctx => '  ' + ctx.parsed.y + ' diagnosis'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, color: '#555' },
                    grid: { color: '#e0e0d8' },
                    border: { color: BLACK, width: 2 }
                },
                x: {
                    ticks: { maxRotation: 0, color: '#555', font: { size: 10 } },
                    grid: { display: false },
                    border: { color: BLACK, width: 2 }
                }
            }
        }
    });
});
</script>
@endpush