<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rule extends Model
{
    use HasFactory;

    protected $table = 'rules';

    protected $fillable = [
        'gejala_id',
        'kerusakan_id',
        'mb',
        'md',
    ];

    protected $casts = [
        'mb' => 'float',
        'md' => 'float',
    ];

    public function gejala(): BelongsTo
    {
        return $this->belongsTo(Gejala::class, 'gejala_id');
    }

    public function kerusakan(): BelongsTo
    {
        return $this->belongsTo(Kerusakan::class, 'kerusakan_id');
    }

    /**
     * CF for a rule = MB - MD
     */
    public function getCfAttribute(): float
    {
        return $this->mb - $this->md;
    }
}