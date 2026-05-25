<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiagnosisHistory;
use App\Models\Gejala;
use App\Models\Kerusakan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    // -------------------------------------------------------------------------
    // Main dashboard
    // -------------------------------------------------------------------------

    public function index(): View
    {
        $totalDiagnosis  = DiagnosisHistory::count();
        $totalKerusakan  = Kerusakan::count();
        $totalGejala     = Gejala::count();
        $hariIni         = DiagnosisHistory::whereDate('created_at', today())->count();

        // Bar chart — top damages
        $topKerusakan    = DiagnosisHistory::topKerusakan(10);
        $chartLabels     = $topKerusakan->keys()->values();
        $chartData       = $topKerusakan->values();

        // Line chart — daily trend last 30 days
        $trend           = DiagnosisHistory::dailyTrend(30);
        $trendLabels     = $trend->pluck('tanggal');
        $trendData       = $trend->pluck('total');

        // Recent 15 records
        $recentDiagnosis = DiagnosisHistory::latest()->limit(15)->get();

        // Confidence distribution
        $confidenceDist  = DiagnosisHistory::latest()
            ->get()
            ->map(fn($r) => $r->confidence_level)
            ->countBy()
            ->sortDesc();

        return view('admin.dashboard', compact(
            'totalDiagnosis',
            'totalKerusakan',
            'totalGejala',
            'hariIni',
            'chartLabels',
            'chartData',
            'trendLabels',
            'trendData',
            'recentDiagnosis',
            'confidenceDist'
        ));
    }

    // -------------------------------------------------------------------------
    // Full history with filters
    // -------------------------------------------------------------------------

    public function history(Request $request): View
    {
        $query = DiagnosisHistory::latest();

        if ($search = $request->input('search')) {
            // Search inside JSON column for kerusakan name
            $query->where(function ($q) use ($search) {
                $q->where('nama_user', 'like', "%{$search}%")
                  ->orWhere('hasil_diagnosa', 'like', "%{$search}%");
            });
        }

        if ($from = $request->input('dari')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->input('sampai')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $histories = $query->paginate(20)->withQueryString();

        return view('admin.history', compact('histories'));
    }

    // -------------------------------------------------------------------------
    // Single diagnosis detail
    // -------------------------------------------------------------------------

    public function historyShow(DiagnosisHistory $diagnosisHistory): View
    {
        return view('admin.history-detail', ['record' => $diagnosisHistory]);
    }
}