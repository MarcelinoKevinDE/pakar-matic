@extends('layouts.app')

@section('title', 'Riwayat Diagnosis — Admin PakarMatik')

@section('content')

<div class="nb-hero">
    <div class="nb-container">
        <h1 class="nb-hero-title">RIWAYAT <span>DIAGNOSIS</span></h1>
        <p class="nb-hero-sub">SEMUA SESI DIAGNOSIS YANG TERCATAT DALAM SISTEM</p>
    </div>
</div>

<div class="nb-container py-5">

    <!-- FILTER -->
    <div class="nb-section-header">FILTER & PENCARIAN</div>
    <div class="nb-card" style="border-top: none; margin-bottom: 2rem;">
        <form method="GET" action="{{ route('admin.history') }}">
            <div class="grid cols-4 g-3">
                <div>
                    <label class="nb-label">CARI NAMA / KERUSAKAN</label>
                    <input type="text" name="search" class="nb-input"
                           placeholder="KETIK KATA KUNCI..."
                           value="{{ request('search') }}">
                </div>
                <div>
                    <label class="nb-label">DARI TANGGAL</label>
                    <input type="date" name="dari" class="nb-input"
                           value="{{ request('dari') }}">
                </div>
                <div>
                    <label class="nb-label">SAMPAI TANGGAL</label>
                    <input type="date" name="sampai" class="nb-input"
                           value="{{ request('sampai') }}">
                </div>
                <div style="display:flex; align-items:flex-end; gap:0.5rem;">
                    <button type="submit" class="nb-btn w-100">FILTER</button>
                    <a href="{{ route('admin.history') }}"
                       class="nb-btn nb-btn-outline" style="white-space:nowrap;">X</a>
                </div>
            </div>
        </form>
    </div>

    <!-- TABLE -->
    <div class="nb-section-header flex-between">
        <span>{{ $histories->total() }} RECORD DITEMUKAN</span>
        <span style="font-size:0.72rem; color:var(--yellow); font-family:'IBM Plex Mono',monospace;">
            HALAMAN {{ $histories->currentPage() }} DARI {{ $histories->lastPage() }}
        </span>
    </div>

    <div style="border: var(--border); border-top:none; overflow-x: auto;">
        <table class="nb-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>KERUSAKAN TERDIAGNOSIS</th>
                    <th>CF</th>
                    <th>LEVEL</th>
                    <th>JML GEJALA</th>
                    <th>NAMA PENGGUNA</th>
                    <th>TANGGAL</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($histories as $record)
                    @php $top = $record->top_result; @endphp
                    <tr>
                        <td style="color:#888; font-size:0.72rem; white-space:nowrap;">#{{ $record->id }}</td>
                        <td style="font-weight:700; font-size:0.8rem;">
                            {{ $top ? $top['nama_kerusakan'] : '—' }}
                        </td>
                        <td style="font-family:'IBM Plex Mono',monospace; font-size:0.75rem;">
                            {{ $top ? $top['cf'] : '—' }}
                            @if($top)
                                <div style="font-size:0.68rem; color:#888;">
                                    {{ $top['persen'] ?? '—' }}%
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="nb-badge {{ $record->badge_class }}">
                                {{ $record->confidence_level }}
                            </span>
                        </td>
                        <td style="font-size:0.8rem; font-weight:700;">
                            {{ count($record->gejala_dipilih) }}
                        </td>
                        <td style="font-size:0.78rem;">
                            {{ $record->nama_user ?? '—' }}
                        </td>
                        <td style="font-size:0.72rem; color:#555; white-space:nowrap;">
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
                        <td colspan="8" style="text-align:center; padding:3rem;
                                               font-size:0.82rem; color:#888;">
                            TIDAK ADA DATA YANG COCOK DENGAN FILTER YANG DIPILIH.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if($histories->hasPages())
        <div style="margin-top: 1.5rem; display:flex; justify-content:space-between;
                    align-items:center; font-size:0.78rem;">
            <span style="color:#666;">
                MENAMPILKAN {{ $histories->firstItem() }}–{{ $histories->lastItem() }}
                DARI {{ $histories->total() }} RECORD
            </span>
            <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
                @if($histories->onFirstPage())
                    <span class="nb-btn nb-btn-sm" style="opacity:0.4; cursor:default;">PREV</span>
                @else
                    <a href="{{ $histories->previousPageUrl() }}" class="nb-btn nb-btn-sm nb-btn-black">
                        PREV
                    </a>
                @endif

                @foreach ($histories->getUrlRange(max(1, $histories->currentPage()-2), min($histories->lastPage(), $histories->currentPage()+2)) as $page => $url)
                    @if($page === $histories->currentPage())
                        <span class="nb-btn nb-btn-sm" style="background:var(--yellow); cursor:default;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="nb-btn nb-btn-sm nb-btn-outline">{{ $page }}</a>
                    @endif
                @endforeach

                @if($histories->hasMorePages())
                    <a href="{{ $histories->nextPageUrl() }}" class="nb-btn nb-btn-sm nb-btn-black">
                        NEXT
                    </a>
                @else
                    <span class="nb-btn nb-btn-sm" style="opacity:0.4; cursor:default;">NEXT</span>
                @endif
            </div>
        </div>
    @endif

</div>
@endsection