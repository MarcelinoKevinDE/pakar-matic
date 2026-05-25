<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiagnosaRequest;
use App\Models\DiagnosisHistory;
use App\Models\Gejala;
use App\Models\Rule;
use Illuminate\View\View;

class DiagnosaController extends Controller
{
    // -------------------------------------------------------------------------
    // Show diagnosis form
    // -------------------------------------------------------------------------

    public function index(): View
    {
        $gejalas = Gejala::orderBy('kode_gejala')->get();

        return view('diagnosa.index', compact('gejalas'));
    }

    // -------------------------------------------------------------------------
    // Process diagnosis — Certainty Factor engine
    // -------------------------------------------------------------------------

    public function proses(DiagnosaRequest $request): View
    {
        $validated   = $request->validated();
        $selectedIds = $validated['gejala'];
        $namaUser    = $validated['nama_user'] ?? null;
        
        // Ambil array bobot dari form, default ke array kosong jika tidak ada
        $cfUserInputs = $request->input('cf_user', []);

        // Fetch matching rules with their relationships
        $rules = Rule::with(['gejala', 'kerusakan'])
            ->whereIn('gejala_id', $selectedIds)
            ->get();

        if ($rules->isEmpty()) {
            return view('diagnosa.hasil', [
                'hasil'        => [],
                'namaUser'     => $namaUser,
                'gejalaDipilih'=> Gejala::whereIn('id', $selectedIds)->get(),
                'noRule'       => true,
            ]);
        }

        // -----------------------------------------------------------------
        // Certainty Factor combination formula:
        //   CF(A, B) = CF(A) + CF(B) * (1 - CF(A))
        // where CF per rule = (MB - MD) * User_Confidence
        // -----------------------------------------------------------------

        $grouped         = $rules->groupBy('kerusakan_id');
        $hasil           = [];
        $cfSteps         = [];

        foreach ($grouped as $kerusakanId => $groupRules) {
            $kerusakan  = $groupRules->first()->kerusakan;
            $cfCombined = 0.0;
            $steps      = [];

            foreach ($groupRules as $rule) {
                $mb      = (float) $rule->mb;
                $md      = (float) $rule->md;
                
                // Ambil keyakinan user (default 1.0 / Sangat Yakin)
                $bobotUser = (float) ($cfUserInputs[$rule->gejala_id] ?? 1.0);
                
                $cfRule  = ($mb - $md) * $bobotUser; 
                $cfPrev  = $cfCombined;

                $cfCombined = $cfPrev + $cfRule * (1 - $cfPrev);

                $steps[] = [
                    'nama_gejala' => $rule->gejala->nama_gejala ?? '-',
                    'mb'          => $mb,
                    'md'          => $md,
                    'bobot_user'  => $bobotUser,
                    'cf_rule'     => round($cfRule, 4),
                    'cf_prev'     => round($cfPrev, 4),
                    'cf_new'      => round($cfCombined, 4),
                    'formula'     => sprintf(
                        'CF = %.4f + ((%.4f - %.4f) * %.2f) x (1 - %.4f) = %.4f',
                        $cfPrev, $mb, $md, $bobotUser, $cfPrev, $cfCombined
                    ),
                ];
            }

            $cfFinal = max(0.0, min(1.0, $cfCombined));
            $percent = round($cfFinal * 100, 2);

            // Filter: Hanya masukkan hasil yang CF-nya >= 0.1 (signifikan)
            if ($cfFinal >= 0.1) {
                $hasil[] = [
                    'kerusakan_id'   => $kerusakanId,
                    'nama_kerusakan' => $kerusakan->nama_kerusakan,
                    'solusi'         => $kerusakan->solusi,
                    'cf'             => round($cfFinal, 4),
                    'persen'         => $percent,
                    'level'          => DiagnosisHistory::deriveLevel($cfFinal),
                ];

                $cfSteps[$kerusakanId] = [
                    'nama_kerusakan' => $kerusakan->nama_kerusakan,
                    'steps'          => $steps,
                ];
            }
        }

        // Sort by CF descending
        usort($hasil, fn($a, $b) => $b['cf'] <=> $a['cf']);

        $gejalaDipilih = Gejala::whereIn('id', $selectedIds)->get();

        // Persist history (hanya jika ada hasil yang ditemukan)
        if (!empty($hasil)) {
            DiagnosisHistory::create([
                'nama_user'            => $request->nama_user,
                'gejala_dipilih'       => json_encode($gejalaDipilih), // Nama kolom baru sesuai migrasi
                'hasil_diagnosa'       => json_encode($hasil),         // Nama kolom baru sesuai migrasi
                'cf_calculation_steps' => json_encode($cfSteps),
                'ip_address'           => $request->ip(),
                'user_agent'           => $request->userAgent(),
            ]);
        }

        return view('diagnosa.hasil', [
            'hasil'         => $hasil,
            'namaUser'      => $namaUser,
            'gejalaDipilih' => $gejalaDipilih,
            'cfSteps'       => $cfSteps,
            'noRule'        => empty($hasil),
        ]);
    }

    // -------------------------------------------------------------------------
    // About page
    // -------------------------------------------------------------------------

    public function about(): View
    {
        return view('pages.about');
    }
}