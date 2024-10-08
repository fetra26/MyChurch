<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'adresse',
        'email',
        'telMobile',
        'telFixe',
        'BP',
        'codePost',
    ];

    public function eglise()
    {
        return $this->hasOne(Eglise::class,'id_cont');
    }
    public function membre()
    {
        return $this->hasOne(Membre::class,'id_cont');
    }
    public function mission()
    {
        return $this->hasOne(Mission::class,'id_cont');
    }
    public function federation()
    {
        return $this->hasOne(Federation::class,'id_cont');
    }

}
