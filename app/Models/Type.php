<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelleType'
    ];
    public function eglises()
    {
        return $this->hasMany(Eglise::class,'id_type');
    }
}
