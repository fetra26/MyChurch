<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomDist',
        'id_fed',
        'id_miss',
    ];
    public function eglises(): HasMany
    {
        return $this->hasMany(Eglise::class,'id_dist');
    }
    public function mission()
    {
        return $this->belongsTo(Mission::class,'id_miss');
    }
    public function federation()
    {
        return $this->belongsTo(Federation::class,'id_fed');
    }

    public function pasteurs(): BelongsToMany
    {
        return $this->belongsToMany(Membre::class, 'pasteur_districts', 'id_pst', 'id_dist')
                    ->withPivot('dateDebut', 'dateFin')
                    ->withTimestamps();
    }
}
