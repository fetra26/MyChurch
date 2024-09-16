<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'datenais',
        'id_eglise',
        'id_stat',
    ];
    public function baptemes()
    {
        return $this->hasMany('App\Models\Bapteme');
    }
    public function pstBaptemes()
    {
        return $this->hasMany('App\Models\Bapteme');
    }
}
