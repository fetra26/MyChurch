<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelleStat'
    ];
    public function membres()
    {
        return $this->hasMany(Membre::class,'id_stat');
    }
}
