<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Federation extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomFed',
        'id_cont',
    ];
    public function contact()
    {
        return $this->belongsTo(Contact::class,'id_cont');
    }
    public function districts()
    {
        return $this->hasMany(District::class,'id_fed');
    }
}
