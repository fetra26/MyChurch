<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceMembre extends Model
{
    use HasFactory;
    protected $fillable = [
        'dateDebutServ',
        'dateFinServ',
        'id_membre',
        'id_serv',
    ];
}
