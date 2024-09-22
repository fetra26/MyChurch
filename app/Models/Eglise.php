<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eglise extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomEglise',
        'id_type',
        'id_cont',
        'id_dist',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
    public function membres()
    {
        return $this->hasMany(Membre::class,'id_eglise');
    }
}
