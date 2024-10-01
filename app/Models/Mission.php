<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomMiss',
        'id_cont',
    ];
    public function contact()
    {
        return $this->belongsTo(Contact::class,'id_cont');
    }
    public function districts(): HasMany
    {
        return $this->hasMany(District::class,'id_miss');
    }
}
