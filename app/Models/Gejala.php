<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gejala extends Model
{
    use HasFactory;

    protected $table = 'gejalas'; 

    protected $fillable = [
        'kode_gejala',
        'nama_gejala',
    ];

    public function rules(): HasMany
    {
        return $this->hasMany(Rule::class, 'gejala_id');
    }
}