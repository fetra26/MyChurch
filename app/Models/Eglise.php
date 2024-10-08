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

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'id_cont');
    }
    public function type()
    {
        return $this->belongsTo(Type::class, 'id_type');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'id_dist');
    }
    public function membres()
    {
        return $this->hasMany(Membre::class,'id_eglise');
    }
}
