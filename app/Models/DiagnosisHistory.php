<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosisHistory extends Model
{
    use HasFactory;

    protected $table = 'diagnosis_histories';

    protected $fillable = [
        'nama_user', 
        'selected_symptoms', 
        'symptom_details',
        'kerusakan_id', 
        'kerusakan_name', 
        'certainty_factor', 
        'confidence_level', 
        'cf_calculation_steps',
        'ip_address', // Tambahkan ini
        'user_agent'  // Tambahkan ini
    ];

    protected $casts = [
        'selected_symptoms'    => 'array', // Sesuaikan dengan nama kolom yang benar
        'symptom_details'      => 'array', 
        'cf_calculation_steps' => 'array',
    ];

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    /**
     * Return the top result from hasil_diagnosa (highest CF entry).
     */
    public function getTopResultAttribute(): ?array
    {
        $hasil = $this->hasil_diagnosa;
        return !empty($hasil) ? $hasil[0] : null;
    }

    /**
     * Confidence level label derived from the top result CF value.
     */
    public function getConfidenceLevelAttribute(): string
    {
        $top = $this->top_result;
        if (!$top) return 'TIDAK DIKETAHUI';
        return self::deriveLevel((float) ($top['cf'] ?? 0));
    }

    /**
     * Bootstrap badge colour class for the confidence level.
     */
    public function getBadgeClassAttribute(): string
    {
        return match ($this->confidence_level) {
            'SANGAT TINGGI' => 'badge-high',
            'TINGGI'        => 'badge-med-high',
            'SEDANG'        => 'badge-medium',
            default         => 'badge-low',
        };
    }

    // -------------------------------------------------------------------------
    // Static helpers
    // -------------------------------------------------------------------------

    public static function deriveLevel(float $cf): string
    {
        if ($cf >= 0.8) return 'SANGAT TINGGI';
        if ($cf >= 0.6) return 'TINGGI';
        if ($cf >= 0.4) return 'SEDANG';
        return 'RENDAH';
    }

    /**
     * Top N most frequently diagnosed kerusakan names with counts.
     */
    public static function topKerusakan(int $limit = 10): \Illuminate\Support\Collection
    {
        return static::query()
            ->get()
            ->map(function ($record) {
                $top = $record->top_result;
                return $top ? $top['nama_kerusakan'] : null;
            })
            ->filter()
            ->countBy()
            ->sortDesc()
            ->take($limit);
    }

    /**
     * Daily count for the last N days.
     */
    public static function dailyTrend(int $days = 30): \Illuminate\Support\Collection
    {
        return static::query()
            ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
    }
}