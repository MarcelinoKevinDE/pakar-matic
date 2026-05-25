<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kerusakan extends Model
{
    use HasFactory;

    protected $table = 'kerusakans';

    protected $fillable = [
        'nama_kerusakan',
        'solusi',
    ];

    public function rules(): HasMany
    {
        return $this->hasMany(Rule::class, 'kerusakan_id');
    }
}